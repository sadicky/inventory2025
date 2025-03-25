<?php

session_start(); 
require_once("../../Models/Admin/config.class.php");
$soc = new Config();
$soc->updateSoc($_POST['tp_type'],$_POST['tp_name'],$_POST['tp_tin'],$_POST['tp_trade_number'],$_POST['tp_postal_number'],$_POST['tp_phone_number'], $_POST['tp_address_province'],$_POST['tp_address_commune'],$_POST['tp_address_quartier'],$_POST['tp_address_avenue'],$_POST['tp_address_rue'],$_POST['tp_address_number'],$_POST['vat_taxpayer'],$_POST['ct_taxpayer'],$_POST['tl_taxpayer'],$_POST['tp_fiscal_center'],$_POST['tp_activity_sector'],$_POST['tp_legal_form'],'1');

echo 'Enregistrement reussi';  
?>
