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
require_once('../../Models/Admin/account.class.php');
require_once('../../Models/Admin/ben.class.php');
require_once('../../Models/Admin/customer.class.php');
require_once('../../Models/Admin/livraison.class.php');
require_once('../../Models/Admin/coupon.class.php');

$achats = new Achat();
$accounts = new Account();
$ben = new Ben();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$details = new detOperation();
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
$users = new User();
$livraisons = new Livraison();
$coupons = new Coupon();
$cfg = $conf->select('1');

$soc = $conf->getSociety();
// var_dump($_GET);
// die();
$posId = $_SESSION['pos'];

if (isset($_GET['id'])) {
  if ($transactions->select_all_op_count($_GET['id']) > 0) {
    $change = false;
  } else {
    $change = true;
  }
  echo '<input type="hidden" value="' . $_GET['id'] . '" id="crt_op_id" name="crt_op_id">';
}
?>


<section class="row">
  <div class="col-md-4">
    <?php include('../../Public/partials/market_forms.php'); ?>
  </div>
  <div class="col-md-8">
    <?php include('../../Public/partials/market_details.php'); ?>
  </div>
</section>
<hr>