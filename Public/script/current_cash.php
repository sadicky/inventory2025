<?php
@session_start();
require_once('../../Models/Admin/user.class.php');
$user = new User();
$user->select($_POST['user_id']);

$msg='Caissier encours validée ';

if(isset($_POST["user_id"]))
{
 $user->update_one('2','type_user','cash',false);
 $user->update_one($_POST["user_id"],'user_id','cash',true);
 echo $msg;
}
else
{
echo " pas Id";
}



?>
