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

$amount = $_POST['mont_trans'];

if (isset($_POST["operation"])) {

  $posId = $_SESSION['pos'];
  $jourId = '';
  $trans_date = $_POST['trans_date'];

  if (isset($_SESSION['jour'])) {
    $jourId = $_SESSION['jour'];
  }

  if ($_POST["operation"] == "Add") {
    $OpId = 0;
    $amount = $_POST['mont_trans'];
    $transaction_type = '4';
    $personne_id = $_SESSION['id'];
    $party_code = '0';
    $descript = ($_POST['lib_dep'] . ': ' . $_POST['comment_trans']);
    $pos_id = $_SESSION['pos'];
    $status = 2;
    $create_date = $trans_date;
    $id_bq = $_POST['id_bq'];
    $mode_paie = 'CAISSE';

    $add = $transactions->insert(
      $jourId,
      $OpId,
      $transaction_type,
      $descript,
      $amount,
      $party_code,
      $id_bq,
      $pos_id,
      $personne_id,
      $status,
      $create_date,
      $mode_paie,
      0
    );
    if ($add)  echo ' Enregistrement reussi ';
    else echo 'Echec';
  } elseif ($_POST["operation"] == "Edit") {
    $trans->setTransactionId($_POST['trans_id']);
    $trans->setAmount($amount);
    $trans->setPartyCode('0');
    $trans->setDescript($_POST['lib_dep'] . ': ' . $_POST['comment_trans']);
    $trans->setCreateDate($trans_date);
    $trans->setModePaie('CAISSE');
    $trans->setIdBq($_POST['id_bq']);

    $trans->updateCurrent();
    echo ' Modification reussie ';
  }
} else {
  echo "operation existe pas";
}
