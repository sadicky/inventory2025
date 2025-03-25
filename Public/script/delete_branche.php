<?php

require_once("../../Models/Admin/branches.class.php");
$branches = new Branches();
// $user = $branches->select_1($_POST['id']);
var_dump($_POST['id']);

if(isset($_POST['id']))
{
  
  $branches->deletebranches($_POST['id']);
  echo '<div class="alert alert-danger" role="alert">
               <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Suppression effectuée!.
              </div>';
}
else
{
echo " pas Id ";
}

?>
