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
require_once('../../Models/Admin/sortie.class.php');
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
$sorties = new Sortie();

$idPer = $_SESSION['periode'];
$role = $_SESSION['role'];

$pos = $_SESSION['pos'];
$pos_id = $stores->getPOS($pos);
$caissse = $caisses->getCaisseBranche($pos_id->branche_id);

$jour_id = 1;

if (!isset($_SESSION['op_sort_id'])) {
  $posId = $_POST['pos_id'];
} else {
  $op = $operations->getOperationId($_SESSION['op_sort_id']);
  $posId = $op->pos_id;
}
$qt = (float)str_replace(',', '', $_POST['qt']);
$qtTo = (float)str_replace(',', '', $_POST['qt']);
$qqte = str_replace(',', '', $_POST['qqte']);

if ($qt > $qqte) {
  echo '<script>alert("Quantité insuffisante en stock !")</script>';
} else {
  if (!isset($_SESSION['op_sort_id'])) {
    $op_type = 2;
    $party_type = 2;
    $jour_id = $_SESSION['jour'];
    $party_code = '-';
    $pos_id = $posId;
    $user_id = $_SESSION['id'];
    if ($role == 1) $state = 1;
    else $state = 0;
    $periode_id = $idPer;
    $is_paid = 0;
    $caisse = $caissse->caisse_id;

    $_SESSION['op_sort_id'] = $operations->setOperation($user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $periode_id, $party_type, $pos_id, $caisse);

    $op = $operations->getOperationId($_SESSION['op_sort_id']);
    $last_sort = $sorties->select_last_num();
    $last_num = ($last_sort['last_num'] + 1) . '/' . date("my", strtotime($op->create_date));

    $ad_sorties = $sorties->insert(0, $_SESSION['op_sort_id'], $last_num, $_POST['motif'], '-');
  }

  $prod = $products->getProductId($_POST['prod_id']);

  $qt = (float)str_replace(',', '', $_POST['qt']);
  $price = (float)str_replace(',', '', $_POST['price']);
  $prodId = $_POST['prod_id'];
  $sup_id = $_POST['sup_id'];
  $s = $sorties->select($_SESSION['op_sort_id']);
  $m_sort = 0;


  if (isset($_POST["operation"])) {
    if (!empty($_POST['det_id'])) {
      $d = $details->getDetail($_POST['det_id']);
    } else {
      $lot = $_POST['lot'];
    }

    $st = $stocks->select_by_prod($prodId, $posId);

    if ($_POST["operation"] == "Add") {
      $last_det = $details->setDetailOperation($_SESSION['op_sort_id'], $prodId, $qt, $price);

      $m_sort = $price * $qt;
      $m_sort += $sorties->getAmount();

      // $stocks->setQuantity($qt);

      $sorties->update($_SESSION['op_sort_id'], $m_sort);

      //endommage
      if ($_POST['motif'] == 'Endomagé') {
        $st_e = $sorties->select_product_endom($prodId, $_POST['sup_id'], $posId);
        if (empty($st_e)) {
          $sorties->setEndom($_POST['prod_id'], $_POST['qt'], $_POST['sup_id'],  $_POST['pos_id']);
        } else {
          $qt_stk_e = $st_e->qty + $qt;
          if ($role == 2) {
            $sorties->update_qt_endom($st_e->endom_id, $qt_stk_e);
          }
          echo ' Enregistrement reussi ';
        }
      }

      $st = $stocks->select_by_prod($prodId, $posId);
      if (empty($st)) {
        echo ' Impossible de faire la sortie';
      } else {

        $qt_stk = $st->quantity - $qt;

        // var_dump($stocks->getQuantity());
        if ($role == 2) {
          $stocks->update_qt($st->stock_id, $qt_stk);
        }
        echo ' Enregistrement reussi ';
      }
    }
  } else {
    echo "operation existe pas";
  }
}
