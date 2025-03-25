<?php
session_start();
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');
$caisses = new Caisse();
$branches = new Branches();
$operations = new Operation();
$details = new detOperation();
$achats = new Achat();
$stores = new POS();
$products = new Product();
$stocks = new Stock();
$transactions = new Transactions();
$tarifs = new Tarif();

if (isset($_SESSION['jour'])) {
  $jourId = $_SESSION['jour'];
}

$opId = $_POST['op_id'];

$op = $operations->getOperationId($opId);

$amount = 0;
//$amount = $details->select_sum_op($opId);
$bq = $caisses->getCaisseId($op->caisse_id);

$transaction_type = 2;
$idPer = $_SESSION['periode'];
$personne_id = $_SESSION['id'];
$party_code = $op->party_code;
$descript = 'Achats des produits';
$pos_id = $op->pos_id;
$status = 2;
$create_date = date('Y-m-d');
$id_bq = $op->caisse_id;
$mode_paie = $bq->caisse_name;

// $transactions->insert($jour_id, $op_id, $transaction_type, $descript,
//  $mount, $party_code, $id_bq, $pos_id, $personne_id, $status, $create_date, $mode_paie);

$transactions->insert(
  $jourId,
  $opId,
  $transaction_type,
  $descript,
  $amount,
  $party_code,
  $id_bq,
  $pos_id,
  $idPer,
  $status,
  $create_date,
  $mode_paie
);

echo ' Enregistrement reussi ';
unset($_SESSION['op_appro_id']);
