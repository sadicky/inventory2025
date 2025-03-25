<?php
@session_start();

require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/livraison.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once("../../Models/Admin/caisse.class.php");

$operations = new Operation();
$details = new DetOperation();
$ventes = new Vente();
$livraisons = new Livraison();
$stocks = new Stock();
$stockTo = new Stock();
$products = new Product();
$stores = new POS();
$prices = new Tarif();
$pers = new User();
$jour = new Journal();
$sorties = new Sortie();
$caiss = new Caisse();

$periode_id = $_SESSION['periode'];
$jourId = $_SESSION['jour'];
$role = $_SESSION['role'];

$pos = $_SESSION['pos'];
$pos_id = $stores->getPOS($pos);
$caissse = $caiss->getCaisseBranche($pos_id->branche_id);

// var_dump($caisse->caisse_id);
// die();

if (!isset($_SESSION['op_chg_id'])) {
  $posId = $_POST['pos_id'];
  $posIdTo = $_POST['dest_id'];
} else {
  $op = $operations->getOperationId($_SESSION['op_chg_id']);
  $posId = $op->pos_id;

  $opTo = $operations->getOperationId($op->party_code);
  $posIdTo = $opTo->pos_id;
}

$qt = (float)str_replace(',', '', $_POST['qt']);
$qtTo = (float)str_replace(',', '', $_POST['qt']);
$qqte = str_replace(',', '', $_POST['qqte']);

if ($qt > $qqte) {
  echo ' <script> alert("Quantité insuffisante en stock !")</script>';
  exit(1);
} else {

  if (!isset($_SESSION['op_chg_id'])) {
    $op_type = 6;
    $party_type = 1;
    $jour_id = $_SESSION['jour'];
    $party_code = $posId;
    $user_id = $_SESSION['id'];
    $pos_id = $posIdTo;
    if ($role == 1) $state = 1;
    else $state = 0;
    $is_paid = 0;
    $caisse = $caissse->caisse_id;

    $periode_id = $_SESSION['periode'];

    $lastOpTo = $operations->setOperation($user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $periode_id, $party_type, $pos_id, $caisse);

    $op_type = 5;
    $party_type = 2;
    $jour_id = $_SESSION['jour'];
    $party_code = $posIdTo;
    $user_id = $_SESSION['id'];
    $pos_id = $posId;
    if ($role == 1) $state = 1;
    else $state = 0;
    $is_paid = 0;
    $caisse = $caissse->caisse_id;

    $_SESSION['op_chg_id'] = $operations->setOperation($user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $periode_id, $party_type, $pos_id, $caisse);

    $operations->update_one($lastOpTo, 'op_id', 'party_code', $_SESSION['op_chg_id']);
  }

  $prod = $products->getProductId($_POST['prod_id']);

  $qt = (float)str_replace(',', '', $_POST['qt']);
  $qtTo = (float)str_replace(',', '', $_POST['qt']);
  $qqte = str_replace(',', '', $_POST['qqte']);
  $price = $_POST['price'];
  $prodId = $_POST['prod_id'];
  $prodIdTo = $_POST['prod_id'];

  $op = $operations->getOperationId($_SESSION['op_chg_id']);
  //$opTop->select($op->getPartyCode());

  if (isset($_POST["operation"])) {
    if (!empty($_POST['det_id'])) {
      $d = $details->getDetail($_POST['det_id']);
      $dateExp = $d->date_exp;
      $dateFab =  $d->date_fab;
      $lot = $d->lot;
    } else {
      $lot = $_POST['lot'];
    }
    $st = $stocks->select_by_prod($prodId, $posId);
    $stockTo = $stocks->select_by_prod($prodIdTo, $posIdTo);
    $exist = $stocks->existstock_by_prod($prodIdTo, $posIdTo);
    //  var_dump($posId);die();

    if ($_POST["operation"] == "Add") {
      $op_id = $op->op_id - 1;
      //  var_dump($lastOpTo);die();

      $in = $details->setDetailOperation($op_id, $prodIdTo, $qtTo, 0);

      $out = $details->setDetailOperation($_SESSION['op_chg_id'], $prodIdTo, $qt, 0);
      $details->update_one($out, 'details_id', 'det', $in);

      $st = $stocks->select_by_prod($prodId, $posId);

      $qt_stk = $st->quantity - $qt;
      // var_dump($stocks->getQuantity());
      if ($role == 1) {
        $stocks->update_qt($st->stock_id, $qt_stk);
      }

      // var_dump($prodIdTo);die();
      if (!$exist) {
        // $stocks->setDateExp($dateExp);
        // $stocks->setDateFab($dateFab);
        // $stocks->setLot($lot);

        if ($role == 1) {
          $last_stk = $stocks->insert($prodIdTo, $qtTo, $posIdTo);
        }
        // echo 'Dest '.$qtTo.'-'.$posIdTo.'-'.$dateExp.'-'.$dateFab.'-'.$lot;
      } else {
        // $stockTo = $stocks->select($prodIdTo,$posIdTo,$lot);
        $stockTo = $stocks->select_by_prod($prodIdTo, $posIdTo);
        $qt_stkTo = $stockTo->quantity + $qtTo;
        if ($role == 1) {
          $stocks->update_qt($stockTo->stock_id, $qt_stkTo);
        }
        $last_stk = $stockTo->stock_id;
        //echo 'T';
      }
      // $details->update_one($in,'details_id','date_fab',$dateFab);
      // $details->update_one($out,'details_id','date_fab',$dateFab);
      // $stocks->update_one($last_stk,'stock_id','date_fab',$dateFab);

      echo ' Enregistrement reussi ';
    }
  } else {
    echo "operation existe pas";
  }
}
