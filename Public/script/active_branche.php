<?php
@session_start();
require_once("../../Models/Admin/branches.class.php");
$branches = new Branches();
$user = $branches->select_1($_POST['id']);
// var_dump($user);die();
if($user->statut=='0')
{
$msg='<div class="alert alert-success" role="alert">
               <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Branche Restaurée!.
              </div>';
$branches->update_one($_POST["id"],'branche_id','statut',1);
}
else
{
$msg='<div class="alert alert-danger" role="alert">
               <i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Branche Suspendue!.
              </div>';
$branches->update_one($_POST["id"],'branche_id','statut',0);
}

 echo $msg;

?>
