<?php
@session_start();
require_once("../../Models/Admin/user.class.php");
$users = new User();
$user = $users->select_1($_POST['user_id']);
// var_dump($user);die();
if($user->statut=='0')
{
$msg='Utilisateur Restauré! ';
}
else
{
$msg='Utilisateur Suspendu! ';
}

 $users->update_one($_POST["user_id"],'user_id','statut',$_POST['etat']);
 echo $msg;

?>
