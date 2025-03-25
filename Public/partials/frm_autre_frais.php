<input type="hidden" name="appro" id="direct2">
<div id="myModalAutF" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <h3 style="text-align: center">Autres Frais : Appro No : <?php echo $achat->getNumAchat(); ?></h3>
            <span class="close text-danger">&times;</span>
        </div>
        <div class="p-1 mb-2 m-0" style="border: 1px gray solid; border-radius: 5px;">
            <form action="javascript:void(0)" id="frm_autre_frais" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="row">

                    <div class="col col-md-3">
                        <label class=" form-control-label">Libellé</label>
                        <select id="aut_det" name="aut_det" class="custom-select" required>

                                    <?php
                                    $dat = array('Impots & Taxes','Transport','Autres Frais');
                                    foreach ($dat as $key => $value) {
                                        echo '<option value="'.$value.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                    </div>
                    <div class="col col-md-3">
                        <label class=" form-control-label">Montant</label>
                        <input type="number" id="amount" name="amount"  class="form-control" value="">
                    </div>
                    <div class="col col-md-3">
                        <input type="hidden" id="op_id" name="op_id" value="<?php if(isset($_SESSION['op_appro_id'])) {echo $_SESSION['op_appro_id']; }?>">
                        <input type="hidden" id="operation" name="operation" value="Add">
                        <br>
                        <button type="submit" name="enregistrer" class="btn btn-primary btn-sm"><i class="fa fa-save"></i></button>
                    </div>
                </div>
            </form>
            <h3>Autre Frais</h3>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr><th>Libellé</th><th>Montant</th><th>-</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $tot=0;
                        if(isset($_SESSION['op_appro_id']))
                        {
                        $dat=$aut->select_all_op($_SESSION['op_appro_id']);
                        
                        foreach ($dat as $key => $value) {
                            $tot +=$value['amount'];
                            echo '<tr><td>'.$value['aut_det'].'</td><td align="right">'.$value['amount'].'</td><td align="center"><button class="btn btn-sm del_det_aut" name="delete" data-id="'.$value["aut_id"].'" id="'.$value["aut_id"].'"><i class="fa fa-times"></i></button></td></tr>';
                        }
                        }
                         echo '<tr><th>Total</th><th style="text-align:right">'.number_format($tot).'</th><th>-</th></tr>';
                        ?>

                    </tbody>
                </table>
        </div>
    </div>
</div>