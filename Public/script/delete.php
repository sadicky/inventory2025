<?php
@session_start();
require_once('../../Models/Admin/operation.class.php');

$op = new Operation();

if(isset($_POST['op_id']))
{
  $o=$op->getOperationId($_POST['op_id']);

  if($o->op_type=='Transfert')
  {
  	$op->getOperationId($o->party_code);
  }

  $op->delete($_POST['op_id']);
  echo 'Suppression reussie avec succès ';
}
else
{
echo " pas Id ";
}

?>
