<?php
@session_start();

require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/customer.class.php');
require_once('../../Models/Admin/vente.class.php');


$user = new User();
$cust = new Customer();
$branche = new Branches();
$transactions = new Transactions();
$customers = new Customer();
$store = new POS();
$ventes = new Vente();

if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = date('Y-m-d');
if (!empty($_GET['to_d'])) $to_d = $_GET['to_d'];
else $to_d = date('Y-m-d');

if (!empty($_GET['id'])) $agent_id = $_GET['id'];
else $agent_id = '';

if ($_SESSION['role'] == 1) {
    $stores = $user->getStaff();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $user->getStaffBranche($st->branche_id);
}

?>
<div class="card" style="margin: 30px;">

    <div class="card-header bg-light">Rapport des Commissions Du <?php echo $from_d; ?> Au <?php echo $to_d; ?></div>
    <div class="card-body">
        <form method="post" id="ad-commission">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Du : </label>
                        <input type="hidden" id="pos_id" name="pos_id" value="<?php echo $agent_id; ?>">
                        <input type="date" id="from_d" name="from_d" class="form-control" value="<?php echo $from_d; ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Au : </label>
                        <input type="date" id="to_d" name="to_d" class="form-control" value="<?php echo $to_d; ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <br>
                    <button type="submit" name="valider" class="ms-btn-icon btn-primary"><i class="text-white fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <hr>
        <section id="commission"></section>
        <hr>
    </div>
</div>