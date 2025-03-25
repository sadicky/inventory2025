<?php
@session_start();
require_once("../../Models/Admin/category.class.php");
require_once("../../Models/Admin/product.class.php");
require_once("../../Models/Admin/stock.class.php");

$cat = new Category();
$products = new Product();
$stock = new Stock();

$posId = $_SESSION['pos'];
if ($_POST['d_max'] <= 3) {
  $d_max = $_POST['d_max'] * 30;
  $d_min = ($_POST['d_max'] - 15) * 30;
} else {
  $d_max = $_POST['d_max'] * 30;
  $d_min = ($_POST['d_max'] - 3) * 30;
}
 
$datas = $stock->select_all_exp_prod_stk($d_min, $d_max, $posId);
?><div class="card" style="margin:25px; margin-bottom:50px;">

  <div class="card-header bg-light">
    <h3>Situation du Stock En peremption moins de <?php echo $_POST['d_max']; ?> mois</h3>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover" id="tab">
        <thead>
          <tr>
            <th>Produits</th>
            <th>Cond</th>
            <th>Qté</th>
            <th>Date Fab</th>
            <th>Date Exp.</th>
            <th>Jours restants</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($datas as $un) {
            $prod = $products->getProductId($un['product_id']);?>
            <tr>
              <td><?=$prod->product_name?></td>
              <td><?=$prod->unt_mes ?></td>
              <td><?=$un['quantity']?></td>
              <td><?=$un['date_fab']?></td>
              <td><?=$un['date_exp']?></td>
               <th style="text-align:right"><?php if($un['r_day']<0) echo "<span class='text-danger'>".$un['r_day']."</span>";else  echo "<span class='text-primary'>".$un['r_day']."</span>". '</th>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>