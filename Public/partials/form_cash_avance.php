<?php
@session_start();

require_once("../../Models/Admin/caisse.class.php");
require_once("../../Models/Admin/transaction.class.php");
require_once("../../Models/Admin/branches.class.php");
require_once("../../Models/Admin/customer.class.php");
require_once("../../Models/Admin/store.class.php");
$store = new POS();
$caisses = new Caisse();
$transactions = new Transactions();
$branche = new Branches();
$customer = new Customer();
$datas = $customer->select_all();

if (!empty($_GET['ad_id'])) {
    $trans = $transactions->select_0($_GET['ad_id']);
}

if ($_SESSION['role'] == 1) {
    $stores = $branche->getBranches();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $branche->getBranche_0($st->branche_id);
    // var_dump($stores);
}
?>
<div style="margin-left: 30px;">
    <a href="javascript:void(0)" class="btn btn-danger btn-sm" id="tab_avances"> Listes Avance Dette</a>
</div>
<div class="card" style="margin:25px; margin-bottom:50px;">

    <div class="card-header text-center">
        <strong>Avance sur Dette</strong>
    </div>
    <div class="card-body card-block">
        <form method="POST" id="form_avance_dette" enctype="multipart/form-data">
            <div class="row">
                <div class="col col-md-3">
                    <div class="form-group">
                        <label class=" form-control-label">Date</label>
                        <input type="date" id="trans_date" name="trans_date" class="form-control" value="<?php if (!empty($_GET['ad_id'])) echo @$trans->create_date;
                                                                                                            else echo @$jour->jour_state; ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Branche</label>
                        <select id="id_bq" name="id_bq" class="custom-select" required>
                            <option value="">Choisir</option>
                            <?php
                            foreach ($stores as $e) {
                                echo '<option value="' . $e->branche_id . '">' . $e->branche . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Client</label>
                        <select class="select2" id="cust_id" name="cust_id" required>
                            <option value="">Choisir</option>
                            <?php
                            foreach ($datas as $un) {
                                if (isset($_SESSION['op_vente_id']) and $o->party_code == $un->customer_id) {
                                    echo '<option value="' . $un->customer_id  . '" selected>' .  $un->customer_name . '</option>';
                                } else {
                                    echo '<option value="' . $un->customer_id . '">' . $un->customer_name . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class=" form-control-label">Valeur Montant en USD</label>
                        <input type="text" id="mont_trans" name="mont_trans" class="form-control number-separator" value="<?php if (!empty($_GET['ad_id'])) echo number_format($trans->amount, 0, ' ', '.');
                                                                                                                            else '0'; ?>" required>

                    </div>
                </div>
                <div class="col-md-3">
                    <?php if (!empty($_GET['ad_id'])) {
                    ?>
                        <input type="hidden" id="operation" name="operation" value="Edit">
                        <input type="hidden" id="ad_id" name="ad_id" value="<?php echo $_GET['ad_id']; ?>">
                    <?php
                    } else {
                    ?>
                        <input type="hidden" id="operation" name="operation" value="Add">
                    <?php } ?>
                    <br />
                    <button type="submit" name="enregistrer" id="enregistrer" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div style="padding-top: 20px;"></div>