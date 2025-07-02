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
$caisses = new Caisse();
$branches = new Branches();
$operations = new Operation();
$details = new detOperation();
$achats = new Achat();
$store = new POS();
$autres = new AutreFrais();
$products = new Product();
$suppliers = new Supplier();
$sorties = new Sortie();

$datas = $operations->getOperationType('Sortie');
$supps = $suppliers->getSuppliers();
if ($_SESSION['role'] == 1) {
    $data_store = $store->getStores();
    $caisse = $caisses->getCaisses();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $data_store = $store->getBranchePOS($st->branche_id);
    $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}

// $data_store = $store->getStores();
$idPer = $_SESSION['periode'];

// $per->select($_SESSION['periode']);
if (isset($_SESSION['op_sort_id'])) {
    $op = $operations->getOperationId($_SESSION['op_sort_id']);
    $sort = $sorties->select($_SESSION['op_sort_id']);
    $dt = $operations->getOperationId($datas->last_id);

    // $f = $users->select($dt->party_code);
    $fo = $suppliers->getSupplier($dt->party_code);

    // $c = $caisses->getCaisseId($dt->caisse_id);
    $st_id = $store->getStoreId($dt->pos_id);
    // $pers->select($op->getPartyCode());
}
?>
<section class="row" style="margin: 20px;">
    <div id="message"></div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header bg-light">Sortie - No : <?php echo $sorties->getNumSort(); ?></div>
            <div>
                <div class="card-body">
                    <form id="frm_new_sort" method="post" autocomplete="off">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label">Produit : </label>
                                    <input type="text" id="autocomplete_art" name="content_lib_prod" class="form-control" value="" required>
                                    <input type="hidden" name="prod_id" id="prod_id" value="" />
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Stock</label>
                                        <select class="custom-select" id="pos_id" name="pos_id" required <?php if ($_SESSION['op_appro_id']) echo 'disabled'; ?>>
                                            <option value="">--Select--</option>
                                            <?php
                                            // var_dump($data_store );
                                            foreach ($data_store as $value) {
                                                if (!isset($_SESSION['op_sort_id'])) {

                                                    echo '<option value="' . $value->store_id . '" >' . $value->store . '(' . $value->type . ')</option>';
                                                } else {
                                                    $pos_id = $op->pos_id;
                                                    $p = $store->getStoreId($pos_id);
                                                    echo '<option value="' . $pos_id . '" selected>' . $p->store . '(' . $p->type . ')</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Motif</label>
                                    <select class="custom-select" name="motif" id="motif" <?php if ($_SESSION['op_appro_id']) echo 'disabled'; ?> required>
                                        <!-- <option value="">Choisir</option> -->
                                        <?php
                                        $motif = array('Endomagé', 'Manquant', 'Maison');
                                        foreach ($motif as $e) {
                                            if ($sorties->getMotif() == $e and isset($_SESSION['op_sort_id'])) {
                                                echo '<option value="' . $e . '" selected>' . $e . '</option>';
                                            } else {
                                                echo '<option value="' . $e . '">' . $e . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Fournisseurs</label>
                                    <select name="sup_id" id="sup_id" class="custom-select">
                                        <option value="">--</option>
                                        <?php foreach ($supps as $s): ?>
                                            <option value="<?= $s->supplier_id ?>"><?= $s->supplier_name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Qt<span id="resultat"></span></label>
                                    <input type="hidden" name="lot" id="lot">
                                    <input type="text" name="qt" id="qt" class="form-control number-separator">
                                </div>
                                <div class="col-md-4">
                                    <br> 
                                    <button type="submit" class="ms-btn btn-primary btn-sm"><i class="fa fa-save"></i> Enregistrer</button>

                                    <a href="javascript:void(0)" class="ms-btn btn-sm btn-info new_sort"><i class="fa fa-plus"></i> Nouveau</a>

                                    <input type="hidden" name="op_id" id="op_id" value="<?php if (isset($_SESSION['op_sort_id'])) echo $_SESSION['op_sort_id']; ?>">
                                    <input type="hidden" name="det_id" id="det_id" value="">
                                    <!-- <input type="hidden" name="pos_id" id="pos_id" value="<?php //echo $posId; 
                                                                                                ?>"> -->

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
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped table-condensed display table-sm tabx">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Qt</th>
                                <th>Unité</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_SESSION['op_sort_id'])) {
                                $datas2 = $details->select_all($_SESSION['op_sort_id']);
                                $tot = 0;
                                foreach ($datas2 as $un) {
                                    $prod = $products->getProductId($un['product_id']);

                                    echo '<tr><td >' . $prod->product_name . '</td><td>' . number_format($un['quantity'], 0, '.', ' ') . '</td><td >' . $prod->unt_mes . '</td>
                            <td>
                            <a href="javascript:void(0)" class="del_det_sort" name="delete" data-id="' . $un["details_id"] . '" id="' . $un["details_id"] . '"><i class="fa fa-times"></i></a>
                            </td></tr>';
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