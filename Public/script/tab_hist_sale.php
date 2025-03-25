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

// $pers=new BeanPersonne();
// $pers2=new BeanPersonne();
// $perso=new BeanPersonne();

if ($_SESSION['role'] == 1) {
	$data = $pos->getStores();
	$caisse = $caisses->getCaisses();
} else {
	$st = $pos->getStoreId($_SESSION['pos']);
	$data = $pos->getBranchePOS($st->branche_id);
	$caisse = $caisses->getIdCaisseBranche($st->branche_id);
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
<style type="text/css">
	ul.custom-list li::before {
		content: "•";
		color: red;
		font-size: 1.2rem;
		margin-right: 10px;
	}

	ul.custom-list {
		list-style: none;
		padding-left: 0;
	}
</style>
<div class="card">
	<div class="card-header bg-light">Historique des ventes</div>
	<div class="card-body">
		<form method="post" id="sale-search">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">Du</label>
					<input type="date" name="from_d" id="from_d" class="form-control" value="<?php echo $from_d; ?>">
				</div>
				<div class="col-md-2">
					<label class="control-label">Au</label>
					<input type="date" name="to_d" id="to_d" class="form-control" value="<?php echo $to_d; ?>">
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label class="control-label">STOCK</label>
						<select class="custom-select" id="pos_id" name="pos_id" required readonly>

							<?php
							// $datas = $pos->getStores();
							foreach ($data as $value) {
								if ($value->store_id == $posId) {
									if ($value->type == 'VENTE') {
										echo '<option value="' . $value->store_id . '" selected>' . $value->store . '(' . $value->type . ')</option>';
									}
								} else {
									if ($value->type == 'VENTE') {
										echo '<option value="' . $value->store_id . '">' . $value->store . '(' . $value->type . ')</option>';
									}
								}
							}
							?>
						</select>

					</div>
				</div>
				<div class="col-md-2">
					<br>
					<button type="submit" class="ms-btn-icon btn-primary"><i class="text-white fa fa-search"></i></button>
				</div>
			</div>
		</form>
		<?php if (!empty($_GET['pos_id'])) : ?>
			<div class="title m-3" style="text-align: center; font-weight: bold; font-size: 14px;">
				<h3>Du <?php echo $from_d; ?> Au <?php echo $to_d; ?> / <?php $p = $pos->getPOS($posId);
																		echo $p->type . '(' . $p->store . ')'; ?></h3>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-sm tab">
					<thead>
						<tr>
							<th>Date</th>
							<th>Client</th>
							<th>Montant</th>
							<th>Produits</th>
							<th>Etablie par</th>
						</tr>
					</thead>

					<tbody>
						<?php
						if (empty($id))
							$datas = $operations->select_all_by_period_vente('Vente', $from_d, $to_d, $posId);
						else
							$datas = $operations->select_all_by_period_pay_type('Vente', $from_d, $to_d, $posId, $id);

						$totM = 0;
						$i = 1;
						foreach ($datas as $key => $value) {
							$pers2 = $user->select($value['user_id']);
							$vente = $ventes->select($value['op_id']);
							$liv = $livraisons->select($value['op_id']);
							$pers = $customers->select($value['party_code']);
							echo '<tr>
						<td><a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="' . $value['op_id'] . '">' . $value['create_date'] . '</a></td><td>' . @$pers->customer_name . '</td><td align="right">' . number_format($det->select_sum_op($value['op_id']), 0, ',', ' ') . '</td><td><ul class="custom-list">';
							$dt = $det->select_all($value['op_id']);
							foreach ($dt as $key => $value2) {
								$prod = $products->getProductId($value2['product_id']);
								echo '<li>(<b>' . $value2['quantity'] . '</b>) - ' . $prod->product_name . '</li>';
							}
							echo '</ul>';


							echo '</td><td>';
							echo $pers2->noms;
							echo '</td></tr>';
							$totM += $det->select_sum_op($value['op_id']);
							$i++;
							//}
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th>Total</th>
							<th colspan="2" style="text-align: right">
								<?php echo number_format($totM, 0, ',', ' '); ?>
							</th>
							<th>-</th>
							<th>-</th>

						</tr>
					</tfoot>
				</table>
			</div>
		<?php endif; ?>
	</div>
</div>