<?php
@session_start();
$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];
// var_dump($products);
$periodes->getPeriode($_SESSION['periode']);
if (isset($_SESSION['op_cmd_id'])) {
    $operations->getOperationId($_SESSION['op_cmd_id']);
    $achats->getAchat($_SESSION['op_cmd_id']);
    $users->getUser($operations->getPartyCode());
}
$d = ($operations->getOperationType('Bon')->last_id); ;
?>
<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
        </ol>
    </nav>
    <div id="message"></div>
    <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>Commandes</a></h6>
        </div>
        <div class="ms-panel-body">
            <form id="formulaire_commande" method="post" autocomplete="off">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="control-label">No BC</label>
                            <input type="text" name="num_cmd" id="num_cmd" class="form-control" value="<?php if (isset($_SESSION['op_cmd_id'])) echo $achats->getAchat($_SESSION['op_cmd_id'])->num_achat; else echo $operations->getOperationType('Bon')->last_id + 1; 
                                                                                                        ?>" <?php if (isset($_SESSION['op_cmd_id'])) echo 'readonly'; ?>>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Produit : </label>
                            <input type="text" id="product" name="product" class="form-control search_products" value="<?php if (!empty($_GET['id'])) echo $pers->getNomComplet(); ?>" autocomplete="off" required>
                            <input type="hidden" name="prod_id" id="prod_id" value="" />
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Qt</label>
                            <input type="text" name="qt" id="qt" class="form-control number-separator" required>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success ms-btn-icon "><i class="fa fa-save"></i></button>
                        </div>
                        <div class="col-md-2" style="padding-left: 35px;">
                            <a href="javascript:void(0)" class="btn ms-btn-icon btn-info new_cmd"><b>Terminer</b></a>
                            <input type="hidden" name="det_id" id="det_id" value="">
                            <input type="hidden" name="operation" id="operation_inv" value="Add">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
</div>
<div class="col-md-12">
    <span style="display: none;"> <?php include('Public/partials/bon_commande.php'); ?> </span>
    <div class="card m-2">
        <div class="card-body">
            <?php include('Public/partials/details_commande.php'); ?>
        </div>
    </div>
</div>
</div>
<hr>