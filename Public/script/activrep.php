<?php
require_once('../../Models/Admin/autresfrais.class.php');
require_once("../../Models/Admin/transaction.class.php");

$trans = new Transactions();
$cat = new AutreFrais();

$id = isset($_POST['id']) ? $_POST['id'] : '';


$operations = $cat->getReparationId($id);
$op_id = $operations->op_id;

$descript = 'Réparation: ' . $operations->$motif;

$date = date('Y-m-d');


if ($id) {
	$active = $cat->activRep($id);
	$trans->update_state($op_id, 1);
	$trans->update_status($op_id, "IN", "CAISSE", $descript, $date);
	if ($active) echo "avec succes";
	else echo "non ajoute";
}
