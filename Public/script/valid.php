<?php
session_start();
include "../../Models/Admin/connexion.php";
include "../../Models/Admin/caisse.class.php";
include "../../Models/Admin/store.class.php";

$db = getConnection();
$caisses = new Caisse();
$stores = new POS();

$pos = $_SESSION['pos'];
$pos_id = $stores->getPOS($pos);
$caisse = $caisses->getCaisseBranche($pos_id->branche_id);

// var_dump($caisse->caisse_id);
// die();

if (isset($_POST['view'])) {

	$sql1 = "SELECT * FROM tbl_operations WHERE op_type!='Vente' and caisse_id='$caisse->caisse_id' and state='0'";
	$req1 = $db->query($sql1);
	$req1->execute();
	$count = $req1->rowCount();
	$data = array(
		'unseen' => $count
	);
	echo json_encode($data);
}
