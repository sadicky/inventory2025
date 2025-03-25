<?php
session_start();
require_once('../../Models/Admin/product.class.php');
$products = new Product();
$product = $_POST['product'];
$nb=$products->productNameExist($product);
echo ($nb);
?>