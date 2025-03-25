<?php
session_start();
require_once('../../Models/Admin/devise.class.php');
$devises = new Devise();
// $count = $devises->getDevises();

$output = array();
if (isset($_POST["operation"])) {
    if ($_POST["operation"] == "Add") {

        $devise = isset($_POST['devise']) ? $_POST['devise'] : "";
        $short = isset($_POST['short']) ? $_POST['short'] : "";
        $taux = isset($_POST['taux']) ? $_POST['taux'] : "";

        $devises->setDevise($devise, $short, $taux);
        
        $output["msg"] = 'Enregistrement reussi avec succès';
    } 
    else if ($_POST["operation"] == "Edit") {
        $devise_id = isset($_POST['devise_id']) ? $_POST['devise_id'] : "";

        $devise = isset($_POST['devise']) ? $_POST['devise'] : "";
        $short = isset($_POST['short']) ? $_POST['short'] : "";
        $taux = isset($_POST['taux']) ? $_POST['taux'] : "";

        $devises->updateDevise($devise, $short, $taux,$devise_id);

        $output["msg"] = 'Modification reussie avec succès';
        unset($_GET['id']);
        $output["id"] =$devise_id;
    }
}
else
{
echo "operation existe pas";
}
echo json_encode($output);
