<div class="card card-info">
    <div class="card-header">
        <form id="form_sale" method="post" autocomplete="off">
            <div class="row">
                <div class="col-md-7">
                    <label class="control-label">Produit : </label>
                    <input type="text" id="prod_name" name="prod_name" class="form-control" value="" required readonly />
                    <input type="hidden" name="prod_id" id="prod_id">
                </div>
                <div class="col-md-4">
                    <label class="control-label">Qté</label>
                    <input type="number" name="qt" id="qt" class="form-control" step="any" required>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Prix</label>
                    <input type="text" name="price" id="price" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <br />
                    <input type="hidden" id="percent" name="percent" class="form-control" value="0">
                    <!-- <input type="hidden" name="price" id="price" value=""> -->
                    <input type="hidden" name="lot" id="lot" value="">
                    <input type="hidden" name="tar_id" id="tar_id_v" value="">
                    <input type="hidden" name="op_id" id="op_id" value="<?php if (isset($_SESSION['op_vente_id'])) echo $_SESSION['op_vente_id']; ?>">
                    <input type="hidden" name="det_id" id="det_id" value="">
                    <input type="hidden" name="pos_id" id="pos_id_v" value="<?php echo $posId; ?>">
                    <input type="hidden" name="operation" id="operation_inv" value="Add">
                    <input type="hidden" name="date_vente" value="<?php echo date('Y-m-d'); ?>">
                    <?php if ($change) { ?><button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button><?php } ?>
                </div>
            </div>
            <div class="col-md-12 mt-2">
                
            <!-- <a href="javascript:void(0)" class="btn btn-info mr-2 mt-2 btn-sm end_sale"><i class="fa fa-plus"></i> Nouveau</a> -->
                <?php
                $op = $operations->getOperationId(@$_SESSION['op_vente_id']);
                $cust = $customers->selectId(@$op->party_code);
                $branche = $stores->getPOS(@$op->pos_id);
                // var_dump($branche);
                if (isset($_SESSION['op_vente_id']) and $change == true) {

                        echo '<b>Client :';
                        echo $cust->customer_name;
                        $acc = $accounts->select($op->party_code);
                        $bq = $caisses->select_status('1',$branche->branche_id);
                         //var_dump($bq);
                        // $credit = $transactions->select_sum_cred_2($op->party_code, $bq->caisse_id);
                      
                        // if (@$acc->cred_limit > 0 and $acc->cred_limit < $credit) echo '<span style="display:block" class="text-danger">Vous avez depassez votre Limite de credit</span>';
                    }
                    echo '</b>';
                
                ?>
            </div>
        </form>
    </div>
    <div class="card-footer">
    </div>
</div>