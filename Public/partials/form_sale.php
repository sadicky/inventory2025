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

$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];
$change = true;

$per = $periodes->getPeriode($_SESSION['periode']);
if (isset($_SESSION['op_vente_id'])) {
  $op = $operations->getOperationId($_SESSION['op_vente_id']);
  $vente = $ventes->select($_SESSION['op_vente_id']);
  $pers = $personnes->select($op->party_code);
  $cust = $customers->select($op->party_code);
  $tar = $tarifs->select($op->tar_id);
  //$ben->select($vente->getBen());
  echo '<input type="hidden" value="' . $_SESSION['op_vente_id'] . '" id="crt_op_id" name="crt_op_id">';
}

if (isset($_SESSION['op_vente_id'])) {
  if ($transactions->select_all_op_count($_SESSION['op_vente_id']) > 0) {
    $change = false;
  } else {
    $change = true;
  }
} 
?>
<h1 align="center"><b><U>VENTE CASH</U></b></h1>
<section class="row" style="margin-top:10px; margin-left:5px;">
  <div class="col-md-4">
    <?php include('../../Public/partials/form_sale_prod.php'); ?>
  </div>
  <div class="col-md-4">
    <?php include('../../Public/partials/form_sale_details_prod.php'); ?>
  </div>
  <div class="col-md-4">
    <?php include('../../Public/partials/tab_sale_details_prod.php'); ?>
  </div>
</section>
<hr>
<?php //include('../../Public/modals/customer.php'); 
?>