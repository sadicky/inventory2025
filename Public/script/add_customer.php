<?php
session_start();
require_once("../../Models/Admin/customer.class.php");
require_once("../../Models/Admin/personne.class.php");
$customers = new Customer();
$personnes = new Personne();
// var_dump($_POST);die();

$output = array();
if (isset($_POST['operation'])) {
  if ($_POST['operation'] == "Add") {
    $role = 'client';
    $nom = strip_tags($_POST['nom']);
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $cust_num = $_POST['cust_num'];
    $adresse = $_POST['adresse'];
    $credit_limit = $_POST['cred_limit'];
    $cust_cat = $_POST['cust_cat'];
    $status = $_POST['status'];
    $genre = '-';

    $last = $personnes->insert($role, $nom, $tel, $email, $genre, $adresse);

    $uid = $customers->setCustomer($nom, $cust_num, $adresse, $credit_limit, $cust_cat, $status, $last);
    $output["msg"] = 'Enregistrement reussi avec succès ';
  } else if ($_POST["operation"] == "Edit") {
    $role = 4;
    $nom = strip_tags($_POST['nom']);
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $cust_num = $_POST['cust_num'];
    $credit_limit = $_POST['cred_limit'];
    $cust_cat = $_POST['cust_cat'];
    $status = $_POST['status'];
    $genre = '-';
    $personne_id = $_POST['personne_id'];
    $personnes->update($role, $nom, $tel, $email, $genre, $adresse, $personne_id);

    $customers->update($nom, $cust_num, $adresse, $credit_limit, $cust_cat, $status, $personne_id);
    $output["msg"] = 'Modification reussie avec succès ';
    $output["id"] = $_POST['personne_id'];
  }
} else {
  $output["msg"] = "operation existe pas";
}
echo json_encode($output);
