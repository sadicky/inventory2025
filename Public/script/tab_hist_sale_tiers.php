<?php
@session_start();

require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/paiement.class.php');
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
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/livraison.class.php');


$cat = new Category();
$products = new Product();
$stock = new Stock();
$pos = new POS();
$pr = new Tarif();
$tarif = new Tarif();
$det = new DetOperation();
$operations = new Operation();
$user = new User();
$cust = new Customer();
$periodes = new Periode();
$ventes = new Vente();
$caisses = new Caisse();
$paiemenents = new Paiement();
$transactions = new Transactions();
$autres = new AutreFrais();
$customers = new Customer();
$livraisons = new Livraison();
$personnes = new User();

if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = date('Y-m-01');
if (!empty($_GET['to_d'])) $to_d = $_GET['to_d'];
else $to_d = date('Y-m-d');
// if(!empty($_GET['type'])) 
$type = $_GET['type'];
// else $type=1;
$pers = $customers->select($_GET['id']);
// var_dump($pers);

?>
<hr>
<div class="card card-block">
    <div class="card-header bg-light">
        <h3>Historique des ventes</h3>
    </div>
    <div class="card-wrapper">
        <div class="card-body">
            <form method="post" id="form_srch_sale_tiers">
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">Du</label>
                        <input type="date" name="from_d" id="from_d" class="form-control" value="<?php echo $from_d ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Au</label>
                        <input type="date" name="to_d" id="to_d" class="form-control" value="<?php echo $to_d; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Au</label>
                        <select name="type" id="type" class="custom-select">
                            <option value=""> --Choisir-- </option>
                            <option value="0">Dette</option>
                            <option value="1">Payé</option>
                            <option value="2">Proformat</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <br>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            <?php if (!empty($_GET['id'])) : ?>
                <h3 class="m-3" style="text-align: center; font-weight: bold; font-size: 14px;">Achats Du <?php echo $from_d; ?> Au <?php echo $to_d; ?></h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm tab">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Produit</th>
                                <th>Statut</th>
                                <th>Montant</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $datas = $operations->select_all_by_period_tiers('Vente', $type, $pers->personne_id, $from_d, $to_d);
                            // var_dump($datas);
                            $tot = 0;
                            foreach ($datas as $key => $value) {
                                $pers = $personnes->select($value['party_code']);
                                $vente = $ventes->select($value['op_id']);

                                $tot += $det->select_sum_op($value['op_id']);

                                echo '<tr><td><a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="' . $value['op_id'] . '">' . @$vente->idvente . '</a></td><td>' . $value['create_date'] . ' </td><td>';

                                echo '<ul>';
                                $datas2 = $det->select_all($value['op_id']);
                                foreach ($datas2 as $un2) {
                                    $prod = $products->getProductId($un2['product_id']);
                                    echo '<li>(<b>' . $un2['quantity'] . '</b>) - ' . $prod->product_name . '</li>';
                                }
                                if ($det->nb_op($value['op_id']) == 0) echo '<a href="javascript:void(0)" class="del_op_appro" data-id="' . $value['op_id'] . '" id="' . $value['op_id'] . '"><i class="fa fa-times text-danger"></i></a>';
                                echo '</td><td>';
                                if ($value['is_paid'] == 0) {
                                    echo "<span class='badge badge-danger'>Dette</span>";
                                } elseif ($value['is_paid'] == 1) {
                                    echo "<span class='badge badge-success'>Payé</span>";
                                } else {
                                    echo "<span class='badge badge-warning'>Proformat</span>";
                                }
                                echo '</td><td align="right">' . number_format($det->select_sum_op($value['op_id']), 0, ',', ' ') . '</td></tr>';
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>-</th>
                                <th>Total</th>
                                <th>-</th>
                                <th>-</th>
                                <th style="text-align: right"><?php echo number_format($tot, 0, ',', ' ') . ''; ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>