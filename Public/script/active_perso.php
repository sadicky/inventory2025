<?php
@session_start();
require_once("../../Models/Admin/user.class.php");
$users = new User();
$user = $users->getStaffId($_POST['staff_id']);
// var_dump($user);die();
if($user->etat==0)
{
$msg='Utilisateur Restauré! ';
$users->update_one_($_POST["staff_id"],'staff_id','etat',1);
}
else
{
$msg='Utilisateur Suspendu! ';
$users->update_one_($_POST["staff_id"],'staff_id','etat',0);
}

 echo $msg;

?>
