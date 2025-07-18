<?php
session_start();
require_once("../../Models/Admin/customer.class.php");
require_once("../../Models/Admin/personne.class.php");
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/paiement.class.php");
require_once("../../Models/Admin/caisse.class.php");
require_once("../../Models/Admin/store.class.php");
require_once("../../Models/Admin/transaction.class.php");
$customers = new Customer();
$personnes = new Personne();
$users = new User();
$paiements = new Paiement();
$caisse = new Caisse();
$store = new POS();
$transactions = new Transactions();

$agent = $_GET['id'];

$st = $store->getStoreId($_SESSION['pos']);
$stores = $store->getBranchePOS($st->branche_id);
$caisses = $caisse->getCaisseBranche($st->branche_id);
$bq = $caisses->caisse_id;
?>

<div class="card" style="margin:25px; margin-bottom:50px;">

  <div class="card-header bg-light">
    <h3>Les clients redevables</h3>
  </div>
  <div class="card-wrapper">
    <div class="card-body">
      <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-sm table-striped display">
          <thead>
            <tr>
              <th>Nom Complet(Raison Sociale)</th>
              <th>Credit En cours</th>
              <th>Depassement de Limit</th>
              <th>Retard</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $datas = $transactions->select_all_dette_by_agent($st->branche_id, $agent);
            $solde_ant = 0;
            $solde_p = 0;
            foreach ($datas as $un) {
              $cust = $customers->select($un->customer_id);
              $staff = $users->getStaffId($un->staff_id);
            ?>
              <tr>
                <td><a href="javascript:void(0)" class="choose_cust2" id="<?= $cust->personne_id ?>"><?= $cust->customer_name ?></a></td>
                <td><?php echo '<b class="text-danger">' .  number_format($un->credit_total, 0, ',', ' ') . '</b>'; ?></td>
                <td><?php echo '<b class="text-success">' . $un->statut_credit . '</b>'; ?></td>
                <td><?php echo '<b class="text-success">' . $un->statut_paiement . '</b>'; ?></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/data-tables.js"></script>