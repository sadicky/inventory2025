<?php
@session_start();
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/transaction.class.php');
$op = new Operation();
$trans = new Transactions();

$trans->select_op($_POST['op_id']);
$trans->delete($trans->getTransactionId());

$op->update_one($_POST['op_id'],'op_id','is_paid','0');
$op->update_one($_POST['op_id'],'op_id','is_send','0');
?>
