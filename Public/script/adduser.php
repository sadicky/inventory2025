<?php

session_start();
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/personne.class.php');
$personnes = new Personne();
$users = new User();

if (isset($_POST['operation'])) {
    if ($_POST['operation'] == "Add") {
        $role ='3';
        $nom = $_POST['nom_ut'];
        $genre =$_POST['sexe_ut'];
        $tel =$_POST['tel_ut'];
        $email=$_POST['email_ut'];

        $last = $personnes->insert($role,$nom,$tel,$email,$genre,'');

      
            $username =$_POST['pseudo_ut'];
            $password =password_hash($_POST['mp_ut'], PASSWORD_DEFAULT);
            $personneId =$last;
            $role_id = $_POST['type_ut'];
            $pos_id=$_POST['pos_id'];
            $statut =true;

            $add = $users->insert($nom,$tel,$email,$username,$password,$role_id,$pos_id,$personneId); 
            if ($add) {
                echo 'Enregistrement reussi avec succès ';
            } else {
                echo 'xxxx';
            }
            
    } else if ($_POST["operation"] == "Edit") {

        $role ='3';
        $nom = $_POST['nom_ut'];
        $genre =$_POST['sexe_ut'];
        $tel =$_POST['tel_ut'];
        $email=$_POST['email_ut'];
        $personneId =$_POST['personne_id'];

        $personnes->update_one($_POST["personne_id"], 'personne_id', 'last_update', date('Y-m-d h:i:s'));

        echo 'Modification reussie avec succès';

        $users->update_one($_POST['personne_id'], 'personne_id', 'role_id', $_POST['type_ut']);
        $users->update_one($_POST['personne_id'], 'personne_id', 'pos_id', $_POST['pos_id']);
        $users->update_one($_POST['personne_id'], 'personne_id', 'username', $_POST['pseudo_ut']);
    } else if ($_POST["operation"] == "Edit_con") {

        $user = $users->select($_POST['personne_id']);
        $an_mp = $_POST['an_mp_ut'];
        $pwd = $user->password;

        if (password_verify($an_mp, $pwd)) {
            $users->update_one($_POST['personne_id'], 'personne_id', 'username', $_POST['pseudo_ut']);
            $users->update_one($_POST['personne_id'], 'personne_id', 'password', password_hash($_POST['mp_ut'], PASSWORD_DEFAULT));
            echo 'Modification reussie avec succès';
        } else {
            echo 'Modification Impossible, ancien mot de passe incorrect ';
        }
    }
} else {
    echo "operation existe pas";
}
