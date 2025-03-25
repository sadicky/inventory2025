<?php
@session_start();

require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/tarif.class.php');

$products = new Product();
$details = new detOperation();
$operations = new Operation();
$stores = new POS();
$pr = new Tarif();

$posId = $_SESSION['pos'];
$pos_id = $stores->getPOS($posId);

$products = $products->getProductId($_POST["prod_id"]);
$price = $pr->select_2($_POST["prod_id"], $pos_id->branche_id);
$output = array();

$last = $details->select_last_id('Approvisionnement', $_POST["prod_id"]);
$det_id = $last->last_id;
$getDetId = $details->getDetail($det_id);
//   var_dump($getDetId);

if (empty($getDetId->amount)) {
    $last = $details->select_last_id('Inventaire', $_POST["prod_id"]);
    $det_id = $last->last_id;
    $getDetId = $details->getDetail($det_id);
    //   var_dump($getDetId);
}

$output["price"] = @$price->price;

echo json_encode($output);
