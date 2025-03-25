<?php
session_start();
require_once('../../Models/Admin/devise.class.php');
$devises = new Devise();

if(isset($_POST["id"]))
{
  $devises->deleteDevise($_POST['id']);
}
else
{
echo " pas Id";
}

?>
