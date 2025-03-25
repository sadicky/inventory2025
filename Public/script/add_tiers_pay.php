<?php
@session_start();
require_once("../../Models/Admin/operation.class.php");
require_once("../../Models/Admin/vente.class.php");
require_once("../../Models/Admin/transaction.class.php");

$operations = new Operation();
$vente = new Vente();
$transactions = new Transactions();

$payer = $_POST['dette'];

$d = $transactions->getDetteId($_POST['op_id']);

$total = $d->total;
$op = $d->op_id;
$m_paye = $d->paid + $payer;
$reste = $total - $m_paye;
$id = $d->credits_id;

// var_dump($id);
// die();

if ($m_paye > $total) {
    $msg = "le montant " . number_format($payer, 0, ',', ' ') . " est superieur à la dette (" . number_format($d->total - $d->paid, 0, ',', ' ') . ") pour cette facture";
    // return 0;
} else {
    $transactions->updateDette($m_paye, $id);
    $date = date('Y-m-d');
    if ($reste == 0) {
        $operations->update_is_paid($op, 1, '');
        $transactions->update_status($op, "IN", "CAISSE", "Paiement Dette", $date);
        $transactions->update_dette_status($id);
    }

    $msg = 'Validation avec success';
}

// echo $msg;
echo json_encode(["id" => $id]);
