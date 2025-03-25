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
require_once('../../Models/Admin/personne.class.php');
$caisses = new Caisse();
$branches = new Branches();
$operations = new Operation();
$details = new detOperation();
$achats = new Achat();
$store = new POS();
$autres = new AutreFrais();
$products = new Product();
$users = new Personne();
$suppliers = new Supplier();

$branches = $branches->getBranches();
$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];
$role = $_SESSION['role'];

//es(); //
if ($_SESSION['role'] == 1) {
    $stores = $store->getStorePrincipal();
    $caisse = $caisses->getCaisses();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBrancheStockPOS($st->branche_id);
    $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}
// var_dump($stores);
$datas = $operations->getOperationType('Approvisionnement');
$dataBon = $operations->getOperationTypes('Bon', '1');


$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];

if (isset($_SESSION['op_appro_id'])) {
    $o = $operations->getOperationId($_SESSION['op_appro_id']);
    $d = $achats->getAchat($_SESSION['op_appro_id']);
    $dt = $operations->getOperationId($datas->last_id);

    $f = $users->select($dt->party_code);
    $fo = $suppliers->getSupplier($dt->party_code);

    $c = $caisses->getCaisseId($dt->caisse_id);
    $st_id = $store->getStoreId($dt->pos_id);
    // var_dump($st_id);
}

$d = $operations->getOperationType('Bon')->last_id;

?>
<div class="row" style="margin: 20px;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">Entrée de Stocks</div>
            <div class="card-body">
                <form id="formulaire_achat" method="post" autocomplete="off">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label">Caisse</label>
                                <?php if (isset($_SESSION['op_appro_id'])) {  ?>
                                    <input type="text" name="pay_type" id="pay_type" class="form-control" value="<?php echo $c->caisse_name . '(' . $c->branche . ')'; ?>" readonly>
                                <?php } else { ?>
                                    <select class="custom-select" name="pay_type" id="pay_type">
                                        <?php
                                        foreach ($caisse as $value) {
                                            echo '<option value="' . $value->caisse_id . '">' . $value->caisse_name . '(' . $value->branche . ')</option>';
                                        }
                                        ?>
                                    </select>
                                <?php } ?>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">STOCK</label>
                                    <?php if (isset($_SESSION['op_appro_id'])) {  ?>
                                        <input type="text" name="pos_id" id="pos_id" class="form-control" value="<?php echo $st_id->type; ?>" readonly>
                                    <?php } else { ?>
                                        <select class="custom-select" id="pos_id" name="pos_id" required>

                                            <?php
                                            foreach ($stores as $value) {
                                                echo '<option value="' . $value->store_id . '" selected>' . $value->type . '(' . $value->store . ')</option>';
                                            }

                                            ?>
                                        </select>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="control-label">Fournisseurs</label>
                                <input type="hidden" name="num_achat" id="num_achat" class="form-control">
                                <input type="text" id="autocomplete" name="content_lib_sup" class="form-control" value="<?php if (isset($_SESSION['op_appro_id'])) echo $fo->supplier_name;  ?>" autocomplete="off" <?php if (isset($_SESSION['op_appro_id'])) echo 'readonly'; ?>>
                                <input type="hidden" name="sup_id" id="sup_id" value="<?php if (isset($_SESSION['op_appro_id'])) echo $fo->personne_id; ?>" />
                            </div>

                            <div class="col-md-4">
                                <label class="control-label">Produit : </label>
                                <span id="prod_info"><?php if (isset($_SESSION['op_appro_id']) and !empty($doc_type)) {
                                                        ?>
                                        <select class="custom-select" id="prod_id" name="prod_id">

                                            <?php
                                                            $dat = $details->select_all_6($_SESSION['op_appro_id'], 0);
                                                            echo '<option value="">--Choisir--</option>';
                                                            foreach ($dat as $key => $un) {
                                                                if (!$details->existop_2($_SESSION['op_appro_id'], $un->product_id)) {
                                                                    echo '<option value="' . $un->product_id . '">' . $un->product_name . ' (' . $un->quantity . ')</option>';
                                                                    $details->update_one($un->details_id, 'details_id', 'det', '0');
                                                                } else {

                                                                    $details->update_one($un->details_id, 'details_id', 'det', '1');
                                                                }
                                                            }
                                            ?>
                                        </select>
                                    <?php
                                                        } else {
                                    ?>
                                        <input type="text" id="autocomplete_art" name="content_lib_art" class="form-control" value="" autocomplete="off">
                                        <input type="hidden" name="prod_id" id="prod_id" value="" />
                                    <?php
                                                        }

                                    ?>
                                </span>
                            </div>
                            <!-- <div class="col-md-4">
                                <?php if ($_SESSION['role'] == 1): ?>
                                    <label class="control-label">P.U.A</label>
                                    <input type="text" name="price" id="price" value="0" class="form-control number-separator">
                                <?php else: ?>
                                    <input type="hidden" name="price" id="price" class="form-control number-separator">
                                <?php endif ?>
                            </div> -->
                            <div class="col-md-4">
                                <label class="control-label">Qt<span id="qtedispo"></span></label>
                                <input type="hidden" name="price" id="price" value="0" class="form-control number-separator">
                                <input type="hidden" name="lot" id="autocomplete_lot" class="form-control lot">
                                <input type="text" name="qt" id="qt" class="form-control number-separator" required>
                            </div>

                            <div class="col-md-4"><br>
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Enregistrer</button>
                                <?php if (isset($_SESSION['op_appro_id']) and $operations->exist_in_trans($_SESSION['op_appro_id']) and $details->nb_op($_SESSION['op_appro_id']) > 0) { ?>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning end_appro" data-id="<?php echo $_SESSION['op_appro_id']; ?>"><i class="fa fa-minus"></i> Cloturer</a>
                                <?php } ?>
                                <?php if (isset($_SESSION['op_appro_id']) and !$operations->exist_in_trans($_SESSION['op_appro_id'])) { ?>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info end_appro"><i class="fa fa-times"></i> Terminer</a>
                                <?php } ?>

                                <?php if (isset($_SESSION['op_appro_id']) and $details->nb_op($_SESSION['op_appro_id']) == 0) { ?>
                                    <a href="javascript:void(0)" class="del_op_appro btn btn-danger btn-sm" id="<?php echo $_SESSION['op_appro_id']; ?>"><i class="fa fa-times"></i> Annuler</a>
                                <?php } ?>

                                <input type="hidden" name="op_id" id="op_id" value="<?php if (isset($_SESSION['op_appro_id'])) echo $_SESSION['op_appro_id']; ?>">
                                <input type="hidden" name="det_id" id="det_id" value="">
                                <input type="hidden" name="operation" id="operation_inv" value="Add">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-2">
        <span style="display: none;">
            <?php //include('../../Public/partials/bon_appro.php'); 
            ?></span>
        <div class="card">
            <div class="card-body">
                <?php include('../../Public/partials/details_achat.php'); ?>
            </div>
        </div>
    </div>
</div>

<div style="padding-top: 20px;"></div>

<script src="assets/js/data-tables.js"></script>