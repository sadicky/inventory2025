<?php
require_once("../../Models/Admin/user.class.php");
$user = new User();
$nb=$user->select_exist_pseudo($_POST['pseudo']);
echo $nb;
?>
 