<?php
@session_start();
$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];

require_once('../../Models/Admin/supplier.class.php');
$suppliers = new Supplier();

$suppliers = $suppliers->getSuppliers();
$title = "Nouveau Fournisseur";
// var_dump($products);
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
            <h6>Nouveau Fournisseur</h6>
        </div>

        <div class="ms-panel-body">

            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs tabs-bordered d-flex nav-justified mb-4" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home">Général</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active active show fade in" id="home">
                            <hr>
                            <?php include('../../Public/partials/form_supplier.php'); ?>
                            <hr>
                        </div>
                    </div>
                </div><!--/tab-content-->
            </div><!--/col-9-->
        </div>
    </div>
</div>