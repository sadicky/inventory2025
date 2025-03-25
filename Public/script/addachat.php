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
require_once('../../Models/Admin/supplier.class.php');
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
$suppliers = new Supplier();

$idPer = $_SESSION['periode'];
$posId = $_SESSION['pos'];
$jour_id = $_SESSION['jour'];

$role = $_SESSION['role'];

// $sup = $suppliers->getSupplier($_POST['sup_id']);

$party_code = $_POST['sup_id'];

if (!isset($_SESSION['op_appro_id'])) {
  $op_type = 1;
  $party_type = 1;
  $jour_id = $_SESSION['jour'];
  if ($role == 1) $state = 1;
  else $state = 0;
  $is_paid = 0;
  $periode_id = $idPer;
  $pos_id  = $_POST['pos_id'];
  $user_id = $_SESSION['id'];
  $op_createDate = date('Y-m-d');

  $_SESSION['op_appro_id'] = $operations->setOperation($user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $periode_id, $party_type, $_POST['pos_id'], $_POST['pay_type']);

  $amount = 0;
  $num_achat = $_POST['num_achat'];
  $op_id = $_SESSION['op_appro_id'];

  if ($role == 1) $state = 1;
  else $state = 0;

  $data = $achats->setAchat($amount, $op_id, $num_achat, $etat);

  if ($role == 1) {
    $operations->update_one($_SESSION['op_appro_id'], 'op_id', 'pay_type', $_POST['pay_type']);
    if (isset($_POST['num_bon'])) $operations->update_one($_SESSION['op_appro_id'], 'op_id', 'doc_type', $_POST['num_bon']);
  }
}

$qt = (float)str_replace(',', '', $_POST['qt']);
$price = (float)str_replace(',', '', $_POST['price']);
$prodId = $_POST['prod_id'];
$getProd = $products->getProductId($prodId);
// var_dump($getProd);die();
$getAchats = $achats->getAchat($_SESSION['op_appro_id']);
$m_achat = 0;

if (isset($_POST["operation"])) {
  if (!empty($_POST['det_id'])) {
    $d = $details->getDetail($_POST['det_id']);
    // $lot = $d->lot;
  } else {
    $lot = $_POST['lot'];
  }

  if ($_POST["operation"] == "Add") {
    $prod_id = $prodId;
    $op_id = $_SESSION['op_appro_id'];
    $quantity = $qt;
    $price = $price;

    $s = $stocks->select_by_prod($prodId, $posId);
    $exist = $stocks->existstock_by_prod($prodId, $posId);

    $last_det = $details->setDetailOperation($op_id, $prod_id, $quantity, $price);

    $m_achat = $price * $quantity;
    $m_achat += $getAchats->amount;

    $achats->update($m_achat, $_SESSION['op_appro_id']);

    if (!$exist) {
      $prod_id = $prodId;
      $quantity = $qt;
      $pos_id = $_POST['pos_id'];

      $stocks->setDateExp($dateExp);
      $stocks->setDateFab($dateFab);
      $stocks->setLot($lot);

      if ($role == 1) {
        $last_stk = $stocks->insert($prod_id, $quantity, $pos_id);
      }
    } else {
      // var_dump($last_stk);
      $l = $stocks->select($last_stk);
      $qt_stk = $l->quantity + $qt;
      if ($role == 1) {
        $last_stk = $stocks->update_qt($l->stock_id, $qt_stk);
      }
      // $last_stk = $stocks->getStockId();
    }


    echo ' Enregistrement reussi ';
  }
  if ($_POST["operation"] == "Edit") {

    $op_id = $_SESSION['op_appro_id'];
    $prod_id = $prodId;
    $quantity = $qt;
    $price = $price;
    $amount = $quantity * $price;

    $details->setProdId($prod_id);
    $details->setQuantity($qt);
    $details->setAmount($price);

    $last_det = $details->getDetailProd_op($op_id, $prod_id);
    $st = $stocks->select_by_prod($prod_id, $posId);
    // $exist = $stocks->existstock_by_prod($prod_id, $posId);

    $qt_stk = $st->quantity + $quantity;
    if ($quantity == '0' and $last_det->amount != $price) {
      $m_achat = (($qt * $price) - ($last_det->amount * $last_det->quantity));
    } else {
      $m_achat = $price * $quantity;
    }

    if ($quantity = 0) {
      echo 'La Quantité doit etre superieur à 0 !';
    } elseif ($details->update($_POST["det_id"])) {
      $m_achat += $achats->getAmount();
      $amount = $achats->setAmount($m_achat);
      $achats->update($amount, $_SESSION['op_appro_id']);
      $stocks->update_qt($st->stock_id, $qt_stk);
      echo ' Modification reussie ';
    } else {
      echo 'Echec Modification';
    }
  }
  if ($operations->exist_in_trans($_SESSION['op_appro_id'])) {
    $transactions->update_op($details->select_sum_op($_SESSION['op_appro_id']), $_SESSION['op_appro_id']);
  }
} else {
  echo "operation existe pas";
}
