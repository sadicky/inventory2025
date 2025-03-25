<?php
session_start();
require_once('../../Models/Admin/product.class.php');
$products = new Product();

$produit = isset($_POST['produit']) ? $_POST['produit'] : "";
$details = isset($_POST['details']) ? $_POST['details'] : "";
$cond = isset($_POST['cond']) ? $_POST['cond'] : "";
$pa = isset($_POST['pa']) ? $_POST['pa'] : "";
$price = isset($_POST['pv']) ? $_POST['pv'] : "";
$category = isset($_POST['category']) ? $_POST['category'] : "";

$add = $products->setProduct($category, $details, $price, $pa, $produit, $cond, 30);

if ($add) {
    echo '<div class="alert alert-success alert-outline" role="alert">
    <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Enregistrement reussi avec succes.
   </div>';
} else {
    echo "<span class='alert alert-danger alert-lg col-sm-12'>erreur d'insertion <button type='button' class='close' data-dismiss='alert'>x</button></span>";
}
