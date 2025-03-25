<?php
session_start();
require_once('../../Models/Admin/product.class.php');
$products = new Product();

$keyword = $_POST['search'];
$response = [];
$list = $products->searchAllDetails($keyword);
// $datas = $products->select_all_crt_tar($_POST['rech'], $_SESSION['pos']);
// var_dump($list);die();
foreach ($list as $row) {
        $response[] = array(
                "value" => $row->product_id,
                "label" => $row->details
        );
}

echo json_encode($response);
