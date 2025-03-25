<?php

require_once('../../Models/Admin/branches.class.php');
$branches = new Branches();

$title = "Notes";

ob_start();
$data = $branches->getNotes();


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

        <div class="ms-panel-header">
            <h6>Notes | <a href="javascript:void(0)" id="new_note"> <i class="fa fa-plus"></i> Nouveau</a> </h6>
        </div>
        <div class="ms-panel-body">
            <div class="table-responsive">
                <table id="data-table" class="table table-condensed table-bordered table-sm display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Types</th>
                            <th>Par</th>
                            <th>Date</th>
                            <th>Voir</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $b): ?>
                            <tr>
                                <td><a href="javascript:void(0)" class="note_id" id="<?= $b->note_id ?>">#000<?= $b->note_id ?></a></td>
                                <td><?= $b->type ?></td>
                                <td><?= $b->noms ?></td>
                                <td><?= $b->date ?></td>
                                <td><a href="javascript:void(0)" class="note_id" id="<?= $b->note_id ?>">Afficher</a></td>
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