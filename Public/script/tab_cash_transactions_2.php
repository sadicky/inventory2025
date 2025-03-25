<?php
@session_start();
require_once('../../Models/Admin/account.class.php');
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
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/customer.class.php');

$accounts = new Account();
$achats = new Achat();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$details = new detOperation();
$journals = new Journal();
$operations = new Operation();
$products = new Product();
$periodes = new Periode();
$stores = new POS();
$suppliers = new Supplier();
$users = new User();
$autres = new AutreFrais();
$trans = new Transactions();
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();
$conf = new Config();
$customers = new Customer();
$ventes = new Vente();
$stocks = new Stock();
include '../partials/N2TEXT.php';

if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = date('Y-m-d');
if (!empty($_GET['to_d'])) $to_d = $_GET['to_d'];
else $to_d = date('Y-m-d');
if (!empty($_GET['id'])) $id = $_GET['id'];
else $id = '1';
if ($_SESSION['role'] == 1) {
    // $stores = $store->getStorePrincipal();
    $caisse = $caisses->getCaisses();
} else {
    $st = $stores->getStoreId($_SESSION['pos']);
    $stores = $stores->getBranchePOS($st->branche_id);
    $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}

$bq = $caisses->getCaisseId($id);
$datas = $trans->select_all_period_bq($id, $from_d, $to_d);
?>
<input type="hidden" name="main_id" value="<?php echo $id; ?>">
<hr>
<div class="card" style="margin:30px;">
    <div class="card-header text-center">
        <h3>Transactions Du <?php echo $from_d; ?> Au <?php echo $to_d; ?> : <?php echo $bq->branche; ?> - <?php echo $bq->caisse_name; ?></h3>
    </div>
    <div class="card-body card-block">
        <form id="form_srch_cash" method="post" action="javascript:void(0)">
            <div class="form-body">

                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Caisse*</label>
                            <select id="id" name="id" class="custom-select" required>
                                <option value="" selected>-- Choisir --</option>
                                <?php
                                // $mode = $caisses->getCaisses();
                                foreach ($caisse as $e) {
                                    // if($e->caisse_id==$id)
                                    echo '<option value="' . $e->caisse_id . '">' . $e->caisse_name . '(' . $e->branche . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Du : </label>
                            <input type="date" id="from_d" name="from_d" class="form-control" value="<?php echo $from_d ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Au : </label>
                            <input type="date" id="to_d" name="to_d" class="form-control" value="<?php echo $to_d; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" style="bottom:0;">
                            &nbsp;<br />
                            <button id="action" style="color:white;" data-id="Add" type="submit" class="btn btn-success btn-sm" name="search"> <span class="fa fa-search"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php if (!empty($_GET['id'])) : ?>
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-sm display">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Tiers</th>
                            <th>Description</th>
                            <th>Doc</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $solde = 0;
                        $tot_in = 0;
                        $tot_out = 0;
                        $open = 0;

                        foreach ($datas as $un) {
                            echo '<tr><td>';
                            if ($un['transaction_type'] == 'Paiement') {
                                echo '<a href="javascript:void(0)" class="select_pymt" id="' . $un['transaction_id'] . '" data-id="' . $un['transaction_id'] . '">' . $un['create_date'] . '</a>';
                            } else {
                                echo $un['create_date'];
                            }

                            echo '</td><td>';

                            $op = $operations->getOperationId($un['op_id']);
                            // var_dump($un['personne_id']);
                            if (@$op->op_type == 'Vente') {
                                $partyCode = $op->party_code;
                                $cust = $customers->select($partyCode);
                                echo $cust->customer_name;
                            } elseif ($un['transaction_type'] == 'Transfert') {
                                $partyCode = $un['party_code'];
                                $trans2 = $transactions->select($partyCode);
                                $bq = $caisses->getCaisseId($trans2->caisse_id);
                                echo $bq->caisse_name;
                            } elseif ($un['transaction_type'] == 'Paiement') {
                                $bq = $caisses->getCaisseId($un['party_code']);
                                echo $bq->caisse_name;
                                if (empty($bq->caisse_name)) {
                                    $cust = $customers->selectId($un['party_code']);
                                    echo $cust->customer_name;
                                }
                            }

                            echo '</td><td>' . $un['descript'];
                            if ($un['transaction_type'] == 'Paiement') {
                                echo '<ul>';
                                $dat = $paie->select_all_trans($un['transaction_id']);
                                foreach ($dat as $key => $un2) {
                                    $vente->select($un2['op_id']);
                                    echo '<li>' . $vente->num_vente . ' (<b>' . $un2['amount'] . '' . $_SESSION['short2'] . '</b>)</li>';
                                }
                                echo '</ul>';

                                echo '<a href="javascript:void(0)" data-id="' . $un['transaction_id'] . '" class="print_rec"><i class= "fa fa-print"></i></a>';
                                echo '<span style="display:none">';
                                include('tab_crt_rec.php');
                                echo '</span>';
                            }

                            echo '</td><td>';
                            if (!empty($un['op_id'])) {
                                $op = $operations->getOperationId($un['op_id']);
                                if (@$op->op_type == 'Vente') {
                                    $vente = $ventes->select($un['op_id']);
                                    $doc = $vente->num_vente;
                                    echo '<a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="' . $un['op_id'] . '">' . $doc . '</a>';
                                } elseif (@$op->op_type == 'Approvisionnement') {
                                    $achat = $achats->getAchat($un['op_id']);
                                    $doc = $achat->num_achat;
                                    echo '<a href="javascript:void(0)" class="row_edit_appro_hist" style="cursor:pointer" data-id="' . $un['op_id'] . '">' . $doc . '</a>';
                                }
                            } else {
                                echo '-';
                            }
                            echo '</td>';

                            echo '<td align="right">';
                            if ($un['status'] == 'IN') {
                                echo number_format($un['amount'], 0, ',', ' ');
                                $solde += $un['amount'];
                                $tot_in += $un['amount'];
                            }
                            echo '</td><td align="right">';
                            if ($un['status'] == 'OUT') {
                                echo number_format($un['amount'], 0, ',', ' ');
                                $solde -= $un['amount'];
                                $tot_out += $un['amount'];
                            }
                            echo '</td></tr>';
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>Balance d'Ouverture</th>
                            <th style="text-align: right">
                                <?php
                                $open = $trans->select_open_bal_bq($id, $from_d);
                                // if (isset($cust->customer_id)) {
                                //     $acc = $accounts->select($_GET['id']);
                                //     $open += $acc->open_bal;
                                // }
                                $solde += $open;
                                if ($open > 0) echo number_format($open, 0, ',', ' ')  ?>
                            </th>
                            <th style="text-align: right"><?php if ($open < 0) echo number_format($open, 0, ',', ' '); ?></th>
                        </tr>
                        <tr>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>Total Encours</th>
                            <th style="text-align: right"><?php echo number_format($tot_in, 0, ',', ' ') ?></th>
                            <th style="text-align: right"><?php echo number_format($tot_out, 0, ',', ' ') ?></th>
                        </tr>
                        <tr>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>Balance de Fermeture</th>
                            <th style="text-align: right"><?php echo number_format($solde, 0, ',', ' ')  ?></th>
                            <th><?php  ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div style="padding-top: 20px;"></div>
<script src="assets/js/data-tables.js"></script>