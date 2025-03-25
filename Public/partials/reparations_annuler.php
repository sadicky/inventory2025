<?php
@session_start();

require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/paiement.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/supplier.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/config.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/customer.class.php');
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/livraison.class.php');

$cat = new Category();
$products = new Product();
$stock = new Stock();
$pos = new POS();
$pr = new Tarif();
$tarif = new Tarif();
$det = new DetOperation();
$operations = new Operation();
$user = new User();
$cust = new Customer();
$periodes = new Periode();
$ventes = new Vente();
$caisses = new Caisse();
$paiemenents = new Paiement();
$transactions = new Transactions();
$autres = new AutreFrais();
$customers = new Customer();
$livraisons = new Livraison();

if ($_SESSION['role'] == 1) {
	$data = $pos->getStores();
	$getCaisse = $autres->getReparations_annuler();
} else {
	$st = $pos->getStoreId($_SESSION['pos']);
	$data = $pos->getBranchePOS($st->branche_id);
	$getCaisse = $autres->getReparation_annuler_by_branche($st->branche_id);
}

$idPer = $_SESSION['periode'];

if (!empty($_GET['id'])) $id = $_GET['id'];
else $id = '';
?>
<div class="displ"></div>

<div class="card" style="margin: 20px;">
	<div class="panel-header bg-light" style="margin: 20px;">
		<h2>Réparations Annulées</h2>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-condensed table-bordered tab">
				<thead>
					<tr>
						<th>Client</th>
						<th>Total</th>
						<th>Motif de Reparation</th>
						<?php if ($_SESSION['role'] == 1 or $_SESSION['role'] == 2 or $_SESSION['role'] == 4) { ?>
							<th>Etat</th>
							<th>Statut</th>
						<?php } ?>
						<th>Date Entree</th>
						<?php if ($_SESSION['role'] == 1 or $_SESSION['role'] == 2 or $_SESSION['role'] == 4) { ?>
							<th>Actions</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php $cnt = 1;
					foreach ($getCaisse as $vente) : ?>
						<tr class="odd gradeX">
							<td><b><?= $vente->customer ?></b></td>
							<td><?= number_format($vente->montant, 0, ',', ' ') ?></td>
							<td><?= $vente->motif ?></td>
							<?php if ($_SESSION['role'] == 1 or $_SESSION['role'] == 2 or $_SESSION['role'] == 4) { ?>
								<?php
								if ($vente->statut == 0) {
									echo "<td><a href='javascript:void(0)' id='activrep' data-id='" . $vente->reparation_id . "' class='fs-btn btn-sm btn-primary activers'><i class='fa fa-check' ></i> Effectué?</a></td>";
									echo "<td><a href='javascript:void(0)' id='annulerep' data-id='" . $vente->reparation_id . "' class='fs-btn btn-sm btn-danger annulerrep'><i class='fa fa-times' ></i> Annuler</a></td>";
								} else {
									echo "<td><label class='label label-success'>Effectué</label></td>";
									echo "<td>Validé</td>";
								}
								?>
							<?php } ?>
							<td><?= $vente->date_create ?></td>

							<?php if ($_SESSION['role'] == 1 or $_SESSION['role'] == 2 or $_SESSION['role'] == 4) { ?>
								<td>
									<a href="javascript:void(0)" id="repannuler" class="fs-btn btn-light btn-sm" onclick="printOrder(<?= $vente->reparation_id ?>)"> <i class="fa fa-print"></i> Imprimer </a>
									<a href="javascript:void(0)" id="repannuler" class="fs-btn btn-danger btn-sm" onclick="removeOrder(<?= $vente->reparation_id ?>)"> <i class="fa fa-trash"></i> Supprimer</a>

								</td>

							<?php } ?>
						</tr>
					<?php $cnt++;
					endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div style="padding-top: 20px;"></div>