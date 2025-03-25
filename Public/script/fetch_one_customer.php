<?php
 session_start();
 require_once("../../Models/Admin/customer.class.php");
 require_once("../../Models/Admin/account.class.php");
//  require_once("../../Models/Admin/operation.class.php");

 $customers = new Customer();
 $personnes = new Personne();
//  $operations = new Operation();

$cust = $customers->select($_POST['pers_id']);
$pers = $personnes->select($_POST['pers_id']);


$output = array();

  $output["nom"] = $pers->nom_complet;
  $output["tel"] = $pers->contact;
  $output["email"] = $pers->email;
  $output["adresse"] = $pers->adresse;
  $output["cust_code"] = $cust->customer_code;
  $output["cust_num"] = $cust->customer_num;
  $output["cust_cat"] = $cust->customer_cat;
  $output["cust_type"] = $cust->customer_type;
  $output["cust_percent"] = $cust->customer_percent;
  $output["cust_exp"] = $cust->customer_exp;
  $output["cust_tva"] = $cust->customer_tva;
  $output["personne_id"] = $_POST['pers_id'];
  //$output['op_id'] = $_POST["op_id"];

$_SESSION['cust_id']=$_POST['pers_id'];
echo json_encode($output);


?>
