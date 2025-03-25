<?php
require_once('../../Models/Admin/supplier.class.php');
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/personne.class.php");
$personnes = new Personne();
$users = new User();
$suppliers = new Supplier();
 
$supplier_name = htmlspecialchars(trim($_POST['nom']));
$sup_contact = htmlspecialchars(trim($_POST['tel']));
$sup_adresse = htmlspecialchars(trim($_POST['adresse']));
$sup_nif = htmlspecialchars(trim($_POST['nif']));
$statut = 1;

$pwd=password_hash('123456',PASSWORD_DEFAULT);
$string = "0123456789";
$string = str_shuffle($string);
$usename = substr($string, 0, 6);

$role ='7';

$last = $personnes->insert('fournisseur',$supplier_name,$sup_contact,'','-',$sup_adresse);
// var_dump($_POST);die();
$add = $suppliers->setSupplier($supplier_name,$sup_adresse,$sup_nif,$sup_contact,$last); 
$users->setUser($supplier_name,$sup_contact,'',$usename,$pwd,$role,$last); 
if ($add) {
    echo '<div class="alert alert-success alert-outline" role="alert">
               <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Enregistrement reussi avec succes.
              </div>';
                echo "<script>window.location.href='index.php?p=fournisseurs'</script>";  
} else {
    echo "<span class='alert alert-pro alert-dismissible alert-danger fw-bold col-sm-12'>erreur d'insertion </span>";
}


//
