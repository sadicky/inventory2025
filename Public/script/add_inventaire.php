<?php
@session_start();

require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/livraison.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/sortie.class.php');

$operations = new Operation();
$details =new DetOperation();
$ventes = new Vente();
$livraisons =new Livraison();
$stocks = new Stock();
$products = new Product();
$stores = new POS();
$prices = new Tarif();
$pers=new User();
$jour=new Journal();
$sorties=new Sortie();

$jourId=$_SESSION['jour'];
// var_dump($_SESSION['periode']==$_POST['id_per']);die();
if($_SESSION['periode']==$_POST['id_per'])
{
  // var_dump($_POST['pos_id']);die();
  $crt_op=$operations->select_one_per($_POST['id_per'],$_POST['pos_id']);
  $_SESSION['op_inv_id']=$operations->select_last('Inventaire',$_POST['id_per'],$_POST['pos_id']);

  if($crt_op==1)
  {
    $op_type = 7;
    $party_type = 1;
    $jour_id =$_SESSION['jour'];
    $party_code = 0;
    $state = 1;
    $is_paid = 0;
    $user_id = $_SESSION['id'];
    $op_createDate = date('Y-m-d');

    $_SESSION['op_inv_id'] = $operations->setOperation($user_id,$op_type, $jour_id, $party_code, $state, $is_paid, '', $party_type, $_POST['pos_id'],1);

  }

}

?>