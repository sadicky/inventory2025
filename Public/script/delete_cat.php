<?php

require_once '../../Models/Admin/category.class.php';
$cat = new Category();

if(isset($_POST['category_id']))
{
  
  // $cat->deleteCategory($_POST['category_id']);
  echo 'Suppression reussie avec succès';
  
}
else
{
echo " pas Id ";
}

?>
