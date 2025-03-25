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
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/config.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/customer.class.php');
require_once('../../Models/Admin/livraison.class.php');
require_once("../../Models/Admin/N2TEXT.php");

$conv = new ConvertNumberToText();
$achats = new Achat();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$details = new detOperation();
$journals = new Journal();
$operations = new Operation();
$products = new Product();
$livraisons = new Livraison();
$periodes = new Periode();
$store = new POS();
$suppliers = new Supplier();
$users = new User();
$autres = new AutreFrais();
$transactions = new Transactions();
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();
$conf = new Config();
$customers = new Customer();
$ventes = new Vente();
$stocks = new Stock();

$jour = $journals->select($_SESSION['jour']);
// include '../partials/N2TEXT.php';

if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = @$jour->start_date;
if (!empty($_GET['to_d'])) $to_d = $_GET['to_d'];
else $to_d = date('Y-m-d');
if (!empty($_GET['id'])) $bqId = $_GET['id'];
else {
    $bank = $caisses->select_status_2('1', $_GET['id']);
    @$bqId = $bank->caisse_id;
}

// $caisse = $caisses->getCaisses();
if ($_SESSION['role'] == 1) {
    // $stores = $store->getStorePrincipal();
    $caisse = $caisses->getCaisses();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBranchePOS($st->branche_id);
    $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}

$cfg = $conf->select(1);

?>
<div class="card" style="margin:30px;">
    <div class="card-header text-center">
        <h3>Valorisation des Dettes Du <?php echo $from_d; ?> Au <?php echo $to_d; ?></h3>
    </div>
    <div class="card-body card-block">
        <form id="form_srch_rpt_dette" method="post" action="javascript:void(0)">
            <div class="form-body">
                <div class="form-row">
                    <div class="col-md-2">
                        <label class="control-label">Caisse</label>
                        <select class="custom-select" name="id" id="id">
                            <option value="">--Choisir--</option>
                            <?php
                            foreach ($caisse as $value) {
                                echo '<option value="' . $value->caisse_id . '">' . $value->caisse_name . '(' . $value->branche . ')</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Du : </label>
                            <input type="date" id="from_d" name="from_d" class="form-control" value="<?php echo $from_d; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Au : </label>
                            <input type="date" id="to_d" name="to_d" class="form-control" value="<?php echo $to_d; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" style="bottom:0;">
                            &nbsp;<br />
                            <button id="action" data-id="Add" type="submit" class="ms-btn-icon btn-success" style="color:white;" name="search"> <span class="fa fa-search"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php if (!empty($_GET['id'])) : ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm display tab">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Clients</th>
                            <th>Facture</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $datas = $transactions->select_all_period_bq_2($bqId, $from_d, $to_d);
                        $solde = 0;
                        $tot_in = 0;
                        $tot_out = 0;
                        $open = 0;
                        // $total =  $transactions->select_all_sum_bq_2($_GET['id'], $bqId, $from_d, $to_d);
                        // var_dump($datas);

                        foreach ($datas as $un) {
                            echo '<tr><td>' . $un['create_date'] . '</td>';
                            echo '<td>';

                            $op = $operations->getOperationId($un['op_id']);

                            $perso = $customers->select(@$op->party_code);
                            // var_dump($op->party_code);
                            echo @$perso->customer_name;

                            echo '</td><td>';
                            if (!empty($un['op_id'])) {
                                $op = $operations->getOperationId($un['op_id']);
                                $vente = $ventes->select($un['op_id']);
                                $doc = $vente->idvente;
                                echo '<a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="' . $un['op_id'] . '"> </a>';
                                echo '<a href="javascript:void(0)"  style="cursor:pointer"  data-id="' . $un['op_id'] . '" class="print_this" title="' . $un['op_id'] . '"><i class= "fa fa-print"></i>Facture</a>';
                                echo '<span style="display:none">';
                                include('../../Public/script/tab_crt_prof.php');
                                echo '</span>';
                            } else {
                                echo '-';
                            }
                            echo '</td>';

                            echo '<td>';
                            if ($un['status'] == 'OUT') {
                                echo $un['amount'];
                                $solde += $un['amount'];
                                $tot_in += $un['amount'];
                            }
                            echo '</td></tr>';
                        }
                        echo '<tr><th>Valorisation de produits en dettes</th><th>-</th><th>-</th><th align="right" style="color:red">' . number_format($tot_in, 0, ',', ' ') . '</th></tr>';
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div style="padding-top: 20px;"></div>