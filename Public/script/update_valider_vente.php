<?php
@session_start();
require_once("../../Models/Admin/operation.class.php");
require_once("../../Models/Admin/vente.class.php");
require_once("../../Models/Admin/transaction.class.php");
$op = new Operation();
$vente = new Vente();
$trans = new Transactions();
$operations = $op->getOperationId($_POST['op_id']);
$ventes = $vente->select($_POST['op_id']);
$Id = $ventes->idvente;
$payer = $ventes->amount;
$date = $operations->create_date;
// var_dump($operations->is_paid);
// die();
if ($operations->state == 0) {
    $op->update_state($_POST["op_id"], 1, 1);
    $trans->update_state($_POST["op_id"], 1);
    if ($operations->is_paid == 1) {
        $vente->update_valider($Id, $payer, 1, 1);
        $trans->update_status($_POST["op_id"], "IN", "CAISSE", "Vente des produits", $date);
    } else if ($operations->is_paid == 0) {
        $vente->update_valider($Id, 0, 0, 1);
        $trans->update_status($_POST["op_id"], "OUT", "DETTE", "Dette", $date);
    } else {
        $vente->update_valider($Id, 0, 0, 1);
        $trans->update_status($_POST["op_id"], "NO", "PROFORMAT", "Proformat", $date);
    }
    $msg = '<div class="alert alert-success" role="alert">
               <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Validation avec success!.
              </div>';
}
echo $msg;
