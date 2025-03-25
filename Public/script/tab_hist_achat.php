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
$achats = new Achat();

if ($_SESSION['role'] == 1) {
    $data = $pos->getStores();
    $caisse = $caisses->getCaisses();
} else {
    $st = $pos->getStoreId($_SESSION['pos']);
    $data = $pos->getBranchePOS($st->branche_id);
    $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}

$idPer = $_SESSION['periode'];

$periodes->getPeriode($_SESSION['periode']);
if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = date('Y-m-01');
if (!empty($_GET['to_d'])) $to_d = $_GET['to_d'];
else $to_d = date('Y-m-d');
if (!empty($_GET['pos_id'])) $posId = $_GET['pos_id'];
else $posId = $_SESSION['pos'];

//echo $_GET['pos_id'];
?>
<style type="text/css">
    ul.custom-list li::before {
        content: "•";
        color: red;
        font-size: 1.2rem;
        margin-right: 10px;
    }

    ul.custom-list {
        list-style: none;
        padding-left: 0;
    }
</style>
<div class="card">
    <div class="card-header bg-light">Historique des achats</div>
    <div class="card-body">
        <form method="post" id="appro-search">
            <div class="row">
                <div class="col-md-2">
                    <label class="control-label">Du</label>
                    <input type="date" name="from_d" id="from_d" class="form-control" value="<?php echo $from_d; ?>">
                </div>
                <div class="col-md-2">
                    <label class="control-label">Au</label>
                    <input type="date" name="to_d" id="to_d" class="form-control" value="<?php echo $to_d; ?>">
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">STOCK</label>
                        <select class="custom-select" id="pos_id" name="pos_id" required readonly>

                            <?php
                            // $datas = $pos->getStores();
                            foreach ($data as $value) {
                                echo '<option value="' . $value->store_id . '">' . $value->store . '(' . $value->type . ')</option>';
                            }

                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-2">
                    <br>
                    <button type="submit" class="ms-btn-icon btn-primary"><i class="text-white fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <?php if (!empty($_GET['pos_id'])) : ?>
            <h3 class="m-3" style="text-align: center; font-weight: bold; font-size: 14px;">Du <?php echo $from_d; ?> Au <?php echo $to_d; ?> / <?php $p = $pos->getPOS($posId);
                                                                                                                                                echo $p->type . '(' . $p->store . ')'; ?></h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm tab">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Fournisseur</th>
                            <th style="width:30%px;">Produit</th>
                            <th>Etat</th>
                            <th>Afficher</th>
                            <!-- <th>Mont</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $datas = $operations->select_all_by_period_pos('Approvisionnement', $from_d, $to_d, $posId);
                        $tot = 0;
                        foreach ($datas as $key => $value) {

                            $pers2 = $user->select_2($value['party_code']);
                            $vente = $ventes->select($value['op_id']);
                            $pers = $customers->selectId($value['party_code']);
                            $achat = $achats->getAchat($value['op_id']);
                            // var_dump($pers2);

                            $tot += $det->select_sum_op($value['op_id']);

                            echo '<tr>
				<td>' . $achat->achat_id . '</td>
				<td><a href="javascript:void(0)" class="row_edit_appro_hist" style="cursor:pointer" data-id="' . $value['op_id'] . '">' . $value['create_date'] . '</a></td><td>' . @$pers2->noms . '</td><td>';

                            echo '<ul class="custom-list">';
                            $datas2 = $det->select_all($value['op_id']);
                            foreach ($datas2 as $un2) {
                                $prod = $products->getProductId($un2['product_id']);
                                echo '<li><b>' . $un2['quantity'] . '</b> - ' . $prod->product_name . '</li>';
                            }
                            //if($det->nb_op($value['op_id'])==0) echo '<a href="javascript:void(0)" class="del_op_appro" data-id="'.$value['op_id'].'" id="'.$value['op_id'].'"><i class="fa fa-times text-danger"></i></a>';
                            echo '</td>';
                            echo '<td align="right">';
                            if ($value['state'] == 1) echo '<span class="badge badge-success">Validé</span>';
                            elseif ($value['state'] == 0) echo '<span class="badge badge-danger">Annulé</span>';
                            else echo '<span class="badge badge-info">Annulé</span></td>';
                            echo '<td><a href="javascript:void(0)" class="row_edit_appro_hist" style="cursor:pointer" data-id="' . $value['op_id'] . '"><i class="text-danger fa fa-file fa-fw" ></i></a</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>
</div>