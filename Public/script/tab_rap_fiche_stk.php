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
$prodId = $_GET['prod_id'];
$idPer = $_GET['id_per'];

$prod = $products->getProductId($prodId);

?>
<div class="white-box form-row">
    <div><button id="print_rp" class="ms-btn-icon btn-danger m-2" title="Imprimer"><span class="text-white fa fa-print"></span></button></div>
    <div class="col-md-12" id="rapport">
        <div id="vente_tab">
            <h4 class="box-title m-b-0">Fiche du stock du <?php echo $from_date; ?> Au: <?php echo $to_date; ?> / Produit : <label class="text-danger"><?php echo $prod->product_name; ?></label> / <label class="text-danger">
                    <?php
                    $poss = $pos->getPOS($posId);

                    echo $poss->type . "(" . $poss->store . ")";

                    ?>
                </label>
            </h4>
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-condensed table-striped display table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Libellé</th>
                            <th>Fournisseur/Client</th>
                            <th>Utilisateur</th>
                            <th>Entrée</th>
                            <th>Sortie</th>
                            <th>reste</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $reste = 0;

                        $in = $operations->select_all_by_date_rap_an('stock_in', $prodId, $from_date, $posId, $idPer);
                        $out = $operations->select_all_by_date_rap_an('stock_out', $prodId, $from_date, $posId, $idPer);

                        $solde = $in->totqt - $out->totqt;

                        $reste += $solde;
                        if ($solde >= 0) {
                            echo '<tr><td>' . $from_date . '</td><td>Reste entrée</td><td>-</td><td>' . number_format($solde) . '</td><td>-</td><td>-</td><td>' . number_format($solde) . '</td></tr>';
                        } else {
                            echo '<tr><td>' . $from_date . '</td><td>Reste Sortie</td><td>-</td><td>-</td><td>' . number_format($solde) . '</td><td>' . number_format($solde, '2', '.', ' ') . '</td></tr>';
                        }
                        $tot_ent = 0;
                        $tot_sort = 0;

                        while (strtotime($from_date) <= strtotime($to_date)) {
                            $datas = $operations->select_all_by_date_rap($prodId, $from_date, $posId, $idPer);

                            foreach ($datas as $un) {
                                $prod = $products->getProductId($un['product_id']);
                                $pers2 = $cust->select($un['party_code']);
                                // var_dump($pers2);
                                $pers = $user->select($un['user_id']);

                                if ($un['party_type'] == 'stock_in') {
                                    $reste += $un['quantity'];
                                    echo '<tr><td>' . $un['create_date'] . '</td><td>' . $un['op_type'] . '</td><td>' . @$pers2->customer_name . '</td><td>' . @$pers->noms . '</td><td align="right">' . number_format($un['quantity']) . '</td><td>-</td><td>' . number_format($reste) . '</td></tr>';
                                    $tot_ent += $un['quantity'];
                                } elseif ($un['party_type'] == 'stock_out') {
                                    $reste -= $un['quantity'];
                                    echo '<tr><td>' . $un['create_date'] . '</td><td>' . $un['op_type'] . '</td><td>' . @$pers2->customer_name . '</td><td>' . @$pers->noms . '</td><td>-</td><td align="right">' . number_format($un['quantity']) . '</td><td>' . number_format($reste) . '</td></tr>';
                                    $tot_sort += $un['quantity'];
                                }
                            }


                            $from_date = date("Y-m-d", strtotime("+1 days", strtotime($from_date)));
                        }

                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th style="text-align:right"><?php echo number_format($tot_ent) ?></th>
                            <th style="text-align:right"><?php echo number_format($tot_sort) ?></th>
                            <th style="text-align:right"><?php echo number_format($tot_ent - $tot_sort); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>