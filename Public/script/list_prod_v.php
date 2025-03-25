<?php
@session_start();
require_once '../../Models/Admin/product.class.php';
require_once '../../Models/Admin/stock.class.php';
$products= new Product();
$stocks=new Stock();

if(empty($_POST['keyword'])){$keyword='-*';}else{$keyword=$_POST['keyword'];}

$list=$products->select_all_srch_prod($keyword);
// var_dump($list);
$i=0;
foreach ($list as $rs) {
	$stock =$stocks->select($rs['product_id'],$_SESSION['pos']);
      $name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['product_name']);
      echo '<li class="choose_prod_v"  id="'.$rs['product_id'].'" data-id="'.$rs['product_name'].'">'.$name.' ('.$stock->quantity.')</li>';
     $i++;
}

if($i>0)
{
echo '<li class="choose_prod_v"  id="0" data-id="Aucun">Aucun</li>';
}
?>
