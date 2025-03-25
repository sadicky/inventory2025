<?php
session_start();
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');

$caisses = new Caisse();
$branches = new Branches(); 
$operations = new Operation();
$details = new detOperation();
$achats = new Achat();
$stores = new POS();
$products = new Product();
$stocks = new Stock();
$transactions = new Transactions();
$tarifs = new Tarif();

$op = $operations->getOperationId($_SESSION['op_appro_id']);
$ac = $achats->getAchat($_SESSION['op_appro_id']);
$m_achat=0;

$det = $details->getDetail($_POST["det_id"]);

$posId=$op->pos_id;
$prodId=$det->product_id;
$lot=$det->lot;
$prod = $products->getProductId($prodId);
if(isset($_POST["det_id"]))
{

  $st = $stocks->select_by_prod($prodId,$posId);
      
  $qt=$st->quantity - $det->quantity;
  var_dump($st->quantity);
  $m_achat=$det->quantity * $det->amount;

  // if($qt<0)
  // {
  //   echo 'Tu as besoin de ce produit, la quantité est insuffisante en stock !';
  // }
  if($details->delete($_POST["det_id"]))
  {
    $stocks->update_qt($st->stock_id,$qt);    
    echo 'Détail appro annulé';


  $m_achat = $ac->amount - $m_achat;
  $achats->update($m_achat,$_SESSION['op_appro_id']);
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
