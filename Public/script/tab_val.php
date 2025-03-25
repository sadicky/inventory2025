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

$posId = $_GET['pos_id'];
$catId = $_GET['cat_id'];
// $tar = $tarif->select_code('INT');
// $tarId=$tar->price_id;
if (!empty($catId)) {
    $datas = $stock->select_all_cat_gen($posId, $catId);
} else {
    $datas = $stock->select_all_gen($posId);
}

// var_dump($datas);
?>
<div class="ms-panel card-info" style="margin:20px">
    <div>
        <div class="ms-panel-body" style="border: 1px solid gary;">
            <div class="row">
                <div class="col-md-12">
                    <h3>Valorisation du Stock : <?php $store = $pos->getPOS($posId);
                                echo $store->type . '(' . $store->store . ')'; ?></h3>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tab">
                            <thead>
                                <tr>
                                    <th>Categorie</th>
                                    <th style="width:200px;">Produits</th>
                                    <th>Qté</th>
                                    <th>PA</th>
                                    <th>PAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tot = 0;
                                foreach ($datas as $un) {

                                    $prod = $products->getProductId($un['product_id']);
                                    $cats = $cat->getCategoryId($prod->category_id);
                                    $last = $det->select_last_id('Approvisionnement', $un["product_id"]);
                                    $det_id = $last->last_id;
                                    // var_dump($det_id);
                                    $d = $det->select($det_id);
                                    // var_dump($d->amount);
                                    if (empty($d->amount)) {
                                        $last = $det->select_last_id('Inventaire', $un["product_id"]);
                                        $det_id = $last->last_id;
                                        $det->select($det_id);
                                    }
                                    $pa = @$d->amount;

                                    $tot += $pa * $un['tot_qt'];

                                    echo '<tr><td>' . $cats->category_name . '</td><td>' . $prod->product_name . '</td><td>' . $un['tot_qt'] . '</td><td align="right">' . number_format($pa) .' '. $_SESSION['short2']. '</td><td align="right">' . number_format($pa * $un['tot_qt']) .' '. $_SESSION['short2'].'</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Valorisation Stock</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <td align="right"><b><?php echo number_format($tot,2,',',' '); ?><?=$_SESSION['short2']?></b></td>
                                </tr>
                            </tfoot>
                        </table>
                        <h1>Valorisation du Stock: <span style="color:red"><?=number_format($tot,2,',',' ')?><?=$_SESSION['short2']?></span> ~= (<?=number_format($tot*$_SESSION['taux3'],0,',',' ').' '.$_SESSION['short3']?>)</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div style="padding-top: 20px;"></div>

    <!-- <script src="assets/js/data-tables.js"></script> -->