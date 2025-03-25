<?php
@session_start();
require_once '../../Models/Admin/product.class.php';
require_once '../../Models/Admin/stock.class.php';
require_once '../../Models/Admin/tarif.class.php';
$products= new Product();
$tarifs=new Tarif();
$stocks=new Stock();



if(empty($_POST['keyword'])){$keyword='-*';}else{$keyword=$_POST['keyword'];}

$list=$products->select_all_srch_prod($keyword);

$i=0;
foreach ($list as $rs) {
	
$pr = $tarifs->select_2($rs['product_id'],$tarId);

  $name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['product_name']);
   echo '<li class="choose_prod_v choose_lot_v"  id="'.$rs['product_id'].'" data-id="'.$rs['product_name'].'">'.$name.' ('.$pr->price.')</li>';
   $i++;
	
}

if($i>0)
{
echo '<li class="choose_prod choose_lot"  id="0" data-id="Aucun">Aucun</li>';
}
?>
