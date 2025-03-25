<?php
session_start();
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/detOperation.class.php');
$products = new Product();
$details = new detOperation();

$datas = $details->select_all_6($_POST['op_id'], '0');
?>
<select class="custom-select" id="prod_id" name="prod_id">
  <?php
  foreach ($datas as $un) {
    echo '<option value="' . $un->product_id . '">' . $un->product_name . ' (' . $un->quantity . ')</option>';
  }
  ?>
</select>