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
$autres = new AutreFrais();
$user = new User();
$cust = new Customer();
$periodes = new Periode();
$ventes = new Vente();
$caisses = new Caisse();
$paiemenents = new Paiement();
$transactions = new Transactions();
$autres = new AutreFrais();
$customers = new Customer();
$branches = new Branches();
$livraisons = new Livraison();

// $pers=new BeanPersonne();
// $pers2=new BeanPersonne();
// $perso=new BeanPersonne();

if ($_SESSION['role'] == 1) {
	$data = $pos->getStores();
} else {
	$data = $branches->getStoreId($_SESSION['pos']);
}
$idPer = $_SESSION['periode'];

if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = date('Y-m-d');
if (!empty($_GET['to_d'])) $to_d = $_GET['to_d'];
else $to_d = date('Y-m-d');
if (!empty($_GET['pos_id'])) $posId = $_GET['pos_id'];
else $posId = $_SESSION['pos'];
if (!empty($_GET['id'])) $id = $_GET['id'];
else $id = '';
?>

<div class="card">
	<div class="card-header bg-light">Historique des Réparations</div>
	<div class="card-body">
		<form method="post" id="repa-search">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">Du</label>
					<input type="date" name="from_d" id="from_d" class="form-control" value="<?php echo @$from_d; ?>">
				</div>
				<div class="col-md-2">
					<label class="control-label">Au</label>
					<input type="date" name="to_d" id="to_d" class="form-control" value="<?php echo @$to_d; ?>">
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label class="control-label">Branche</label>
						<select class="custom-select" id="pos_id" name="pos_id" required>
							<option value="">-Choisir-</option>
							<?php
							// $datas = $pos->getStores();
							foreach ($data as $value) {
								if ($value->store_id == $posId) {
									echo '<option value="' . $value->branche_id . '" selected>' . $value->branche . '</option>';
								} else {
									echo '<option value="' . $value->branche_id . '">' . $value->branche . '</option>';
								}
							}
							?>
						</select>

					</div>
				</div>
				<div class="col-md-2">
					&nbsp;
					<br>
					<button type="submit" class="ms-btn btn-primary">Filtrer <i class="text-white fa fa-search"></i></button>
				</div>
			</div>
		</form>
		<?php if (!empty($_GET['pos_id'])) : ?>
			<div class="title m-3" style="text-align: center; font-weight: bold; font-size: 14px;">
				<h3>Du <?php echo $from_d; ?> Au <?php echo $to_d; ?> </h3>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-sm tab">
					<thead>
						<tr>
							<th>Client</th>
							<th>Total</th>
							<th>Motif de Reparation</th>
							<?php if ($_SESSION['role'] == 1 or $_SESSION['role'] == 2 or $_SESSION['role'] == 4) { ?>
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
						if (empty($id))
							$getCaisse = $autres->getReparations($from_d, $to_d, $posId);
						foreach ($getCaisse as $vente) : ?>
							<tr class="odd gradeX">
								<td><b><?= $vente->customer ?></b></td>
								<td><?= number_format($vente->montant, 0, ',', ' ') ?></td>
								<td><?= $vente->motif ?></td>
								<td><?php // active 
									if ($vente->statut == '1') {
										echo "<label class='text-success'>Effectuée</label>";
									} elseif ($vente->statut == '2') {
										echo "<label class='text-danger'>Annulée</label>";
									} else {
										echo "<label class='text-info'>Encours</label>";
									} ?>
								</td>
								<td><?= $vente->date_create ?></td>

								<?php if ($_SESSION['role'] == 1 or $_SESSION['role'] == 2 or $_SESSION['role'] == 4) { ?>
									<td>
										<a href="javascript:void(0)" class="fs-btn btn-light btn-sm" onclick="printOrder(<?= $vente->reparation_id ?>)"> <i class="fa fa-print"></i> Imprimer </a>
										<a href="javascript:void(0)" class="fs-btn btn-danger btn-sm" onclick="removeOrder(<?= $vente->reparation_id ?>)"> <i class="fa fa-trash"></i> Supprimer</a>

									</td>

								<?php } ?>
							</tr>
						<?php $cnt++;
						endforeach ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
</div>