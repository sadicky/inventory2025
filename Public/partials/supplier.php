<?php
@session_start();
$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];

require_once('../../Models/Admin/supplier.class.php');
$suppliers = new Supplier();

$suppliers = $suppliers->getSuppliers();
$title = "Fournisseur";
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
    <a class="btn btn-sm btn-primary mb-3" href="javascript:void(0)" id="newsupplier"><i class="fa fa-plus-circle"></i> NOUVEAU</a>

    <div class="ms-panel">

        <div class="ms-panel-header">
            <h6>Tous les Fournisseurs</h6>
        </div>

        <div class="ms-panel-body">
            <div class="table-responsive">
                <table id="data-table" class="table table-condensed table-bordered table-sm display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom complet(Raison sociale)</th>
                            <th>Identification</th>
                            <th>Contact</th>
                            <th>Afficher</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($suppliers as $b): ?>
                            <tr>
                                <td><?= $b->supplier_id ?></td>
                                <td><?= $b->supplier_name ?></td>
                                <td><?= $b->sup_nif ?></td>
                                <td><?= $b->sup_contact ?></td>
                                <td>
                                    <a href="javascript:void(0)" class="detail_supplier" data-id="<?= $b->supplier_id ?>"><i class="fa fa-file"></i></a>
                                </td>
                                <td>
                                    <a href="#"><i style="color:red" class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="padding-top: 20px;"></div>

</div>

<script src="assets/js/data-tables.js"></script>