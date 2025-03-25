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
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/config.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/customer.class.php');

$cat = new Category();
$products = new Product();
$stock = new Stock();
$stores = new POS();
// $pack=new Package();
$pr = new Tarif();
$tarif = new Tarif();
$det = new DetOperation();

$operations = new Operation();
$user = new User();
$cust = new Customer();
$periodes = new Periode();


if (!empty($_POST['id_per'])) $id_per = $_POST['id_per'];
else $id_per = $_SESSION['periode'];
if (!empty($_POST['pos_id'])) $posId = $_POST['pos_id'];
else $posId = $_SESSION['pos'];
$p = $periodes->getPeriode($_POST['id_per']);
// $pos = $stores->getStores();


if ($_SESSION['role'] == 1) {
  $st = $stores->getPOS($_POST['pos_id']);
  $pos = $stores->getStores();
  // $caisse = $caisses->getCaisses();
} else {
  $st = $stores->getStoreId($_SESSION['pos']);
  $pos = $stores->getBranchePOS($st->branche_id);
  // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}
?>
<div class="ms-panel">
  <div class="ms-panel-header">Rapport d'inventaire du stock</div>
  <div class="ms-panel-body">
    <form id="frm_rap_inv" method="post">
      <div class="row">
        <div class="col-md-3">
          <label class="control-label">Periode</label>
          <select name="id_per" id="id_per" class="custom-select" data-live-search="true" data-style="btn-darkx" required>
            <option value="">Choisir Période</option>
            <?php
            $datas = $periodes->select_all();
            foreach ($datas as $key => $value) {
              if ($value['periode_id'] == $id_per) {
                echo '<option value="' . $value['periode_id'] . '" selected>' . $value['code_per'] . '</option>';
              } else {
                echo '<option value="' . $value['periode_id'] . '">' . $value['code_per'] . '</option>';
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="control-label">Stock</label>
          <select name="pos_id" id="pos_id" class="custom-select" data-live-search="true" data-style="btn-dark">

            <?php if ($_SESSION['role'] == 1): ?>
              <option value="" selected>Tous</option>
            <?php endif ?>
            <?php
            foreach ($pos as $value) {
              echo '<option value="' . $value->store_id . '">' . $value->type . '(' . $value->store . ')</option>';
            }

            ?>
          </select>
        </div>
        <div class="col-md-2">
          <br />
          <button class="ms-btn-icon btn-primary btn-sm" type="submit"><span class=" text-white fa fa-search"></span></button>
        </div>
      </div>
    </form>
    <hr>
    <?php
    if (!empty($_POST['pos_id'])) { ?>
      <h3 class="box-title m-b-0">Stock : <?php echo $st->type . '(' . $st->store . ')'; ?> - FICHE D'INVENTAIRE DU <?php echo $p->debut; ?></h3>
      <div class="table-responsive">

        <table class="table table-striped table-bordered table-hover tab" id="data-table">
          <thead>
            <tr>
              <th>Produit</th>
              <th>Qt</th>
              <th>Prix</th>
              <th>Tot</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $datas = $det->select_all_by_type('Inventaire', $id_per, $posId);
            $tot = 0;
            foreach ($datas as $un) {
              if ($un['quantity'] >= 0) {
                $prod = $products->getProductId($un['product_id']);
                $cat->getCategoryId($prod->category_id);
                $tot += $un['quantity'] * $un['amount'];
                echo '<tr><td>' . $prod->product_name . '</td>
          <td>' . $un['quantity'] . '</td>';
                echo '<td>' . number_format($un['amount'], 2, ',', ' ') . '</td>';
                echo '<td>' . number_format($un['quantity'] * $un['amount'], 2, ',', ' ') . '</td>';
                echo '</tr>';
              }
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Totaux</th>
              <th>-</th>
              <th>-</th>
              <th><?php echo number_format($tot, 0, ',', ' ') ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    <?php
    } else {
    ?>
      <h3 class="box-title m-b-0">Inventaire Général</h3>
      <div class="table-responsive">

        <table class="table table-striped table-condensend table-bordered table-hover tab">
          <thead>
            <tr>
              <th>Produit</th>
              <th>Qt</th>
              <th>Prix</th>
              <th>Tot</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $datas = $det->select_all_by_type_glob('Inventaire', $id_per);
            $tot = 0;
            foreach ($datas as $un) {
              if ($un['tot'] >= 0) {
                $prod = $products->getProductId($un['product_id']);
                $cat->getCategoryId($prod->category_id);
                $tot += $un['tot'] * $un['amount'];
                echo '<tr><td>' . $prod->product_name . '</td>
          <td>' . $un['tot'] . '</td>';
                echo '<td align="right">' . number_format($un['amount'], 0, ',', ' ') . '</td>';
                echo '<td align="right">' . number_format($un['tot'] * $un['amount'], 0, ',', ' ') . '</td>';
                echo '</tr>';
              }
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Totaux</th>
              <th>-</th>
              <th>-</th>
              <th><?php echo number_format($tot, 2, ',', ' ') ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    <?php
    }
    ?>

  </div>
</div>

<script src="assets/js/data-tables.js"></script>