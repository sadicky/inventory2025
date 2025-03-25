<?php
@session_start();
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/coupon.class.php');
require_once('../../Models/Admin/commande.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
require_once('../../Models/Admin/livraison.class.php');
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

$livraisons = new Livraison();
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
$coupons = new Coupon();

$jour = $journals->select($_SESSION['jour']);
$cfg = $conf->select(1);

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

?>

<div class="card" style="margin:30px;">
    <div class="card-header text-center">
        <h3>Rapport des ventes Du <?php echo $from_d; ?> Au <?php echo $to_d; ?><div style="float:left;">
                <a href="javascript:void(0)" class="btn btn-success btn-sm" id="tab_avances"> Produits le plus vendu</a>
            </div>
        </h3>
    </div>
    <div class="card-body card-block">
        <form id="form_srch_rpt_sale" method="post" action="javascript:void(0)">
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
                            <th>Supprimer</th>
                            <th>Tiers</th>
                            <th>Description</th>
                            <th>Doc</th>
                            <th>Debit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $datas = $transactions->select_all_period_bq_0($_GET['id'], $from_d, $to_d);
                        // var_dump($datas);
                        $solde = 0;
                        $tot_in = 0;
                        $tot_out = 0;
                        $open = 0;
                        foreach ($datas as $un) {
                            echo '<tr><td>' . $un['create_date'] . '</td><td>';
                            if ($_SESSION['role'] == 1) {
                                echo ' <a href="javascript:void(0)" class="del_trans_crt text-danger" id="' . $un['transaction_id'] . '"> <i class="fa fa-times"></i></a>';
                            } else {
                                echo '-';
                            }
                            echo '</td><td>';
                            if ($un['transaction_type'] == 'Paiement') {
                                // $bq->getCaisseId($un['party_code']);
                                // echo $bq->caisse;
                                if (empty($caisse)) {
                                    $pers = $personnes->select($un['party_code']);
                                    echo $pers->nom_complet;
                                    // var_dump($pers->getNomComplet());
                                }
                            } else {
                                $op = $operations->getOperationId($un['op_id']);

                                $perso = $customers->select(@$op->party_code);
                                // var_dump($op->party_code);
                                echo @$perso->customer_name;
                            }
                            echo '</td><td>' . $un['descript'];
                            if ($un['transaction_type'] <> 'Paiement') {
                                echo ' <a href="javascript:void(0)" class="refresh_trans text-danger" data-id="' . $un['op_id'] . '"> <i class="fa fa-refresh"></i></a>';
                            }

                            echo '</td><td>';
                            if (!empty($un['op_id'])) {
                                $op = $operations->getOperationId($un['op_id']);
                                if (@$op->op_type == 'Vente') {
                                    $vente = $ventes->select($un['op_id']);
                                    $doc = $vente->idvente;
                                    // echo '<a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="' . $un['op_id'] . '"> </a><br>';
                                    echo '<a href="javascript:void(0)"  style="cursor:pointer"  data-id="' . $un['op_id'] . '" class="print_this" title="' . $un['op_id'] . '"><i class= "fa fa-print"></i>Facture</a>';
                                    echo '<span style="display:none">';
                                    include('../../Public/script/tab_crt_facture.php');
                                    echo '</span>';
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
                            if ($un['status'] == 'IN' && $op->op_type == 'Approvisionnement') {
                                echo number_format($un['amount'], 0, ',', ' ');
                                $tot_in += 0;
                            } else {
                                echo number_format($un['amount'], 0, ',', ' ');
                                $solde += $un['amount'];
                                $tot_in += $un['amount'];
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
                            <th>-</th>
                            <th>Balance d'Ouverture</th>
                            <th style="text-align: right">
                                <?php
                                $open = $transactions->select_open_bal_bq($bqId, $from_d);
                                $solde += $open;
                                echo number_format($open, 0, ',', ' '); ?>
                            </th>
                        </tr>
                        <tr>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>Total Encours</th>
                            <th style="text-align: right"><?php echo number_format($tot_in, 2, ',', ' '); ?></th>
                        </tr>
                        <tr>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>Balance de Fermeture</th>
                            <th style="text-align: right"><?php echo number_format($solde, 2, ',', ' '); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div style="padding-top: 20px;"></div>