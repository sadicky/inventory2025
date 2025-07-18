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
$personnes = new Personne();
$cust = new Customer();
$branche = new Branches();
$transactions = new Transactions();
$customers = new Customer();
$store = new POS();
$ventes = new Vente();

const COMMISSION = 0.02;

if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = date('Y-m-01');
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
                        <input type="date" id="from_d" name="from_d" class="form-control" value="<?php echo $from_d; ?>" required>
                        <input type="hidden" id="pos_id" name="pos_id" value="<?php echo $agent_id; ?>">
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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm tab">
                    <thead>
                        <tr>
                            <th>Agent</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Montant</th>
                            <th>Commission(2%)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $datas = $ventes->select_sum_commission_agent($agent_id, $from_d, $to_d);
                        $tot = 0;

                        foreach ($datas as $key => $value) {
                            $tot += $value->amount;
                            $pers = $personnes->select($value->party_code);
                            $staff = $user->getStaffId($value->party_aux);
                        ?>

                            <tr>
                                <td><?= $staff->noms ?></td>
                                <td><?= $value->create_date ?></td>
                                <td><?= $pers->nom_complet ?></td>
                                <td><?= number_format($value->amount, 0, ',', ' ')  ?> </td>
                                <td><?= number_format($value->amount * 0.02, 0, ',', ' ')  ?> </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                    <tfooter>
                        <th style="text-align:right;" colspan="3"></th>
                        <th>Total</th>
                        <th><?= number_format($tot * COMMISSION, 0, ',', ' ')  ?></th>
                    </tfooter>
                </table>
            </div>
        </div>
    </div>