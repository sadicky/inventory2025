<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"><?=$title?></a></li>
        </ol>
    </nav>

    <div id="message"></div> 
    <a class="btn btn-sm btn-primary mb-3" href="<?=WEBROOT?>newsupplier"><i class="fa fa-plus-circle"></i> NOUVEAU</a>
     
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
                        <?php foreach($suppliers as $b):?>
                        <tr>
                            <td><?=$b->supplier_id?></td>
                            <td><?=$b->supplier_name?></td>
                            <td><?=$b->sup_nif?></td>
                            <td><?=$b->sup_contact?></td>
                            <td>
                                <a href="<?=WEBROOT?>DetailSupplier?id=<?=$b->supplier_id?>"><i class="fa fa-file"></i></a>
                            </td>
                            <?php if($_SESSION['role']==1):?>
                            <td>
                                <a href="#" ><i style="color:red" class="fa fa-trash"></i></a>
                            </td>
                            <?php else: ?>
                                <td>
                               -
                            </td>
                                <?php   endif?>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>