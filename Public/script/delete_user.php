<?php

require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/personne.class.php");
$users = new User();
$personnes = new Personne();
// $user = $branches->select_1($_POST['id']);
var_dump($_POST['id']);

if(isset($_POST['id']))
{
  $u = $users->select($_POST['id']);

  $users->deleteUser($_POST['id']);
  echo '<div class="alert alert-danger" role="alert">
               <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Suppression effectuée!.
              </div>';
}
else
{
echo " pas Id ";
}

?>
