<?php
@session_start();
require_once '../../Models/Admin/ben.class.php';
$ben= new Ben();

$keyword=$_POST['search'];
$cust_id=$_POST['cust_id'];
$list=$ben->select_all_srch($cust_id,$keyword);
foreach ($list as $row) {
	$response[] = array("value"=>$row['id_ben'],"label"=>$row['name']);
}
echo json_encode($response);
?>
