<?php
@session_start();

require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/livraison.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/stock.class.php');

$operations = new Operation();
$ventes = new Vente(); 
$details =new DetOperation();
$livraisons =new Livraison();
$stocks = new Stock();
$products = new Product();



$op = $operations->getOperationId($_SESSION['op_chg_id']);
$opTo = $operations->getOperationId($op->party_code);

$det = $details->getDetail($_POST['det_id']);

$posId=$op->pos_id;
$prodId=$det->product_id;
$lot=$det->lot;

$detTo =$details->getDetail($det->det);
$prodIdTo=$detTo->product_id;
$posIdTo=$opTo->pos_id;
$prod = $products->getProductId($prodId);

if(isset($_POST["det_id"]))
{
  // if($prod->is_lot==1) 
  //   {
  //     $st = $stocks->select_by_lot($prodId,$lot,$posId);
  //     $stockTo = $stocks->select_by_lot($prodIdTo,$lot,$posIdTo);
  //   }
  // else 
  //   {
  //     $st = $stock->select_by_prod($prodId,$posId);
  //     $stockTo = $stocks->select_by_prod($prodIdTo,$posIdTo);
  //   }

    $st = $stocks->select_by_prod($prodId,$posId);
    $stockTo = $stocks->select_by_prod($prodIdTo,$posIdTo);
  
  $qt=$st->quantity + $det->quantity;
  $qtTo=$stockTo->quantity - $detTo->quantity;

  if($details->delete($_POST['det_id']) and $details->delete($det->det))
  {
    $stocks->update_qt($st->stock_id,$qt); 
    $stocks->update_qt($stockTo->stock_id,$qtTo);  

    echo 'Détail sort annulé ';
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
