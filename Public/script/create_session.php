<?php
@session_start();

if(isset($_POST['appro_id']))
{
$_SESSION['op_appro_id']=$_POST['appro_id'];
}

if(isset($_POST['cmd_id']))
{
$_SESSION['op_cmd_id']=$_POST['cmd_id'];
}

if(isset($_POST['sort_id']))
{
$_SESSION['op_sort_id']=$_POST['sort_id'];
}

if(isset($_POST['chg_id']))
{
$_SESSION['op_chg_id']=$_POST['chg_id'];
}

if(isset($_POST['sale_id']))
{
$_SESSION['op_vente_id']=$_POST['sale_id'];
}

if(isset($_POST['bon_id']))
{
$_SESSION['op_bon_id']=$_POST['bon_id'];
}

?>
