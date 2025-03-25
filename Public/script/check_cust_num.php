<?php
require_once '../../Models/Admin/customer.class.php';
$cust = new Customer();
$nb=$cust->select_exist_num($_POST['code']);
echo $nb;
?>
