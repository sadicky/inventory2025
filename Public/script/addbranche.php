<?php
require_once('../../Models/Admin/branches.class.php');
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/personne.class.php");
$personnes = new Personne();
$branches = new Branches();
$users = new User();

$branche = htmlspecialchars(trim($_POST['branche']));
$adresse = htmlspecialchars(trim($_POST['adresse']));


$pwd=password_hash('123456',PASSWORD_DEFAULT);
$string = "0123456789";
$string = str_shuffle($string);
$username = substr($string, 0, 6);
$role = '5';
$last = $personnes->insert('branche',$branche,'','','-',$adresse);

// var_dump($_POST);die();
$add = $branches->setBranches($branche, $adresse);
$users->setUser($branche,'','',$username,$pwd,$role,$last); 
if ($add) {
    echo '<div class="alert alert-success alert-outline" role="alert">
               <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Enregistrement reussi avec succes.
              </div>';
} else {
    echo "<span class='alert alert-pro alert-dismissible alert-danger fw-bold col-sm-12'>erreur d'insertion </span>";
}


//
