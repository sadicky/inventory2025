<?php
@session_start();
require_once('../../Models/Admin/stock.class.php');
$stocks = new Stock();

$keyword=$_POST['search'];

$list=$stocks->select_all_lot($keyword);
$response = [];
foreach ($list as $row) {
	$response[] = array("label"=>$row['lot'],"m_exp"=>date('m',strtotime($row['date_exp'])),"y_exp"=>date('y',strtotime($row['date_exp'])));
}
echo json_encode($response);
?>
