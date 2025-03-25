<?php
require_once("connexion.php");
require_once('commande.class.php');
require_once('supplier.class.php');
require_once('operation.class.php');
require_once('user.class.php');
require_once('product.class.php');
require_once('achat.class.php');
require_once('periode.class.php');
require_once('journal.class.php');
require_once('personne.class.php');
require_once('store.class.php');
require_once('devise.class.php');
$supplier = new Supplier();
$products = new Product();
$operations = new Operation();
$users = new User();
$achats = new Achat();
$commandes = new Commande();
$periodes = new Periode();
$journal = new Journal();
$pos = new POS();
$personnes = new Personne();
$tiers = new Devise();

$getDevise2 = $tiers->getDevises2();
$getDevise3 = $tiers->getDevises3();
$_SESSION['taux3'] = $getDevise3->taux;
$_SESSION['short3'] = $getDevise3->short;


$_SESSION['taux2'] = $getDevise2->taux;
$_SESSION['short2'] = $getDevise2->short;

$db = getConnection();
$msg = "";
$username = isset($_POST['username']) ? $_POST['username'] : "";
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : "";
if (isset($_POST['login'])) {
  $sql = $db->prepare("SELECT * FROM tbl_users WHERE username= :username");
  $sql->bindValue('username', $username);
  $sql->execute();
  $res = $sql->fetchObject();
  // var_dump($res);die();
  if ($res) {
    $pwdHash = $res->password;
    if (password_verify($pwd, $pwdHash)) {
      $_SESSION['id'] = $res->user_id;
      $_SESSION['username'] = $res->username;
      $_SESSION['noms'] = $res->noms;
      $_SESSION['email'] = $res->email;
      $_SESSION['tel'] = $res->tel;
      $_SESSION['role'] = $res->role_id;
      $_SESSION['logged'] = true;
      if ($res->role_id == 1 && $res->pos_id == 0) {
        $_SESSION['pos'] = 2;
      } else {
        $_SESSION['pos'] = $res->pos_id;
      }
      $isLogged = $_SESSION['logged'];

      $per = $periodes->select_crt('1');
      $_SESSION['periode'] = $per->periode_id;

      $user_id = $_SESSION['id'];
      $auth_user = $users->select_3($user_id);
      $personne = $personnes->select($auth_user->personne_id);

      $_SESSION['nom'] = $personne->nom_complet;
      $_SESSION['photo'] = $personne->photo;
      $_SESSION['perso_id'] = $personne->personne_id;

      if (!isset($_SESSION['pos'])) {
        $pos_user = $personnes->select($auth_user->pos_id);
        $_SESSION['pos'] = $pos_user->pos_id;
      } else {
        $pos_user = $personnes->select($_SESSION['pos']);
      }

      if (!isset($_SESSION['jour'])) {
        $jour = $journal->select_by_state($_SESSION['perso_id']);
        $_SESSION['jour'] = $jour->jour_id;
      } else {
        $jour = $journal->select($_SESSION['jour']);
      }

      if ($res->statut == 0) {
        $msg = '<br><div class="alert alert-danger" role="alert">
    <i class="flaticon-tick-inside-circle"></i> <strong>Desolé! </strong> Ce compte est suspendu</div>';
      } else {

        // var_dump($_SESSION['role']);die();
        if ($_SESSION['role'] == 1) header("location:" . WEBROOT . "dashboard");
        else if ($_SESSION['role'] == 2) header("location:" . WEBROOT . "dashboard");
        else if ($_SESSION['role'] == 3) header("location:" . WEBROOT . "market");
        else if ($_SESSION['role'] == 4) header("location:" . WEBROOT . "dashboard");
        else if ($_SESSION['role'] == 5) header("location:" . WEBROOT . "dashboard");
        else if ($_SESSION['role'] == 6) header("location:" . WEBROOT . "dashboard");
        else if ($_SESSION['role'] == 7) header("location:" . WEBROOT . "dashboard");
        else if ($_SESSION['role'] == 8) header("location:" . WEBROOT . "dashboard");
        // else if ($_SESSION['role'] == "station") header("location:" . WEBROOT . "dashboard");
        else header("location:" . WEBROOT . "login");
      }
    } else {
      $msg = '<br><div class="alert alert-danger" role="alert">
    <i class="flaticon-tick-inside-circle"></i> <strong>Desolé! </strong>Mot de passe incorrect .
   </div>';
    }
  } else {
    $msg = '<br><div class="alert alert-warning" role="alert">
    <i class="flaticon-tick-inside-circle"></i> <strong>Desolé! </strong>Username et Password incorrects.
   </div>';
  }
}
