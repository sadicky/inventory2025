<?php

require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/category.class.php');
$products = new Product();
$categories = new Category();
if (empty($_GET['keyVal'])) {
	$keyVal = '*';
} else {
	$keyVal = $_GET['keyVal'];
}
// $datas = $products->searchAllProducts($keyVal);
$datas = $products->searchAllDetails($keyVal);

foreach ($datas as $un): ?>
	<tr>
		<td><?= $un->category_name ?></td>
		<td><?= $un->product_name ?></td>
		<td><?= $un->details ?></td>
		<td>
			<a type="button" href="index.php?p=ProductTarif&product_id=<?= $un->product_id ?>"> Afficher <span class="fa fa-plus"></span></a>
		</td>
		<td> <a href="index.php?p=ProductMod&product_id=<?= $un->product_id ?>" class="modifier_product" id="<?= $un->product_id ?>"><span class="fa fa-edit"></span></a></td>

		<td>
			<a href="#" class='trash_art' id='<?= $un->product_id ?>'><i class="fa fa-times"></i></a>
		</td>
	</tr>
<?php endforeach; ?>