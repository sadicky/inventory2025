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

$achats = new Achat();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$details = new detOperation();
$journals = new Journal();
$operations = new Operation();
$products = new Product();
$periodes = new Periode();
// $stores = new POS();
$suppliers = new Supplier();
$users = new User();
$autres = new AutreFrais();
$transactions = new Transactions();
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();

$posId = $_SESSION['pos'];
if (isset($_SESSION['last_jour'])) {
    $jour = $_SESSION['last_jour'];
    $jr = $journals->select($jour);
}
?>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">

        <div class="ms-panel" style="padding:20px;" id="rapport">
            <div class="pull-right"> <a href="javascript:void(0)" id="print_rp" class="ms-btn-icon btn-danger pull-left" title="Imprimer"><span style="color:white;" class="fa fa-print"></span></a></div>
            <h3 class="box-title m-b-0">Remise de Caisse de Caisse</h3>
            <h3>Début : <?= @$jr->from_date ?> / Fin : <?= @$jr->to_date ?></h3>
            <h3>Vendeur : <?php @$pers = $personnes->select_1(@$jr->user_id);  echo @$pers->nom_complet ?></h3>

            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-condensed display">
                    <tbody>
                        <tr>
                            <th colspan="2">Fonds de Caisse</th>
                            <th style="text-align: right"><?php echo number_format(@$jr->open_bal); ?></th>
                        </tr>
                        <tr>
                            <th colspan="2">Montant Encaissé</th>
                            <th style="text-align: right"><?php echo number_format(@$jr->closing_cash); ?></th>
                        </tr>
                    </tbody>
                </table>
                <h3 style="text-align: left;"><span>Pour la Remise :</span></h3>
                <h3 style="text-align: right;"><span>Pour la Réception :</span>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>

<div style="padding-top: 20px;"></div>
<script src="assets/js/data-tables.js"></script>