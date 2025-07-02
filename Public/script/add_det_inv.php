<?php
session_start();
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/stock.class.php');
$details = new detOperation();
$stores = new POS();
$products = new Product();
$stocks = new Stock(); 
$operations = new Operation();

$op = $operations->getOperationId($_SESSION['op_inv_id']);
$prodId = $_POST['prod_id'];
$posId = $_SESSION['pos'];

$prod = $products->getProductId($prodId);

$qt = (int)str_replace(',', '',$_POST['qt']);

if (isset($_POST["operation"])) {
  if (!empty($_POST['det_id'])) {
    $det_an = $details->getDetail($_POST['det_id']);
  }

  $st = $stocks->select_by_prod($prodId, $posId);
  $exist = $stocks->existstock_by_prod($prodId, $posId);
  
  if ($_POST["operation"] == "Add") {

    $prod_id = $prodId;
    $op_id = $_SESSION['op_inv_id'];
    $quantity = $qt;
    $price = 0;

    $last_det = $details->setDetailOperation($op_id, $prod_id, $quantity, $price);

    if (!$exist) {
      $last_stk = $stocks->insert($prod_id, $quantity, $posId);
    } else {
      $qt_stk = $st->quantity + $qt;
      $sto = $stocks->update_qt($st->stock_id, $quantity);
    }

    echo ' Enregistrement reussi ';
  }
  if ($_POST["operation"] == "Edit") {
    // $det->setProdId($prodId);
    // $det->setQuantity($qt);
    // $det->setAmount($price);

    $qty_r = $qt - $det_an->quantity;
    $qt_stk = $st->quantity + $qty_r;

    if ($qt_stk < 0) {
      echo 'Quantité insuffisante en stock !';
    } elseif ($details->update($_POST["det_id"])) {
      $stock->update_qt($stock->getStockId(), $qt_stk);
      echo ' Modification reussie ';
    } else {
      echo 'Echec Modification';
    }
  }

  if (!empty($_POST['prod_id']) and !empty($price)) {
    // $datas=$tar->select_all();
    // foreach ($datas as $key => $value) {
    //   $cust->select($value['personne_id']);
    //   $pv=$price+($price*($cust->getCustomerMb()/100));
    //   if(!$tar->exist_tar_prod($value['tar_id'],$prodId))                                         
    //   { 
    //   $pr->setProdId($prodId);
    //   $pr->setTarId($value['tar_id']);
    //   $pr->setPrice($pv);
    //   $pr->setPercent('0');
    //   $pr->insert();
    //   }
    //   else
    //   {
    //   $pr->select_2($prodId,$value['tar_id']);
    //   if($pr->getIsFixed==0) $pr->update_one($pr->getPriceId(),'price_id','price',$pv);
    //   }
    // }
    //echo 'price modif';
  }
} else {
  echo "operation existe pas";
}
