<?php
@session_start();
// require_once '../load_model.php';
// $det=new BeanDetailsOperation();
// $op=new BeanOperation();
// $pr=new BeanPrice();
// $price=new BeanPrice();
// $stock=new BeanStock();

require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/tarif.class.php');
$branches = new Operation();
$stocks = new Stock();
$stores = new detOperation();
$tarifs = new Tarif();
$products = new Product();

$pr = $tarifs->select_2($_POST['prod_id'],$_POST['tar_id']);
$output = array();
$output["price"] =$pr->price;
$output["percent"] =$pr->percent; 

$st=$stocks->select_min_exp($_POST['prod_id'],$_SESSION['pos']);
$output["lot"] =$st['lot'];

echo json_encode($output);
?>
