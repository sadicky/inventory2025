<?php
@session_start();
require_once '../load_model.php';
$det = new BeanDetailsOperation();
$stock = new BeanStock();
$prod = new BeanProducts();
$acc=new BeanAccounts();
$op=new BeanOperation();
$an=new BeanAnnulation();


$op->select($_SESSION['op_vente_id']);
$vente=new BeanVente();
$vente->select($_SESSION['op_vente_id']);
$det->select($_POST["det_id"]);
$prod->select($det->getProdId());

$m_vente=0;


if(isset($_POST["det_id"]))
{

 if($det->delete($_POST["det_id"]))
 {
  
 	  $stock->select($det->getProdId(),$_SESSION['pos']);
    $qt=$stock->getQuantity() + $det->getQuantity();
    $m_vente=$det->getAmount()*$det->getQuantity();

  
  $m_vente = $vente->getAmount() - $m_vente;
  $vente->setAmount($m_vente);
  $vente->update($_SESSION['op_vente_id']);

  $stock->update_qt($stock->getStockId(),$qt);  
  echo 'Détail Vente annulé';

  $an->setProdId($det->getProdId());
  $an->setOpId('Vente');
  $an->setQuantity($det->getQuantity());
  $an->setAmount($det->getAmount());
  $an->setDet($_SESSION['perso_id']);
  $an->setTab($vente->getNumVente());

  $an->insert();
  //if($det->nb_op($det->getOpId())==0) { $op->delete($det->getOpId());}
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
