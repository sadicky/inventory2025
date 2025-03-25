<?php
@session_start();
require_once("../../Models/Admin/caisse.class.php");
require_once("../../Models/Admin/transaction.class.php");
require_once("../../Models/Admin/journal.class.php");
require_once("../../Models/Admin/personne.class.php");
$caisses = new Caisse();
$transactions = new Transactions();
$jour = new Journal();
$personnes = new Personne();

$jourId = 0;


if (isset($_POST["operation"])) {

  $posId = $_SESSION['pos'];

  $jourId = '';
  $trans_date = $_POST['trans_date'];

  if (isset($_SESSION['jour'])) {
    $jourId = $_SESSION['jour'];
  }

  if ($_POST["operation"] == "Add") {
    $amount = (int)str_replace(',', '', $_POST['mont_trans']);
    $personne_id = $_SESSION['id'];
    $created_at = $_POST['trans_date'];
    $caisse_id = $_POST['id_bq'];
    $customer_id = $_POST['cust_id'];

    $add = $transactions->setAvanceDette($customer_id, $caisse_id, $personne_id, $amount, $created_at);
    if ($add)  echo ' Enregistrement reussi ';
    else echo 'Echec';
  } elseif ($_POST["operation"] == "Edit") {
    $transactions->setTransactionId($_POST['ad_id']);
    $transactions->setAmount($amount);
    $transactions->setCreateDate($created_at);
    $transactions->setModePaie($_POST['mode_paie']);
    $transactions->setCaisseId($_POST['id_bq']);

    $transactions->updateCurrentDette();
    echo ' Modification reussie ';
  }
} else {
  echo "operation existe pas";
}
