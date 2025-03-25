<?php

session_start();
require_once('../../Models/Admin/commande.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/detOperation.class.php');
$commandes = new Commande();
$products = new Product();
$jour = new Journal();
$achat = new Achat();
$op = new Operation();
$details = new detOperation();

$idPer=$_SESSION['periode']; 
$posId=$_SESSION['pos'];
$jour_id=$_SESSION['jour'];
// var_dump($posId);die();
if(!isset($_SESSION['op_cmd_id']))
{
  $op_type = 3;
  $party_type = 5;
  $party_code = 0;
  $pos_id = $posId;
  $periode_id = $idPer;
  $is_paid = 0;
  $state = 1;
  $user_id = $_SESSION['id'];
  $_SESSION['op_cmd_id'] = $op->setOperation($user_id,$op_type, $jour_id, $party_code, $state, $is_paid, $periode_id, $party_type, $pos_id,0);

 
  $amount = 0;
  $num_achat = $_POST['num_cmd'];
  $op_id = $_SESSION['op_cmd_id'];
  $is_paid = 0;
  $data = $achat->setAchat($amount,$op_id,$num_achat,$is_paid);
  
  // var_dump($_SESSION['op_cmd_id']);die();
}

$getProducts = $products->getProductId($_POST['prod_id']);

$qt=(float)str_replace(',', '', $_POST['qt']);
$prodId=$_POST['prod_id'];
 
$getAchats = $achat->getAchat($_SESSION['op_cmd_id']);
$m_achat=0;

if(isset($_POST["operation"]))
{

  if($_POST["operation"] == "Add")
  {
    $prod_id = $prodId;
    $op_id = $_SESSION['op_cmd_id'];
    $quantity = $qt;
    $amount = 0;
    $details->setDetailOperation($op_id, $prod_id, $quantity, $amount); 

    //  var_dump($data);die();

    echo ' Enregistrement reussi ';
  }
  if($_POST["operation"] == "Edit")
  {
    
    
    $op_id = $_SESSION['op_cmd_id'];
    $quantity = $qt;
    $amount = 0;

   $details->update($_POST["det_id"]);
   echo ' Modification reussie ';
  }
}
else
{
  echo "operation existe pas";
}

?>
