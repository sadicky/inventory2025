<?php
@session_start();
require_once '../../Models/Admin/personne.class.php';
$perso= new Personne();

$keyword=$_POST['search'];

$list=$perso->select_all_role_srch('cash',$keyword);
//$i=1;
foreach ($list as $row) {
	$response[] = array("value"=>$row['personne_id'],"label"=>$row['nom_complet']);
}
echo json_encode($response);
?>
