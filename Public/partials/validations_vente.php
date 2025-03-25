<?php
@session_start();
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/customer.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/personne.class.php');

$user = new User();
$details = new detOperation();
$categories = new Category();
$stores = new POS();
$products = new Product();
$periodes = new Periode();
$stocks = new Stock();
$operations = new Operation();
$ventes = new Vente();
$personnes = new Personne();
$customers = new Customer();
$caisses = new Caisse();
$branches = new Branches();

$datas = $operations->select_all_facture_no_0_();
// var_dump($datas);

if ($_SESSION['role'] == 1) {
  $data_store = $branches->getBranches();
} else {
  $st = $stores->getStoreId($_SESSION['pos']);
  $data_store = $branches->getBranche($st->branche_id);
}

?>
<div class="ms-panel" style="margin: 30px;">
  <div class="ms-panel-header">
    <h3 class="box-title m-b-0">Validation des opérations de Vente</h3>
  </div>
  <div class="ms-panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-bordered" id="data-table">
        <thead>
          <tr>
            <th>Client</th>
            <th>Type F.</th>
            <th>Montant</th>
            <th>Branche</th>
            <th>Par</th>
            <th>Statut</th>
            <th>Valider</th>
            <th>Imprimer</th>
          </tr>
        </thead>
        <tbody>
          <?php $totM = 0;
          $i = 1;
          foreach ($datas as $value):
            $pers2 = $user->select($value['user_id']);
            $data = $operations->select_all_facture_no_2($value['op_id'], $value['op_type'], $data_store->branche_id);
            $vente = $ventes->select($value['op_id']);
            $pers = $customers->select($value['party_code']);
          ?>
            <?php foreach ($data as $d) {
              $st = $stores->getStoreId($d->pos_id);
            ?>
              <tr>
                <td><?= $pers->customer_name ?></td>
                <td><?php
                    if ($d->is_paid == 0) echo '<b class="text-danger">Dette</b>';
                    elseif ($d->is_paid == 1) echo '<b class="text-success">Cash</b>';
                    elseif ($d->is_paid == 2) echo '<b>Proformat</b>';
                    ?></td>
                <td><?= number_format($details->select_sum_op($value['op_id']), 0, ',', ' ') ?></td>
                <td><?= $st->branche ?></td>
                <td><?= $pers2->noms ?></td>
                <td><?php
                    if ($value['ben_id'] == 0) echo '<span class="badge badge-danger">Encours</span>';
                    elseif ($value['ben_id'] == 1) echo '<span class="badge badge-success">Validé</span>';
                    elseif ($value['ben_id'] == 2) echo '<span class="badge badge-warning">Annuler</span>';
                    ?></td>
                <td> <?php
                      if ($value['ben_id'] == 0): ?> <a href="javascript:void(0)" id="<?= $value['op_id'] ?>" class="btn-ms btn-primary btn-sm valider_vente">
                      <i class="fa fa-check-circle"></i> Valider
                    </a>
                  <?php else: echo '-'; ?>
                  <?php endif ?>
                </td>
                <td> <?php
                      if ($value['ben_id'] != 0): ?><a href="javascript:void(0)" style="cursor:pointer;" title="<?= $value['op_id'] ?>" data-id="<?= $value['op_id'] ?>" class="btn-ms btn-danger btn-sm print_fac"> <i class="fa fa-print"></i> Imprimer </a></td>

              <?php else: ?><a href="javascript:void(0)" title="<?= $value['op_id'] ?>" id="<?= $value['op_id'] ?>" class="btn-ms btn-dark btn-sm delete_op"> <i class="fa fa-times-circle"></i> Supprimer </a></td>
              <?php endif ?>

              </tr>
          <?php }
          endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
  <span style="display:none">
    <?php include('../../Public/script/tab_crt_facture_.php'); ?>
  </span>
</div>
<script src="assets/js/data-tables.js"></script>