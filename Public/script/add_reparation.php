<?php
session_start();
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/transaction.class.php');
$caisse = new AutreFrais();
$operations = new Operation();
$caisses = new Caisse();
$stores = new POS();
$trans = new Transactions();

$tel = isset($_POST['tel']) ? $_POST['tel'] : "";
$date = isset($_POST['date']) ? $_POST['date'] : "";
$dateins = date("Y-m-d");
$client = isset($_POST['client']) ? $_POST['client'] : "";
$depot = isset($_POST['branche_id']) ? $_POST['branche_id'] : "";
$montant = isset($_POST['montant']) ? $_POST['montant'] : "";
$motif = isset($_POST['motif']) ? $_POST['motif'] : "";
$adresse = isset($_POST['adresse']) ? $_POST['adresse'] : "";
$statut = 0;
$idu = $_SESSION['id'];
$add = null;

$idPer = $_SESSION['periode'];
if (!isset($_SESSION['op_rep_id'])) {
	$posId = $_SESSION['pos'];
} else {
	$op = $operations->getOperationId($_SESSION['op_rep_id']);
	$posId = $op->pos_id;
}
$st = $stores->getStoreId($_SESSION['pos']);
$caissse = $caisses->getCaisseId($st->branche_id);

$bq = $caissse->caisse_id;


if (!isset($_SESSION['op_rep_id'])) {
	$op_type = 8;
	$periode_id = $idPer;
	$party_type = 2;
	$jour_id = $_SESSION['jour'];
	$party_code = 0;
	$state = 1;
	$is_paid = 1;
	$personne_id = $_SESSION['perso_id'];
	$sup_id = '';
	$pos_id  = $posId;
	$user_id = $_SESSION['id'];
	$op_createDate = date('Y-m-d');

	$_SESSION['op_vente_id'] = $operations->setOperation($user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $periode_id, $party_type, $pos_id, $bq);


	$transaction_type = '9';
	$descript = 'Réparation: ' . $motif;
	$pos_id = $_SESSION['pos'];
	$create_date = date('Y-m-d');
	$status = 'IN';
	$partyCode = 0;
	$staff_id = 0;
	$mode_paie = "REPA";

	$trans_id = $trans->insert($jour_id, $_SESSION['op_vente_id'], $transaction_type, $descript, $montant, $partyCode, $bq, $pos_id, $personne_id, $status, $create_date, $mode_paie, $staff_id);

	$add = $caisse->setCaisse($_SESSION['op_vente_id'], $client, $tel, $adresse, $motif, $montant, $date, $depot, 0, $idu);

	if (!empty($add)) {
		echo "<span class='alert alert-success alert-lg col-sm-12'>Ajout reussi avec Succes<button type='button' class='close' data-dismiss='alert'>x</button></span>";
	} else {
		echo "<span class='alert alert-danger alert-lg col-sm-12'>erreur d'insertion <button type='button' class='close' data-dismiss='alert'>x</button></span>";
	}
}
