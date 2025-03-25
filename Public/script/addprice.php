<?php
session_start();
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/branches.class.php');
$branches = new Branches();
$products = new Product();
$count = $branches->getBranches();

$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : "";
$branche = isset($_POST['branche']) ? $_POST['branche'] : "";
$price = isset($_POST['price']) ? $_POST['price'] : "";
$date = date("Y-m-d");
// $price_id = isset($_POST['price_id']) ? $_POST['price_id'] : "";
$N = count($count);
if($branche=='all'){
            for ($i = 1; $i <= $N; $i++) {
            $add = $products->newPrice($price,$date,$i,$product_id);
        }
    }else{
    $add = $products->newPrice($price,$date,$branche,$product_id);
    }
if ($add) {
    echo '<div class="alert alert-success alert-outline" role="alert">
    <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Enregistrement reussi avec succes.
   </div>';
} else {
    echo "<span class='alert alert-danger alert-lg col-sm-12'>erreur d'insertion <button type='button' class='close' data-dismiss='alert'>x</button></span>";
}