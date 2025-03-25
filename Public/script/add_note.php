<?php
session_start();
require_once('../../Models/Admin/branches.class.php');
$branches = new Branches();

$type = htmlspecialchars(trim($_POST['type']));
$descr = htmlspecialchars(trim($_POST['descr']));
$user_id = $_SESSION['id'];
// var_dump($exist);die();
    $add = $branches->setNotes($type,$descr,$user_id);
    if ($add) {
        echo "Note enregistré avec succes";
    } else {
        echo "Erreur d'insertion";
    }



//
