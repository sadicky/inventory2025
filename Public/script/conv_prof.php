<?php
@session_start();

require_once("../../Models/Admin/detOperation.class.php");
require_once("../../Models/Admin/operation.class.php");
require_once("../../Models/Admin/vente.class.php");
require_once("../../Models/Admin/stock.class.php");
require_once("../../Models/Admin/transaction.class.php");
require_once('../../Models/Admin/store.class.php');

$details = new detOperation();
$stocks = new Stock();
$op = new Operation();
$vente = new Vente();
$trans = new Transactions();
$store = new POS();

$op_id = $_GET['op_id'];
$is_paid = $_GET['type'];

$st = $store->getStoreId($_SESSION['pos']);

$operations = $op->getOperationId($op_id);
$det = $details->select_one_det_op($op_id);
$ventes = $vente->select($op_id);

$Id = $ventes->idvente;
$payer = $ventes->amount;

$posId = $operations->pos_id;
$staff_id = $operations->tar_id;
$partyCode = $operations->party_code;
$date = date('Y-m-d');

$op->update_is_paid($op_id, $is_paid, $date);

if ($is_paid == 1) {
    $descript = 'Vente des produits';
    $status = 'IN';
    $mode_paie = 'CAISSE';

    $vente->update_valider($Id, $payer, 1, 1);
} else {
    $descript = 'Dette';
    $status = 'OUT';
    $mode_paie = 'DETTE';

    $vente->update_valider($Id, 0, 0, 1);
    $trans->setDette($op_id, $partyCode, $st->branche_id,  $staff_id, $payer, 0);
}
// var_dump($mode_paie);
// die();

$add = $trans->update_is_paid($op_id, $descript, $status, $mode_paie, $date);

foreach ($det as $d) {
    $prodId = $d->product_id;
    $quantity = $d->quantity;

    $s = $stocks->select_by_prod($prodId, $posId);
    $exist = $stocks->existstock_by_prod($prodId, $posId);

    if (!$exist) {
        $last_stk = $stocks->insert($prodId, $quantity, $posId);
    } else {

        $st = $stocks->select_by_prod($prodId, $posId);
        $qt_stk = $st->quantity - $quantity;
        $last_stk = $stocks->update_qt($st->stock_id, $qt_stk);
    }
}
if ($add) {
    $msg = '<div style="padding:10px;" class="alert alert-success" role="alert">
                 <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Validation avec success!.
                </div>';
} else {
    $msg = '<div style="padding:10px;" class="alert alert-success" role="alert">
                 <i class="flaticon-tick-inside-circle"></i> <strong>Erreur!</strong>.
                </div>';
}

echo $msg;
