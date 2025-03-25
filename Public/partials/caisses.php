 <?php

require_once("../../Models/Admin/caisse.class.php");
$caisses = new Caisse();
$title = "Gestion des Caisses";
$data = $caisses->getCaisses();
// $getId = $caisses->getCaisses($id);

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
            <h3>Les Caisses</h3>

        </div>
        <div class="ms-panel-body">

            <p><button class="btn btn-primary btn-sm" id="new_cash"><i class="fa fa-plus"></i> Nouveau</button></p>
            <table class="table table-bordered table-sm table-striped display" id="data-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Code</th>
                        <th>Libellé</th>
                        <th>Branhche</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($data as $b):?>
                        <tr>
                            <td><?=$b->caisse_id?></td>
                            <td><?=$b->caisse_name?></td>
                            <td><?=$b->branche ?></td>
                            <td>
                                <a href="#" class="new_cash" data-id="<?=$b->caisse_id?>"><i class="fa fa-edit"></i></a>
                                <a href="#" class="trash_cash" data-id="<?=$b->caisse_id?>"><i style="color:red" class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach?>
                </tbody>
            </table>

        </div>
        <div class="card-footer">

        </div>
         
    </div>
    
    <div style="padding-top: 20px;"></div>
</div>

<script src="assets/js/data-tables.js"></script> 