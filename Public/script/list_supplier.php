<?php
session_start();
require_once('../../Models/Admin/supplier.class.php');
$supplier = new Supplier();

$keyword=$_POST['search'];
$response = [];
$list=$supplier->searchSupplier($keyword);
// var_dump($list);die();
foreach ($list as $row) {
$response[] = array(
        "value"=>$row->supplier_id,
        "label"=>$row->supplier_name);
}

echo json_encode($response);
?>
