<?php
// unset($_SESSION['op_vente_id']);

$branches = $branches->getBranches();
$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];
// var_dump($products);

$staffs = $users->getStaff();
$datas = $customers->select_all();

// var_dump($dataBon);die();

$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];

if (isset($_SESSION['op_vente_id'])) {
    $o = $operations->getOperationId($_SESSION['op_vente_id']);
    // @$f = $suppliers->getSupplier($dt->id_per);
    // @$c = $caisses->getCaisseId($dt->caisse_id);
    $cust = $customers->select($o->party_code);
    $staff = $users->getStaffId($o->tar_id);
    $doc_type = $o->doc_type;
    $pos_id = $o->pos_id;
    echo '<input type="hidden" value="' . $_SESSION['op_vente_id'] . '" id="crt_op_id" name="crt_op_id">';

    // die();
}
?>
<div class="row" style="margin: 20px;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">Entrée les Informations <b>(<?php if ($_GET['id'] == 0) echo 'FACTURE VENTE DETTE';
                                                                            if ($_GET['id'] == 1) echo 'FACTURE VENTE CASH';
                                                                            if ($_GET['id'] == 2) echo 'FACTURE PROFORMAT'; ?>)</b></div>
            <div class="card-body">
                <form id="formulaire_market" method="post" autocomplete="off">
                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-6">
                                <label class="control-label">Client</label> <a href="javascript:void(0)" data-toggle="modal" class="editCust"><i class="fa fa-plus"></i></a>

                                <form action="javascript:void(0)" method="post" autocomplete="off">
                                    <input type="text" value="<?php if (isset($_SESSION['op_vente_id'])) echo $cust->customer_name; ?>" <?php if (isset($_SESSION['op_vente_id'])) echo "readonly"; ?> id="autocomplete" name="content_lib_cust" class="form-control" placeholder="Recherche du client" autocomplete="off" required>
                                    <span style="display: none;"><input type="text" value="<?php if (isset($_SESSION['op_vente_id'])) echo $cust->customer_id; ?>" name="cust_id" id="cust_id" required /></span>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Produit : </label>
                                <input type="text" id="autocomplete_art" name="content_lib_art" class="form-control" value="" autocomplete="off">
                                <input type="hidden" name="prod_id" id="prod_id" value="" />
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Prix de Vente</label>
                                <input type="hidden" name="type" id="type" value="<?= $_GET['id'] ?>">
                                <input type="text" name="price" id="price" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Dispo</label>
                                <input type="text" id="qty" name="qty" class="form-control" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="control-label">Qté</label>
                                <input type="text" name="qt" id="qt" class="form-control" required>
                            </div>
                            <hr>
                            <div class="col-md-6">
                                <label class="control-label">Agent</label>
                                <?php if (isset($_SESSION['op_vente_id'])) : ?>
                                    <input type="text" readonly class="form-control" name="agent_id" id="agent_id" readonly value="<?= $staff->noms ?>" />
                                <?php else: ?>
                                    <select name="agent_id" id="agent_id" class="select2">
                                        <option value="">--</option>
                                        <?php foreach ($staffs as $s): ?>
                                            <option value="<?= $s->staff_id ?>"><?= $s->noms ?></option>
                                        <?php endforeach ?>
                                    </select>
                                <?php endif ?>
                            </div>

                            <!-- <hr>
                            <hr>
                            <div class="col-md-6">
                                <label for="">Detais du client</label>
                                Retard de paiment <br>
                            </div> -->
                            <span id="details"></span>

                            <div class="col-md-6 pt-3">
                                <input type="hidden" name="tar_id" id="tar_id_v" value="">
                                <input type="hidden" name="op_id" id="op_id" value="<?php if (isset($_SESSION['op_vente_id'])) echo $_SESSION['op_vente_id']; ?>">
                                <input type="hidden" name="det_id" id="det_id" value="">
                                <input type="hidden" name="pos_id" id="pos_id_v" value="<?php echo $posId; ?>">
                                <input type="hidden" name="operation" id="operation_inv" value="Add">
                                <input type="hidden" name="date_vente" value="<?php echo date('Y-m-d'); ?>">
                                <?php if ($change) { ?><button class="btn btn-primary addv" type="submit"><i class="fa fa-save"></i></button><?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div style="padding-top: 20px;"></div>

<?php include('../../Public/modals/customer.php'); ?>
<script src="assets/js/data-tables.js"></script>