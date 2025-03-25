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
// $pack=new Package();
$pr = new Tarif();
$tarif = new Tarif();
$det = new DetOperation();
$stores = new POS();

$posId = $_GET['pos_id'];
$supId = $_GET['sup_id'];
$catId = $_GET['cat_id'];
$pos_id = $stores->getPOS($posId);

// var_dump($pos_id->branche_id);
// $tar = $tarif->select_code('INT');
// $tarId=$tar->price_id;
if (!empty($catId)) {
  $datas = $stock->select_all_cat_gen_endom($posId, $supId, $catId);
} else {
  $datas = $stock->select_all_gen_endom($posId, $supId);
}
?>
<div class="ms-panel card-info row" style="margin: 20px;">
  <div class="col-md-12">
    <div class="ms-panel-header bg-light">
      <h3>POS : <?php $store = $pos->getPOS($posId);
                echo $store->type . '(' . $store->store . ')'; ?></h3>
    </div>
    <div>
      <div class="ms-panel-body" style="border: 1px solid gary;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover tab">
            <thead>
              <tr>
                <th>Categorie</th>
                <th>Fournisseur</th>
                <th>Produits</th>
                <th>Qté</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $tot = 0;
              foreach ($datas as $un) {

                $prod = $products->getProductId($un['product_id']);
                $cats = $cat->getCategoryId($prod->category_id);

                $tot += $un['tot_qt'];

                echo '<tr><td>' . $cats->category_name . '</td><td>' . $un['supplier_name'] . '</td><td>' . $prod->details . '</td><td>' . $un['tot_qt'] . '</td>';
                echo '</tr>';
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Total</th>
                <th>-</th>
                <th>-</th>
                <td><b><?php echo number_format($tot, 0, ',', ' '); ?></b></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <script src="assets/js/data-tables.js"></script> -->