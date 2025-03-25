<?php 
@session_start();
$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];

require_once('../../Models/Admin/supplier.class.php');
$suppliers = new Supplier();

$suppliers = $suppliers->getSuppliers();
$title = "Commandes";
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
            <h6>Informations générales du Fournisseur <span class="text-success">(<?=$view->supplier_name?>)</span></h6>
        </div>

        <div class="ms-panel-body">

            <div class="row">
                <div class="col-sm-3"><!--left col-->
                    
                    <ul class="list-group">
                            <li class="list-group-item text-right"><a href="<?=WEBROOT?>newsupplier" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Nouveau</a></li>
                            <li class="list-group-item text-right"><button class="btn btn-danger btn-sm trash_stk"><i class="fa fa-times-circle"></i> Supprimer</button></li>
                  </ul>

                <input type="hidden" id="supplier_id" value="<?=$view->supplier_id?>">
                </div><!--/col-3-->
                <div class="col-sm-9">
                    <ul class="nav nav-tabs tabs-bordered d-flex nav-justified mb-4" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home">Général</a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#compte">Comptes</a>
                        </li>
                        <?php if (!empty($_GET['id'])) { ?>
                            <li role="presentation" class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#sup_history" id="sup_achat">Historique des Achats</a>
                            </li>
                            <li role="presentation" class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#disp_dep" id="tiers_dep">Paiement</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active active show fade in" id="home">
                            <hr>
                            <?php include('Public/partials/form_supplier.php'); ?>
                            <hr>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="compte">
                            <hr>
                            <?php include('Public/partials/account_supplier.php'); ?>
                            <hr>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="sup_history">
                     </div>
                        <div role="tabpanel" class="tab-pane fade" id="disp_dep"> </div>
                    </div>
                </div><!--/tab-content-->
            </div><!--/col-9-->
        </div>
    </div>
</div>

<div style="padding-top: 20px;"></div>