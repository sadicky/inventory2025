<?php
@session_start();
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/product.class.php');
      
$products = new Product();     
$details = new detOperation(); 

$det =$details->getDetail($_GET['det_id']);
$prod = $products->getProductId($det->product_id);
$datas = $products->select_all_crt_tar_0($det->product_id, $_SESSION['pos']);
$output = array();

  $output["price"] =$det->amount;
  $output["prod_id"] =$det->product_id; 
  $output["qt"] =$det->quantity; 
  $output["qty"] =$datas->quantity; 
  $output["prod_name"] =$prod->product_name; 
  $output["m_exp"] =date('m',strtotime($det->date_exp)); 
  $output["y_exp"] =date('y',strtotime($det->date_exp));
  $output["m_fab"] =date('m',strtotime($det->date_fab));
  $output["y_fab"] =date('y',strtotime($det->date_fab));
  $output["date_exp"] =date('m/y',strtotime($det->date_exp));

  echo json_encode($output);
?>
 