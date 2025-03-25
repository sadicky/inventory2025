<?php
@session_start();

require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/commande.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/supplier.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/config.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/account.class.php');
require_once('../../Models/Admin/ben.class.php');
require_once('../../Models/Admin/customer.class.php');
require_once('../../Models/Admin/livraison.class.php');
require_once('../../Models/Admin/coupon.class.php');

$achats = new Achat();
$accounts = new Account();
$ben = new Ben();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$details = new detOperation();
$det = new detOperation();
$journals = new Journal();
$operations = new Operation();
$products = new Product();
$periodes = new Periode();
$stores = new POS();
$suppliers = new Supplier();
$users = new User();
$autres = new AutreFrais();
$transactions = new Transactions();
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();
$conf = new Config();
$customers = new Customer();
$ventes = new Vente();
$users = new User();
$livraisons = new Livraison();
$coupons = new Coupon();

?>
<hr>
<div class="row">
  <div class="col-md-8">
    <div class="title m-3" style="text-align: center; font-weight: bold; font-size: 14px;">
      <h3>Les Factures Encours</h3>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-sm tab">
        <thead>
          <tr>
            <th>No Fact</th>
            <th>Date</th>
            <th>Client</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Type</th>
            <th>Etablie par</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $datas = $operations->select_all_facture_no('Vente', $_SESSION['pos']);

          $totM = 0;
          $i = 1;
          foreach ($datas as $key => $value) {
            $pers2 = $users->select($value['user_id']);
            $vente = $ventes->select($value['op_id']);
            $pers = $customers->select($value['party_code']);
            echo '<tr>
						<td><a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="' . $value['op_id'] . '"> ';
            echo '#0000' . $vente->idvente . '</a></td>';
            echo '<td><a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="' . $value['op_id'] . '">' . $value['create_date'] . '</a></td><td>' . @$pers->customer_name . '</td><td align="right"><b>' . number_format($det->select_sum_op($value['op_id']), 0, ',', ' ') . ' FC</b></td>';
            echo '<td>';
            if ($value['ben_id'] == 0) echo '<span class="badge badge-danger">Encours</span>';
            elseif ($value['ben_id'] == 1) echo '<span class="badge badge-success">Validé</span>';
            elseif ($value['ben_id'] == 2) echo '<span class="badge badge-warning">Annuler</span>';
            echo '</td>';
            echo '<td>';
            if ($value['is_paid'] == 0) echo '<b class="text-danger">Dette</b>';
            elseif ($value['is_paid'] == 1) echo '<b class="text-success">Cash</b>';
            elseif ($value['is_paid'] == 2) echo '<b>Proformat</b>';
            echo '</td><td>';
            echo $pers2->noms;
            echo '</td></tr>';
            $totM += $det->select_sum_op($value['op_id']);
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-md-4">
    <div class="title m-3" style="text-align: center; font-weight: bold; font-size: 14px;">
      <h3>Les 10 Dernières Factures enregistrées</h3>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-sm tabx">
        <thead>
          <tr>
            <th>Date</th>
            <th>Client</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Type</th>
            <th>Etablie par</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $datas = $operations->select_all_facture_vente('Vente', $_SESSION['pos']);

          $totM = 0;
          $i = 1;
          foreach ($datas as $key => $value) {
            $pers2 = $users->select($value['user_id']);
            $vente = $ventes->select($value['op_id']);
            $pers = $customers->select($value['party_code']);
            echo '<tr>';
            echo '<td><a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="' . $value['op_id'] . '">' . $value['create_date'] . '</a></td><td>' . @$pers->customer_name . '</td><td align="right"><b>' . number_format($det->select_sum_op($value['op_id']), 0, ',', ' ') . '</b></td>';
            echo '<td>';
            if ($value['ben_id'] == 0) echo '<span class="badge badge-danger">Encours</span>';
            elseif ($value['ben_id'] == 1) echo '<span class="badge badge-success">Validé</span>';
            elseif ($value['ben_id'] == 2) echo '<span class="badge badge-warning">Annuler</span>';
            echo '</td>';
            echo '<td>';
            if ($value['is_paid'] == 0) echo '<b class="text-danger">Dette</b>';
            elseif ($value['is_paid'] == 1) echo '<b class="text-success">Cash</b>';
            elseif ($value['is_paid'] == 2) echo '<b>Proformat</b>';
            echo '</td><td>';
            echo $pers2->noms;
            echo '</td></tr>';
            $totM += $det->select_sum_op($value['op_id']);
            $i++;
            //}
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="assets/js/data-tables.js"></script>