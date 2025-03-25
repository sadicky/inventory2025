<?php
session_start();
require_once('../../Models/Admin/personne.class.php');
require_once("../../Models/Admin/transaction.class.php");
$transactions = new Transactions();
$perso = new Personne();

$keyword = $_POST['search'];

$list = $perso->select_all_role_srch('client', $keyword);
// print_r($crt_cred);
foreach ($list as $row) {
	$response[] = array(
		"value" => $row['personne_id'],
		"label" => $row['nom_complet'],
		"details" => $details = $transactions->tot_sum_cred($row['personne_id']),
		"limited" => @$details->statut_credit,
		"retard" => @$details->statut_paiement
	);
}

echo json_encode($response);
