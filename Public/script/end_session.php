<?php
@session_start();

if(isset($_SESSION['op_appro_id']))
{
unset($_SESSION['op_appro_id']);
}

if(isset($_SESSION['op_cmd_id']))
{
unset($_SESSION['op_cmd_id']);
}

if(isset($_SESSION['op_sort_id']))
{
unset($_SESSION['op_sort_id']);
}

if(isset($_SESSION['op_chg_id']))
{
unset($_SESSION['op_chg_id']);
}

if(isset($_SESSION['op_vente_id']))
{
unset($_SESSION['op_vente_id']);
}

if(isset($_SESSION['op_bon_id']))
{
unset($_SESSION['op_bon_id']);
}

if(isset($_SESSION['list_det']))
{
unset($_SESSION['list_det']);
}
?>
