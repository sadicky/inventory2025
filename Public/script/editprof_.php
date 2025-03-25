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
    // var_dump($_POST);
    // die();
    $pwd = $_POST['mp_ut'];
    $pwdH = password_hash($pwd, PASSWORD_DEFAULT);

    $sql = "UPDATE tbl_users SET password=? WHERE user_id= ? ";
    $stmt = $db->prepare($sql);
    $add = $stmt->execute([$pwdH, $id]);
    if ($add) {
        echo "<script>window.location.href='index.php?p=login'</script>";
    } else {
        echo '<br><span class="alert alert-danger">Erreur de modification</span>';
    }
}
