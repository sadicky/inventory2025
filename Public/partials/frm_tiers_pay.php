<?php session_start();
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/product.class.php');
require_once("../../Models/Admin/paiement.class.php");
require_once("../../Models/Admin/caisse.class.php");
require_once('../../Models/Admin/detOperation.class.php');
require_once("../../Models/Admin/customer.class.php");
require_once("../../Models/Admin/transaction.class.php");
require_once('../../Models/Admin/vente.class.php');
$vente = new Vente();
$products = new Product();
$operations = new Operation();
$users = new User();
$caisse = new Caisse();
$transactions = new Transactions();
$det = new DetOperation();
$paie = new Paiement();
$customers = new Customer();

if (isset($_SESSION['trans_id'])) {
    $get = $transactions->select($_SESSION['trans_id']);
}

$cust = $customers->select($_GET['pos_id']);
// $datas = $vente->select_dette('Vente', $cust->personne_id);
$datas = $transactions->getDettesCustommer($cust->personne_id);
// var_dump($datas);
?>

<hr>
<div class="card">
    <div class="card-header text-center">
        <strong>Paiement des Factures</strong>
    </div>

    <div class="card-body card-block">
        <div class="row">
            <div class="col-md-7">
                <table id="data-table" class="table tab">
                    <thead>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Reste</th>
                        <th>Payer</th>
                    </thead>
                    <tbody>
                        <?php foreach ($datas as $ventes):
                            // $v = $vente->select($ventes->op_id);
                        ?>
                            <tr>
                                <td><?= $ventes->updated_at ?></td>
                                <td><?= number_format($ventes->total, 0, ',', ' ') ?> </td>
                                <td><?= number_format($ventes->total - $ventes->paid, 0, ',', ' ') ?> </td>
                                <td> <a href="javascript:void(0)" data-id="<?= $ventes->credits_id ?>" class="btn btn-danger btn-block btn-sm" id="paiements"> Paiement</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-5 payer p-2"> </div>
        </div>
    </div>
</div>