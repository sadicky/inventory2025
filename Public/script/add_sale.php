<?php
@session_start();
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/commande.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/supplier.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/config.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/customer.class.php');

$achats = new Achat();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$det = new detOperation();
$journals = new Journal();
$operations = new Operation();
$products = new Product();
$periodes = new Periode();
$stores = new POS();
$suppliers = new Supplier();
$users = new User();
$autres = new AutreFrais();
$transactions = new Transactions();
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();
$conf = new Config();
$customers = new Customer();
$ventes = new Vente();
$stocks = new Stock();

$cfg = $conf->select('1');

$idPer = $_SESSION['periode'];
$jour = $journals->select($_SESSION['jour']);
if (!isset($_SESSION['op_vente_id'])) {
  $posId = $_POST['pos_id'];
} else {
  $op = $operations->getOperationId($_SESSION['op_vente_id']);
  $posId = $op->pos_id;
}

$st = $stores->getStoreId($_SESSION['pos']);
$stores = $stores->getBranchePOS($st->branche_id);
$caisse = $caisses->getCaisseId($st->branche_id);

$tar = $tarifs->select($_POST['tar_id']);
$prod = $products->getProductId($_POST['prod_id']);
$cust_id = $_SESSION['cust'];

$price2 = $_POST['price'];
$price = $_POST['price'];

$bq = $caisse->caisse_id;

if (!isset($_SESSION['op_vente_id'])) {
  $op_type = 4;
  $periode_id = $idPer;
  $party_type = 2;
  $jour_id = $_SESSION['jour'];
  $party_code = $cust_id;
  $state = 1;
  $is_paid = 1;
  $personne_id = $_SESSION['perso_id'];
  $sup_id = '';
  $pos_id  = $posId;
  $user_id = $_SESSION['id'];
  $op_createDate = $jour->start_date;

  $_SESSION['op_vente_id'] = $operations->setOperation($user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $periode_id, $party_type, $pos_id, $bq);

  $operations->update_one($_SESSION['op_vente_id'], 'op_id', 'tar_id', $_POST['tar_id']);
}

$prod = $products->getProductId($_POST['prod_id']);
$qt = $_POST['qt'];
$price = $_POST['price'];
$prodId = $_POST['prod_id'];
$vente = $ventes->select($_SESSION['op_vente_id']);
$op = $operations->getOperationId($_SESSION['op_vente_id']);
$cust = $customers->select($cust_id);
$m_vente = 0;

if (isset($_POST["operation"])) {
  if (!empty($_POST['det_id'])) {
    $details = $det->getDetail($_POST['det_id']);
    $lot = $details->lot;
  } else {
    $lot = $_POST['lot'];
  }

  if ($_POST["operation"] == "Add") {

    $st = $stocks->select_by_prod($prodId, $posId);
    $qt_stk = $st->quantity - $qt;

    if ($st->quantity < $qt or $qt < 0) {
      echo '<script>alert("Quantité insuffisante en stock")</script>';
    } else {
      $assId = 0;
      
      $is_paid = 1;
      
      $party_code = $cust_id;

      $vente = $ventes->select($_SESSION['op_vente_id']);

      if (empty($vente->num_vente)) {
        $num_vente = 1;
      } else {
        $num_vente = (int)$vente->num_vente + 1;
      }
      $amount = $_POST['price'] * $_POST['qt'];
      $voir = $ventes->setVente($amount, $_SESSION['op_vente_id'], $party_code, $num_vente, $is_paid,$bq);
      // var_dump($voir);
      $last_det = $det->insert($_SESSION['op_vente_id'], $prodId, $qt, $price);
      // $last_det = $det->insert_($_SESSION['op_vente_id'], $prodId, $qt, $price,$red);

      $stock = $stocks->update_qt($st->stock_id, $qt_stk);

      if ($last_det) echo ' Enregistrement reussi';
      else echo 'Erreur';
      if (@$cust->customer_percent > 0) {
        $det->update_one($_SESSION['op_vente_id'], 'op_id', 'det', @$cust->customer_percent);
      }
    }
  }
  if ($_POST["operation"] == "Edit") {

    $details = $det->getDetail($_POST['det_id']);
    // var_dump($details);

    $qt = $_POST['qt'];
    $price = $_POST['price'];
    $prodId = $_POST['prod_id'];

    $det->setProdId($prodId);
    $det->setQuantity($qt);
    $det->setAmount($price);

    $st = $stocks->select_by_prod($prodId, $posId);
    // $qt_stk = $st->quantity - $qt;

    $qty_r = $qt - $details->quantity;

    if ($qt > $details->quantity) {
      // $qt_stk = $stocks->getQuantity() - $qty_r;
      $qt_stk = $st->quantity - $qty_r;
      // var_dump($stocks->getStockId());
    } else {
      $qt_stk = $st->quantity + (-$qty_r);
      // $qt_stk = $stocks->getQuantity() + (-$qty_r);
      // var_dump($qt_stk);
    }
    $add = $det->update($_POST["det_id"]);
    var_dump($add);
    if ($qt_stk < 0) {
      echo 'Quantité insuffisante en stock !';
    } elseif ($add) {
      $stocks->update_qt($st->stock_id, $qt_stk);
      echo ' Modification reussie ';
      //$op->update_one($_SESSION['op_vente_id'],'op_id','is_paid',$_POST['is_paid']);
    } else {
      echo 'Echec Modification';
    }
  }
} else {
  echo "operation existe pas";
}
