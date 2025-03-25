<?php
session_start();
// unset($_SESSION['op_appro_id']);
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/supplier.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/livraison.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/config.class.php');
$caisses = new Caisse();
$branches = new Branches();
$operations = new Operation();
$details = new detOperation();
$achats = new Achat();
$stores = new POS();
$autres = new AutreFrais();
$products = new Product();
$suppliers = new Supplier();
$sorties = new Sortie();
$user = new User();
$conf = new Config();
$livraisons = new Livraison();

if ($_SESSION['role'] == 1) {
    $data_store = $stores->getStores();
    $caisse = $caisses->getCaisses();
} else {
    $st = $stores->getStoreId($_SESSION['pos']);
    $data_store = $stores->getBranchePOS($st->branche_id);
    $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}

$cfg = $conf->select('1');
// $data_store = $stores->getStores();
$idPer = $_SESSION['periode'];

// $per->select($_SESSION['periode']);
// $posId=$_SESSION['pos'];

if (isset($_SESSION['op_chg_id'])) {
    $op = $operations->getOperationId($_SESSION['op_chg_id']);
    $opTo = $operations->getOperationId($op->party_code);
    // $pers = $operations->getOperationId($op->getPartyCode());
}
?>
<section class="row" style="margin: 10px;">
    <div id="message"></div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header bg-light">Transfert</div>
            <div>
                <div class="card-body">
                    <form id="form_new_chg" method="post" autocomplete="off">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label">Produit</label>
                                    <input type="text" id="autocomplete_art" name="content_lib_prod" class="form-control" value="" required>
                                    <input type="hidden" name="prod_id" id="prod_id" value="" />
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Origine</label>
                                        <select class="custom-select" id="pos_id" name="pos_id" required readonly>
                                            <option value="">--Choisir--</option>
                                            <?php
                                            // $datas = $stores->getStores();
                                            foreach ($data_store as $value) {
                                                echo '<option value="' . $value->store_id . '">' . $value->store . '(' . $value->type . ')</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Destination</label>
                                        <select class="custom-select" id="dest_id" name="dest_id" required readonly>
                                            <option value="">--Choisir--</option>
                                            <?php
                                            $datas = $stores->getStores();
                                            foreach ($datas as $value) {
                                                echo '<option value="' . $value->store_id . '">' . $value->store . '(' . $value->type . ')</option>';
                                            }

                                            ?>
                                        </select>

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="control-label">Qt<span id="resultat"></span></label>
                                    <input type="hidden" name="lot" id="lot">
                                    <input type="text" name="qt" id="qt" class="form-control number-separator">
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-5">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Enregistrer</button>
                                    <input type="hidden" name="op_id" id="op_id" value="<?php if (isset($_SESSION['op_chg_id'])) echo $_SESSION['op_chg_id'] ?>">

                                    <?php if (isset($_SESSION['op_chg_id']) and $details->nb_op($_SESSION['op_chg_id']) > 0) { ?>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-info new_chg"><i class="fa fa-check-circle"></i> Terminer</a>
                                    <?php } ?>
                                    <input type="hidden" name="det_id" id="det_id" value="">
                                    <input type="hidden" name="price" id="price" class="form-control">

                                    <input type="hidden" name="operation" id="operation_inv" value="Add">
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-4">

        <div class="card">
            <div class="card-body">
                <span style="display: none; "><?php include('../../Public/script/tab_bon_livr.php'); ?></span>
                <?php
                if (isset($_SESSION['op_chg_id'])) {
                    $liv = $livraisons->select_pro($_SESSION['op_chg_id']);
                    if (!empty($liv->liv_num)) { ?>
                        <p><a href="javascript:void(0)" id="print_bon_liv" class="btn btn-sm btn-info mr-2 mt-2"><i class="fa fa-print"></i> Bon de livraison</a></p>
                    <?php } else { ?>
                        <form class="form-inline" id="form_join_bon" class="collapse">
                            <label class="mr-2">Joindre un BL</label>
                            <button type="submit" class="ms-btn-icon btn-primary"><i class="fa fa-plus"></i></button>
                        </form>
                <?php }
                } ?>
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped table-condensed display table-sm tabx">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Qt</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_SESSION['op_chg_id'])) {
                                $results = $details->select_all($_SESSION['op_chg_id']);
                                // var_dump($results);
                                $tot = 0;
                                foreach ($results as $un) {
                                    $prods = $products->getProductId($un['product_id']);
                                    $detTo = $products->getProductId($un['lot']);
                                    echo '<tr><td >' . $prods->product_name . '</td><td>' . $un['quantity'] . '</td>';

                                    echo '
                            <td><a href="javascript:void(0)" class="del_det_chg text-danger" name="delete" data-id="' . $un['details_id'] . '" id="' . $un['details_id'] . '"><i class="fa fa-times"></i></a></td></tr>';
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div style="padding-top: 20px;"></div>
<script src="assets/js/data-tables.js"></script>