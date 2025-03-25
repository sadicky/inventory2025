<?php
session_start();
require_once('../../Models/Admin/coupon.class.php');
// require_once('../../Models/Admin/detOperation.class.php');
$coupon =new Coupon();
// $det=new DetOperation();

// $amount=$det->select_sum_op_init($_POST['op_id']);
// $redu = $det->update_red($_POST['op_id'],$_POST['red']);
$red=$_POST['red'];
if(!$coupon->select_exist_op($_POST['op_id']))
{
$coupon->setOpId($_POST['op_id']);
$coupon->setDiscount($red);
$coupon->insert();
}
else
{
$coupon->setDiscount($red);
$coupon->update($_POST['op_id']);
}
?>