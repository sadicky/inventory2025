<?php
@session_start();
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/tarif.class.php');
$branches = new Branches();
$stocks = new Stock();
$stores = new POS();
$tarifs = new Tarif();
$products = new Product();

$_SESSION['cust'] = $_POST['cust'];
// echo($_POST['cust']);
$posId = $_SESSION['pos'];

$st = $stores->getStoreId($posId);
// $stores = $stores->getBranchePOS($st->branche_id);

$tar = $tarifs->select($st->branche_id);
$datas = $products->select_all_crt_tar($_POST['rech'], $posId);
var_dump($datas);
?>
<h5>Branche : <?php echo $tar->branche; ?></h5>
<table class="table table-striped table-bordered table-hover table-sm">
	<thead>
		<tr>
			<th>Libellé</th>
			<th>Qté</th>
			<th>Prix</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($datas as $value) {

			$price = $tarifs->select_2($value->product_id, $st->branche_id);
			// var_dump($price);
			if ($price->is_sale == '1') {
				echo '<tr><td><a href="javascript:void(0)" id="' . $value->product_id . '" data-id="' . $value->product_name . '"
			 class="select_prod_sale">' . $value->product_name . '</a></td><td>' . $value->quantity . '</td><td class="edit_tarif"
			  contenteditable="true" id="' . $price->price_id . '" data-id="price">' . ($price->price) .''.$_SESSION['short2'].'</td></tr>';
			}
		}
		?>
	</tbody>
</table>