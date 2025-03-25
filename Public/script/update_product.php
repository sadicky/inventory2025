<?php
session_start();
require_once('../../Models/Admin/product.class.php');
$products = new Product();

$produit = isset($_POST['produit']) ? $_POST['produit'] : "";
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : "";
$details = isset($_POST['details']) ? $_POST['details'] : "";
$cond = isset($_POST['cond']) ? $_POST['cond'] : "";
$price = isset($_POST['pv']) ? $_POST['pv'] : "";
$qt_min = isset($_POST['qt_min']) ? $_POST['qt_min'] : "";
$category = isset($_POST['category']) ? $_POST['category'] : "";

$add = $products->updateProduct($category, $details, $price, $produit, $cond, $qt_min, $product_id);

if ($add) {
    echo '<div class="alert alert-success alert-outline" role="alert">
    <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Enregistrement reussi avec succes.
   </div>';
} else {
    echo "<span class='alert alert-danger alert-lg col-sm-12'>erreur d'insertion <button type='button' class='close' data-dismiss='alert'>x</button></span>";
}
