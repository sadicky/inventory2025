<?php
session_start();
require_once('../../Models/Admin/user.class.php');
$supplier = new User();

$keyword = $_POST['search'];
$response = [];
$list = $supplier->searchAgent($keyword);
// var_dump($list);
// die();
foreach ($list as $row) {
        $response[] = array(
                "value" => $row->user_id,
                "label" => $row->noms
        );
}

echo json_encode($response);
