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
$posId = $_SESSION['pos'];

$st = $stores->getStoreId($_SESSION['pos']);
$stores = $stores->getBranchePOS($st->branche_id);
$caisse = $caisses->getCaisseId($st->branche_id);
// print_r($_POST);
// die();

$cust_id = $_POST['cust_id'];
$price = $_POST['price'];
$etat = $_POST['type'];
$qt = $_POST['qt'];
$qty = $_POST['qty'];
$price = $_POST['price'];
$prodId = $_POST['prod_id'];
$agent = $_POST['agent_id'];

$_SESSION['etat'] = $etat;
$prod = $products->getProductId($prodId);
$bq = $caisse->caisse_id;

if (!isset($_SESSION['op_vente_id'])) {
  $op_type = 4;
  $periode_id = $idPer;
  $party_type = 2;
  $jour_id = $_SESSION['jour'];
  $party_code = $cust_id;
  $state = 0;
  $is_paid = 0;
  $pos_id  = $posId;
  $user_id = $_SESSION['id'];
  $op_createDate =  $_POST['date'];

  $_SESSION['op_vente_id'] = $operations->setOperation_($op_createDate, $user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $periode_id, $party_type, $pos_id, $bq);

  $operations->update_one($_SESSION['op_vente_id'], 'op_id', 'tar_id', $agent);
}

$prod = $products->getProductId($_POST['prod_id']);

$vente = $ventes->select($_SESSION['op_vente_id']);
$op = $operations->getOperationId($_SESSION['op_vente_id']);
$cust = $customers->selectId($cust_id);
$m_vente = 0;

if (isset($_POST["operation"])) {
  if (!empty($_POST['det_id'])) {
    $details = $det->getDetail($_POST['det_id']);
  }

  if ($_POST["operation"] == "Add") {

    $qt_stk = $qty - $qt;

    if ($qt > $qty) {
      echo "Quantité insuffisante en stock";
    } else {

      $party_code = $cust_id;

      $vente = $ventes->select($_SESSION['op_vente_id']);

      if (empty($vente->num_vente)) {
        $num_vente = 1;
      } else {
        $num_vente = (int)$vente->num_vente + 1;
      }
      $amount = $price * $qt;
      $voir = $ventes->setVente($amount, $_SESSION['op_vente_id'], $party_code, $num_vente, 0, $bq);

      $last_det = $det->insert($_SESSION['op_vente_id'], $prodId, $qt, $price);

      if ($last_det) echo ' Enregistrement reussi';
      else echo 'Erreur';
    }
  }
  if ($_POST["operation"] == "Edit") {

    $details = $det->getDetail($_POST['det_id']);
    // var_dump($details);

    $qt = $_POST['qt'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $prodId = $_POST['prod_id'];

    $det->setProdId($prodId);
    $det->setQuantity($qt);
    $det->setAmount($price);

    // $qt_stk = $st->quantity - $qt;

    $qty_r = $qt - $qty;

    if ($qt > $qty) {
      echo 'Quantité insuffisante en stock !';
      return;
    } else {
      $qt_stk = $qty + (-$qty_r);
      echo ' Modification reussie ';
    }
    $add = $det->update($_POST["det_id"]);
    if ($add) {
      echo ' Modification reussie ';
    } else {
      echo 'Echec Modification';
    }
    // var_dump($add);
  }
} else {
  echo "operation existe pas";
}
