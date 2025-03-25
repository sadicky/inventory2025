<?php
@session_start();
require_once '../../Models/Admin/vente.class.php';
$ventes= new Vente();
$keyword=$_POST['search'];
$list=$ventes->select_all_srch_bill($keyword);
foreach ($list as $row) {
	$response[] = array("value"=>$row['op_id'],"label"=>$row['idvente']);
}
echo json_encode($response);
?>
