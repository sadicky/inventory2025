<?php
session_start();
require_once('../../Models/Admin/caisse.class.php');
$caisses = new Caisse();

$keyword=$_POST['search'];
$response = [];
$list=$caisses->searchAllCaisses($keyword);
// var_dump($list);die();
foreach ($list as $row) {
$response[] = array(
        "value"=>$row->caisse_id,
        "label"=>$row->caisse_name."(".$row->branche.")"
);
}

echo json_encode($response);
?>
