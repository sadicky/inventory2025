<?php
include "../../Models/Admin/connexion.php";
include "../../Models/Admin/personne.class.php";
include "../../Models/Admin/user.class.php";
$user = new User();
$personne = new Personne();
$db = getConnection();

if (empty($_POST['id'])) {
    echo "Erreur d'identification ";
} else {
    $id = htmlspecialchars(trim($_POST['id']));
    $nom_ut = htmlspecialchars(trim($_POST['nom_ut']));
    $pseudo_ut = htmlspecialchars(trim($_POST['pseudo_ut']));
    $p = $user->select_1($id);
    /*-------------------------------------------*/
    $sql = $db->prepare("UPDATE tbl_users SET noms=?,username=? WHERE user_id=?");
    $data = $sql->execute(array($nom_ut, $pseudo_ut, $id));


    $sql1 = $db->prepare("UPDATE tbl_personnes SET nom_complet=? WHERE personne_id=?");
    $data1 = $sql1->execute(array($nom_ut, $p->personne_id));
    if ($data) {
        echo "Succes";
        echo "<script>window.location.href='index.php?p=login'</script>";
    } else {
        echo "Erreur d'identification ";
    }
}
