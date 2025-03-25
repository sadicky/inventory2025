<?php
session_start();
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/sortie.class.php');

$operations = new Operation();
$details = new detOperation();
$sorties = new Sortie();
$products = new Product();
$stocks = new Stock();

$op = $operations->getOperationId($_SESSION['op_sort_id']);
$sort = $sorties->select($_SESSION['op_sort_id']);
$m_sort=0;

$det = $details->getDetail($_POST["det_id"]);

$posId=$op->pos_id;
$prodId=$det->product_id;
$lot=$det->lot;
$prod = $products->getProductId($prodId);
if(isset($_POST["det_id"]))
{

  if($prod->is_lot==1) 
    {
      $st = $stocks->select_by_lot($prodId,$lot,$posId);
    }
  else 
    {
      $st = $stock->select_by_prod($prodId,$posId);
    }
  $qt=$st->quantity + $det->quantity;
  $m_sort=$det->quantity*$det->amount;

  if($details->delete($_POST["det_id"]))
  {
    $stocks->update_qt($st->stock_id,$qt);    
    echo 'Détail sort annulé';

  $m_sort = $sort->amount - $m_sort;
  $sorties->update_2($_SESSION['op_sort_id'],$m_sort);
  }
  else
  {
    echo 'Echec opération ';
  }
}
else
{
  echo " pas Id";
}

?>
