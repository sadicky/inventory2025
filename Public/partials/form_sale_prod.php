<?php
$datas = $customers->select_all();
// var_dump($un);
$store = $stores->getPOS($_SESSION['pos']); ?>
<div class="card card-info">
    <div class="card-header bg-light"> 
        <h3 style="font-size: 16px; font-weight: bold">Tarif de vente</h3>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Client</label> <a href="javascript:void(0)" data-toggle="modal" class="editCust" ><i class="fa fa-plus"></i></a>
                <select class="select2" id="cust_id" name="cust_id" required>
                    <option value="">Choisir</option>
                    <?php
                    foreach ($datas as $un) {
                        if (isset($_SESSION['op_vente_id']) and $op->party_code == $un->customer_id ) {
                            echo '<option value="' . $un->customer_id  . '" selected>' .  $un->customer_name. '</option>';
                        } else {
                            echo '<option value="' . $un->customer_id . '">' . $un->customer_name. '</option>';
                        }
                    }
                    ?>
                </select>

                <!-- <form action="javascript:void(0)" method="post" autocomplete="off">
                    <input type="text" id="content_srch_cust" name="content_lib_cust" class="form-control" placeholder="Recherche du client" autocomplete="off" required>
                    <span style="display: none;"><input type="text" name="cust_id" id="tiers_id" required /></span>
                </form> -->
            </div>
            <div class="col-md-6">
                <input type="hidden" value="<?= $store->store_id ?>" id="tar_id" name="tar_id" required>
                <form class="m-0" autocomplete="off">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Produit</label>
                            <input type="text" name="med_crt_t" id="med_crt_t" class="form-control" placeholder="Recherche" value="" required>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="tab_current_tar">

        </div>
    </div>
</div>

<?php include('../../Public/modals/customer.php'); ?>
<div style="padding-top: 20px;"></div>
<script src="assets/js/select/js/select2.js"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
    });
</script>