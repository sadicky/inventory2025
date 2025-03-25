<?php
@session_start();
require_once('../../Models/Admin/store.class.php');	
$stores = new POS();	
$pos = $stores->getPOS($_GET['id']);
?> 
<div class="card card-info" style="margin:25px;">
    <div class="card-header bg-light h6">
    Changement de POS : <span class="text-danger"><?php echo 'POS: '. $pos->store.' - '.$pos->type;  ?></span>
     </div>
    <div>
        <div class="card-body">
            <form id="frm_change_pos" method="post">
                <div class="form-body">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Destination</label>
                                <select class="custom-select" id="pos_id" name="pos_id" required >
                                    <?php
                                    $datas=$stores->getBranchePOS($pos->branche_id);
                                    foreach ($datas as $value) {
                                        if ($value->pos_id!=$_SESSION['pos']) {
                                            echo '<option value="'.$value->store_id.'" selected>'.$value->store.'-'.$value->type.'</option>';
                                        }
                                    }
                                    ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <button class="btn btn-primary btn-sm" type="submit">Changer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
