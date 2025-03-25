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

$operations = new Operation();
$user = new User();
$cust = new Customer();
$periodes = new Periode();

$from_date = $_GET['from_d'];
$to_date = $_GET['to_d'];
$posId = $_GET['pos_id'];
$id_per = $_GET['id_per'];
?>
<div class="ms-panel form-row">
    <div><button id="print_rp" class="ms-btn-icon btn-danger m-2" title="Imprimer"><span class="fa fa-print text-white"></span></button></div>
    <div class="col-md-12" id="rapport">

        <h4 class="ms-panel-header m-b-0">Mouvement périodique du stock du <?php echo $_GET['from_d']; ?> Au: <?php echo $_GET['to_d']; ?> Stock :
            <?php
            $poss = $pos->getPOS($posId);

            echo $poss->type . "(" . $poss->store . ")";
            ?>
        </h4>

        <table id="data-table" class="table table-bordered table-condensed table-striped display table-sm">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Initial</th>
                    <th>Entrée</th>
                    <th>Sortie</th>
                    <th>Reste</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //solde
                $all_prod = $products->getProducts();

                foreach ($all_prod as $key => $value) {
                    $in = $operations->select_all_by_date_rap_an('stock_in', $value->product_id, $from_date, $posId, $id_per);
                    $out = $operations->select_all_by_date_rap_an('stock_out', $value->product_id, $from_date, $posId, $id_per);

                    $solde = 0;
                    $entre = 0;
                    $sortie = 0;

                    $solde = $in->totqt - $out->totqt;
                    $datas = $operations->select_all_between_date_rap($value->product_id, $from_date, $to_date, $posId, $id_per);

                    //var_dump($datas);
                    foreach ($datas as $un) {

                        if ($un['party_type'] == 'stock_in') {
                            $entre += $un['totqt'];
                        } elseif ($un['party_type'] == 'stock_out') {
                            $sortie += $un['totqt'];
                        }
                    }
                    $reste = (($solde + $entre) - $sortie);
                    $t = 0;
                    if ($solde != 0) {
                        $t = 1;
                    }
                    if ($entre != 0) {
                        $t = 1;
                    }
                    if ($sortie != 0) {
                        $t = 1;
                    }
                    if ($reste != 0) {
                        $t = 1;
                    }

                    if ($t == 1) {
                        //$pr->select_2($value->product_id,$packId);
                        echo '<tr><td>' . $value->details . '</td><td align="right">' . ($solde) . '</td><td align="right">' . ($entre) . '</td><td align="right">' . ($sortie) . '</td><td align="right">' . ($reste) . '</td></tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>