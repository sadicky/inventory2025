<?php

require_once('../../Models/Admin/branches.class.php');
$branches = new Branches();

$title = "Notes";

$data = $branches->getNoteId($_GET['id']);
// var_dump($data);

?>

<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
        </ol>
    </nav>

    <div id="message"></div>
    <div class="ms-panel" style="margin: 10px 50px 10px 50px;">
        <div class="ms-panel-header header-mini">
            <div class="d-flex justify-content-between">
                <h6>Note</h6>
                <h6>#00<?= $data->note_id ?></h6>
            </div>
        </div>
        <hr>
        <div class="ms-panel-body">
            <!-- Invoice To -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="invoice-address">
                        <h5>Type: <?= $data->type ?></h5>
                    </div>
                </div>
                <div class="col-md-6 text-md-right">
                    <ul class="invoice-date">
                        <li>Date : <b><?= $data->date ?></b></li>
                        <li>Par : <b><?= $data->noms ?></b></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="ms-invoice-table table-responsive mt-1">
                <h6>Description</h6>
                <?= $data->descr ?>
            </div>
        </div>
    </div>
    <div style="padding-top: 20px;"></div>

</div>