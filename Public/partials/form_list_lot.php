<?php

require_once('../../Models/Admin/stock.class.php');
$stocks = new Stock();
require_once('../../Models/Admin/product.class.php');
$products = new Product();

$datas=$stocks->select_all_prod($_POST['prodId'],$_POST['posId']);

foreach ($datas as $value) 
{
	@$d=$products->getProductId($value['product_id']);
	if(@$value['quantity']>0)
	{
	echo '<option value="'.$value['lot'].'"><b>'.$value['quantity'].' '.$d->unt_mes.'</b> - '.$value['lot'].' (Exp :'.date('m/Y',strtotime($value['date_exp'])).')</option>';
	}
}
echo '<option value="0">-- Aucun --</option>';
?> 