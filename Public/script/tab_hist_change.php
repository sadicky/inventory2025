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

if ($_SESSION['role'] == 1) {
    $data = $pos->getStores();
    $caisse = $caisses->getCaisses();
} else {
    $st = $pos->getStoreId($_SESSION['pos']);
    $data = $pos->getBranchePOS($st->branche_id);
    $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}

$idPer = $_SESSION['periode'];
$per = $periodes->getPeriode($_SESSION['periode']);


if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = date('Y-m-d');
if (!empty($_GET['to_d'])) $to_d = $_GET['to_d'];
else $to_d = date('Y-m-d');
if (!empty($_GET['pos_id'])) $posId = $_GET['pos_id'];
else $posId = $_SESSION['pos'];
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
    <div class="card-header bg-light">Historique des transferts</div>
    <div class="card-body">
        <form method="post" id="chg-search">
            <div class="row">
                <div class="col-md-2">
                    <label class="control-label">Du</label>
                    <input type="date" name="from_d" id="from_d" class="form-control" value="<?php if (!empty($_GET['from_d'])) echo $_GET['from_d'];
                                                                                                else echo $per->debut; ?>">
                </div>
                <div class="col-md-2">
                    <label class="control-label">Au</label>
                    <input type="date" name="to_d" id="to_d" class="form-control" value="<?php if (!empty($_GET['to_d'])) echo $_GET['to_d'];
                                                                                            else echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">STOCK</label>
                        <select class="custom-select" id="pos_id" name="pos_id" required readonly>

                            <?php
                            // $datas = $pos->getStores();
                            foreach ($data as $value) {
                                if ($value->store_id == $posId) {
                                    echo '<option value="' . $value->store_id . '" selected>' . $value->store . '(' . $value->type . ')</option>';
                                } else {
                                    echo '<option value="' . $value->store_id . '">' . $value->store . '(' . $value->type . ')</option>';
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-2">
                    <br>
                    <button type="submit" class="ms-btn-icon btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <?php if (!empty($_GET['pos_id'])) : ?>
            <div class="title m-3" style="text-align: center; font-weight: bold; font-size: 14px;">
                <h3>Du <?php echo $from_d; ?> Au <?php echo $to_d; ?></h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm tab">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Produits</th>
                            <th>Origine</th>
                            <th>Destination</th>
                            <th>-</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $datas = $operations->select_all_by_period('Transfert', $_GET['from_d'], $_GET['to_d'], $_GET['pos_id']);
                        // var_dump($datas);
                        foreach ($datas as $key => $value) {
                            $po = $pos->getPOS($value['pos_id']);
                            $op = $operations->getOperationPartyCode($value['party_code']);
                            $posTo = $pos->getPOS($op->party_code);
                            // var_dump($posTo);
                            echo '<tr>
                <td><button class="ms-btn-icon btn-light btn-sm row_edit_chg_hist" style="cursor:pointer" data-id="' . $value['op_id'] . '"><i class="fa fa-edit fa-fw" ></i></button> </td>
                <td>' . $value['create_date'] . '</td><td>';

                            echo '<ul class="custom-list">';
                            $datas2 = $det->select_all($value['op_id']);
                            // var_dump($datas2);
                            foreach ($datas2 as $un2) {
                                $prod = $products->getProductId($un2['product_id']);
                                echo '<li>' . $un2['quantity'] . ' ' . $prod->product_name . '</li>';
                            }
                            echo '</ul>';

                            echo '</td><td>' . $po->store . ' - ' . $po->type . '</td><td>' . $posTo->store . ' - ' . $posTo->type . '</td><td>';

                            if ($det->nb_op($value['op_id']) == 0)
                                echo '<button class="ms-btn-icon btn-danger btn-circle btn-sm del_op_chg" name="delete" data-id="' . $value['op_id'] . '" id="' . $value['op_id'] . '"><i class="fa fa-times"></i></button>';
                            else
                                echo '-';

                            echo '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>