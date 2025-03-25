<?php
@session_start();
require_once("../../Models/Admin/operation.class.php");
$op = new Operation();
if (isset($_POST['val_id'])) {
  $op->delete($_POST['val_id']);
  echo 'Suppression reussie avec succès';
} else {
  echo " pas Id ";
}
