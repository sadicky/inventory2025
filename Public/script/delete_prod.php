<?php

require_once '../../Models/Admin/product.class.php';
$prod = new Product();

if(isset($_POST['prod_id']))
{
  $prod->delete($_POST['prod_id']);
  echo 'Suppression reussie avec succès';
}
else
{
echo " pas Id ";
}

?>
