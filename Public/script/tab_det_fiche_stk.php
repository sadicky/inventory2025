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

$per = $periodes->getPeriode($_SESSION['periode']);
$from_date = date('Y-m-1');
$to_date = date('Y-m-d');
$posId = $_GET['pos_id'];
$prodId = $_GET['prod_id'];
$idPer = $per->periode_id;
// var_dump($idPer);
$prod = $products->getProductId($prodId);

?>
<h3>Fiche du stock du <?php echo $from_date; ?> Au <?php echo $to_date; ?> / <span class="text-success"> <?php echo $prod->product_name; ?></span></h3>
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-striped tabx table-sm">
        <thead>
            <tr>
                <th>Date</th>
                <th>Produit : (<?php echo $prod->product_name; ?>)</th>
                <th>Par</th>
                <th>Entrée</th>
                <th>Sortie</th>
                <th>reste</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $reste = 0;
            $sortie = 0;
            $entre = 0;

            $in = $operations->select_all_by_date_rap_an('stock_in', $prodId, $from_date, $posId, $idPer);
            $out = $operations->select_all_by_date_rap_an('stock_out', $prodId, $from_date, $posId, $idPer);

            $solde = $in->totqt - $out->totqt;

            $reste += $solde;
            // var_dump($reste);
            if ($solde >= 0) {
                echo '<tr><td>' . $from_date . '</td><td>Reste entrée</td><td>-</td><td>' . $solde . '</td><td>-</td><td>' . $solde . '</td></tr>';
                $entre += $solde;
            } else {
                echo '<tr><td>' . $from_date . '</td><td>Reste Sortie</td><td>-</td><td>' . $solde . '</td><td>' . $solde . '</td></tr>';
                $sortie += $solde;
            }

            while (strtotime($from_date) <= strtotime($to_date)) {
                $datas = $operations->select_all_by_date_rap($prodId, $from_date, $posId, $idPer);
                // var_dump($datas);
                foreach ($datas as $un) {
                    $prod = $products->getProductId($un['product_id']);
                    $pers2 = $user->select_2($un['party_code']);
                    $pers = $user->select($un['user_id']);
                    // var_dump($pers2);
                    if ($un['party_type'] == 'stock_in') {
                        $reste += $un['quantity'];
                        $entre += $un['quantity'];
                        echo '<tr><td>' . $un['create_date'] . '</td><td>' . $un['op_type'] . ' (<b>';
                        if ($un['op_type'] == 'Requisition') {
                            $op = $operations->getOperationId($un['party_code']);
                            $poss = $pos->getPOS($op->pos_id);
                            echo $poss->type;
                        } else {
                            echo $pers->noms;
                        }
                        echo '</b>)</td><td>' . $pers->noms . '</td><td>' . $un['quantity'] . '</td><td>-</td><td>' . $reste . '</td></tr>';
                    } elseif ($un['party_type'] == 'stock_out') {
                        $reste -= $un['quantity'];
                        echo '<tr><td>' . $un['create_date'] . '</td><td>' . $un['op_type'] . ' (<b>';
                        if ($un['op_type'] == 'Transfert') {
                            $op = $operations->getOperationId($un['party_code']);
                            echo '-';
                        } else {
                            $custo = $cust->select($un['party_code']);
                            echo @$custo->customer_name;
                        }

                        echo '</b>)</td><td>' . $pers->noms . '</td><td>-</td><td>' . $un['quantity'] . '</td><td>' . $reste . '</td></tr>';
                        $sortie += $un['quantity'];
                    }

                    if ($prod->is_lot == 1) {
                        $stock->select_by_lot($un['product_id'], $un['lot'], $posId);
                        $qt_stk = $stock->qt_stock_lot($posId, $un['product_id'], $un['lot'], $idPer);
                    } else {
                        $stock->select_by_prod($un['product_id'], $posId);
                        $qt_stk = $stock->qt_stock($posId, $un['product_id'], $idPer);
                    }
                    $stock->update_qt($stock->getStockId(), $qt_stk);
                    //echo $qt_stk;
                    //}
                }

                $from_date = date("Y-m-d", strtotime("+1 days", strtotime($from_date)));
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>-</th>
                <th>-</th>
                <th><?php echo ($entre); ?></th>
                <th><?php echo ($sortie); ?></th>
                <th><?php echo ($reste); ?></th>
            </tr>
        </tfoot>
    </table>
</div>