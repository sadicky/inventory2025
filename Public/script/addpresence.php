<?php

session_start();
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/presence.class.php');
$personnes = new Personne();
$pres = new Presence();
$users = new User();

if (isset($_POST['operation'])) {
    if ($_POST['operation'] == "Add") {

        $data =  $_POST['presences'];
        $date =  $_POST['date_presence'];
        // $justify =  $_POST['justify'];


        $presences = [];
        foreach ($data as $staffId => $presenceData) {
            $pres->insert($staffId, $date, $presenceData['presence'], $presenceData['motif']);
        }
        echo 'Enregistrer avec succes';
        // var_dump($presences);
        // $pres->insert($staff_id,$date_presence,$presence,$motif,$justify);
    } else if ($_POST["operation"] == "Edit") {


        $data =  $_POST['presences'];
        $date =  $_POST['date_presence'];
        $id =  $_POST['presence_id'];


        $presences = [];
        foreach ($data as $staffId => $presenceData) {

            $pres->updatePresence($staffId, $date, $presenceData['presence'], $presenceData['motif'], $presenceData['justify'], $id);
            echo 'Modification avec succes';
        }
    } else {

        echo "operation existe pas";
    }
}
