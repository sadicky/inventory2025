<?php
@session_start();
require_once("../../Models/Admin/category.class.php");
require_once("../../Models/Admin/product.class.php");
require_once("../../Models/Admin/stock.class.php");

$cat = new Category();
$products = new Product();
$stock = new Stock();


$posId = $_SESSION['pos'];
if ($_POST['level'] == 0)
  $datas = $stock->select_zero($posId);
else
  $datas = $stock->select_under_min($posId);

?>
<div class="card" style="margin:25px; margin-bottom:50px;">

  <div class="card-header bg-light">
    <h3>Stock en dessous du minimum ou en rupture</h3>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover" id="tab">
        <thead>
          <tr>
            <th>Produits</th>
            <th>Cond</th>
            <th>Qté</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($datas as $un) {
            $prod = $products->getProductId($un['product_id']);
            echo '<tr>
          <td>' . $prod->product_name . '</td><td>' . $prod->unt_mes . '</td><td style="background-color:red;">' . $un['quantity'] . '</td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>