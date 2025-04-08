<?php
session_start();
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/branches.class.php');
$caisses = new Caisse();
$branches = new Branches();
$count = $branches->getBranches();

$output = array();
if (isset($_POST["operation"])) {
    if ($_POST["operation"] == "Add") {

        $caisse = isset($_POST['libelle']) ? $_POST['libelle'] : "";
        $branche = isset($_POST['branche']) ? $_POST['branche'] : "";
        $status = 1;

        $N = count($count);
        if ($branche == 'all') {
            for ($i = 1; $i <= $N; $i++) {
                $caisses->setCaisse($caisse, $i, $status);
            }
        } else {
            $caisses->setCaisse($caisse, $branche, $status);
        }

        $output["msg"] = 'Enregistrement reussi avec succès';
    } else if ($_POST["operation"] == "Edit") {
        $caisse_id = isset($_POST['caisse_id']) ? $_POST['caisse_id'] : "";
        $caisse = isset($_POST['libelle']) ? $_POST['libelle'] : "";
        $status = isset($_POST['status']) ? $_POST['status'] : "";

        $caisses->updateCaisse($caisse, $status, $caisse_id);

        $output["msg"] = 'Modification reussie avec succès';
        unset($_GET['id']);
        $output["id"] = $caisse_id;
    }
} else {
    echo "operation existe pas";
}
echo json_encode($output);
