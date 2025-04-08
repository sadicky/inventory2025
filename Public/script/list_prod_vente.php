<?php
session_start();
require_once('../../Models/Admin/product.class.php');
$products = new Product();

$keyword = $_POST['search'];
$response = [];

$datas = $products->select_all_crt_tar_($keyword, $_SESSION['pos']);
// print_r($datas);

foreach ($datas as $row) {
        $response[] = array(
                "value" => $row->product_id,
                "qty"    => $row->quantity,
                "label" => $row->category_name . ' - ' . $row->details
        );
}

echo json_encode($response);
