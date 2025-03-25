<?php
session_start();
require_once('../../Models/Admin/detOperation.class.php');
$com = new detOperation();
$id=isset($_POST['id'])?$_POST['id']:'';
$com->delete($_POST["det_id"]);
?>
