<?php
require_once('../../Models/Admin/user.class.php');
$users = new User();

$staff = htmlspecialchars(trim($_POST['staff']));
$sal = htmlspecialchars(trim($_POST['sal']));
$devise = htmlspecialchars(trim($_POST['devise']));

$exist = $users->SalaireExist($staff); 
// var_dump($exist);die();
if(@$exist->staff!=$staff){
    $add = $users->setStaffSalaire($staff,$devise,$sal);
    if ($add) {
        echo "Salaire enregistré avec succes";
    } else {
        echo "Erreur d'insertion";
    }
} else {
    echo "Verifie bien, le Salaire pour cette employé Existe déjà";
}


//
