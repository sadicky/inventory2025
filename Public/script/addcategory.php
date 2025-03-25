<?php
require_once('../../Models/Admin/category.class.php');
$e = new Category();
// var_dump($_POST);die();
$category_name = htmlspecialchars(trim($_POST['category_name']));
$status = htmlspecialchars(trim($_POST['status']));
$category_parent = htmlspecialchars(trim($_POST['cat_parent']));
$is_sale = htmlspecialchars(trim($_POST['is_sale']));

$add = $e->setCategory($category_name,$category_parent,$is_sale,$status);
if ($add) {
    echo '<div class="alert alert-success alert-outline" role="alert">
    <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Enregistrement reussi avec succes.
   </div>';
} else {
    echo "<span class='alert alert-danger alert-lg col-sm-12'>erreur d'insertion <button type='button' class='close' data-dismiss='alert'>x</button></span>";
}
