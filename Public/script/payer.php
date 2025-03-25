<?php

require_once('../../Models/Admin/caisse.class.php');
$caisse = new Caisse();
$id = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';
$salaire = isset($_POST['salaire']) ? $_POST['salaire'] : '';
$mois = isset($_POST['mois']) ? $_POST['mois'] : '';
$annee = isset($_POST['annee']) ? $_POST['annee'] : '';
$devise = isset($_POST['devise']) ? $_POST['devise'] : '';
$date = date('Y-m-d');

// print_r($exist->id);die();

$N = count($id);
for ($i = 0; $i < $N; $i++) {
	
// $exist = $caisse->PaiementExist($id,$annee,$mois); 
// 	print_r($exist->id);die();
	$add = $caisse->SetPaiement($id[$i],$salaire[$i],$devise[$i],$mois,$annee,$date);
	if ($add) {
		echo "<span class='alert alert-pro alert-success alert-dismissible fw-bold col-sm-12'>
			<strong style='color:green'>Enregistré!!</strong> avec succes.<br/>";
	} else {
		echo "<span class='alert alert-pro alert-dismissible alert-danger fw-bold col-sm-12'>erreur d'insertion </span>";
	}
}
