<?php
require_once('../../Models/Admin/vente.class.php');
$ventes = new Vente();

$paid = htmlspecialchars(trim($_POST['paid']));
$reste = htmlspecialchars(trim($_POST['due']));
$montant = htmlspecialchars(trim($_POST['montant']));
$total = htmlspecialchars(trim($_POST['total']));
$id = htmlspecialchars(trim($_POST['id']));

if ($montant <= $reste) {
    $balance = intval($montant) + intval($paid);
    $reste = $total - $balance  ; 
    $add = $ventes->insert($reste, $balance, $id);
    
    if ($add) {
        echo "<span class='alert alert-pro alert-success alert-dismissible fw-bold col-sm-12'>
                    Paiement de la Dette effectué avec succes.</span><br/>";
    } else {
        echo "<span class='alert alert-pro alert-dismissible alert-danger fw-bold col-sm-12'>erreur d'insertion </span>";
    }
}else{
    echo "<span class='alert alert-pro alert-dismissible alert-danger fw-bold col-sm-12'>Erreur! Le montant est supérieur à la dette restante pour cette facture </span>";
}



//
