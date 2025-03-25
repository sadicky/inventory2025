<?php
session_start();
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/personne.class.php');

$operations = new Operation();
$transactions = new Transactions();
$personnes = new Personne();
$ventes = new Vente();

$trans = $transactions->select($_POST["trans_id"]);

$operations->update_one($trans->op_id,'op_id','is_paid','0');
$operations->update_one($trans->op_id,'op_id','is_send','0');
$ventes->delete($trans->op_id);
$transactions->delete($_POST["trans_id"]);
//echo $msg;
?>
