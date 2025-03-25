<?php
session_start();
include "../../Models/Admin/connexion.php";
include "../../Models/Admin/caisse.class.php";
include "../../Models/Admin/store.class.php";
$caisses = new Caisse();
$stores = new POS();
$db = getConnection();
$pos = $_SESSION['pos'];
$pos_id = $stores->getPOS($pos);
$caisse = $caisses->getCaisseBranche($pos_id->branche_id);

if (isset($_POST['view_vente'])) {

	$sql1 = "SELECT * FROM tbl_operations WHERE op_type='Vente' and caisse_id=? and state='0'";
	$req1 = $db->prepare($sql1);
	$req1->execute([$caisse->caisse_id]);
	$count = $req1->rowCount();
	$data = array(
		'unseen' => $count
	);
	echo json_encode($data);
}
