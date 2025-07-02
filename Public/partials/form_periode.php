<?php
session_start();
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
$details = new detOperation();
$categories = new Category();
$stores = new POS();
$products = new Product();
$periodes = new Periode();


if(!empty($_GET['id']))
{
    $per = $periodes->getPeriode($_GET['id']);
}

?>

<div class="card"  style="margin: 20px;">
    <div class="card-header text-center">
        <strong>Inventaire</strong>
    </div>
    <div class="card-body card-block">
        <div class="row">
            <div class="col-md-12" style="margin-top:10px;">
                <?php include('../../Public/partials/form_inventaire.php'); ?>
                <hr style="color:blue;" />
                <div class="details_inv"></div>
            </div>
        </div>
    </div>
</div>


<div style="padding-top: 20px;"></div>