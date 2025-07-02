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
$pos = new POS();
$operations = new Operation();
// $pack=new Package();
$pr = new Tarif();
$tarif = new Tarif();
$det = new DetOperation();
$stores = new POS();

$posId = $_GET['pos_id'];
$catId = $_GET['cat_id'];
$pos_id = $stores->getPOS($posId);

// var_dump($pos_id->branche_id);
// $tar = $tarif->select_code('INT');
// $tarId=$tar->price_id;
if (!empty($catId)) {
  $datas = $stock->select_all_cat_gen($posId, $catId);
} else {
  $datas = $stock->select_all_gen($posId);
  
  // $dat = $operations->select_all($posId);
}

// var_dump($dat);
?>
<div class="row">
  <div class="col-md-6">
    <h3>POS : <?php $store = $pos->getPOS($posId);
              echo $store->type . '(' . $store->store . ')'; ?> / Situaton du stock général</h3>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover tab">
        <thead>
          <tr>
            <th>Categorie</th>
            <th style="width:200px;">Produits</th>
            <th>Qté</th>
            <th>PV</th>
            <th>PVT</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $tot = 0;
          foreach ($datas as $un) {

            $prod = $products->getProductId($un['product_id']);
            $price = $pr->select_2($un['product_id'], $pos_id->branche_id);
            $cats = $cat->getCategoryId($prod->category_id);
            $last = $det->select_last_id('Approvisionnement', $un["product_id"]);
            $det_id = $last->last_id;
            $d = $det->select($det_id);
            // var_dump($price->price);
            if (empty($price->price)) {
              $last = $det->select_last_id('Inventaire', $un["product_id"]);
              $det_id = $last->last_id;
              $det->select($det_id);
            }
            $pa = @$price->price;
            // var_dump($price);

            $tot += $pa * $un['tot_qt'];

            echo '<tr>
              <td>' . $cats->category_name . '</td>
              <td><a href="javascript:void(0)" class="fiche_det" data-id="' . $un['product_id'] . '">' . $prod->details . '</a></td>
              <td>' . $un['tot_qt'] . '</td>
              <td align="right">' . number_format($pa, 0, ',', ' ') . '</td>
              <td align="right">' . number_format($pa * $un['tot_qt'], 0, ',', ' ') . '</td>';
            echo '</tr>';
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>Total</th>
            <th>-</th>
            <th>-</th>
            <th>-</th>
            <td align="right"><b><?php echo number_format($tot, 0, ',', ' '); ?></b></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <div class="col-md-6 fiche_art p-2">
  </div>
</div>

<!-- <script src="assets/js/data-tables.js"></script> -->