<?php
@session_start();
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/stock.class.php');
$details = new detOperation();
$categories = new Category();
$stores = new POS();
$products = new Product();
$periodes = new Periode();
$stocks = new Stock();
$operations = new Operation();

$per = $periodes->getPeriode($_POST['id_per']);
$pos = $stores->getPOS($_POST['pos_id']);

if (!empty($_POST['pos_id'])) {
?>
  <div class="white-box">
    <h3 class="box-title m-b-0">Stock : <?php echo $pos->store . ' (' . $pos->type . ')'; ?> - FICHE D'INVENTAIRE DU <?php echo $per->debut; ?></h3>

    <div class="table-responsive">
      <!-- <p><a href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Détail</a></p> -->
      <form method="post" id="form_det_inv" autocomplete="off">
        <div class="row m-1 pb-1" style="border: 1px gray solid; border-radius: 5px">
          <div class="col-md-4">
            <label class="control-label">Produit</label>
            <input type="text" id="autocomplete_art" name="content_lib_prod" class="form-control" value="" required>
            <input type="hidden" name="prod_id" id="prod_id" value="" />
          </div>
          <div class="col-md-3">
            <label class="control-label">Qt</label>
            <input type="text" name="qt" id="qt" class="form-control number-separator">
          </div>
          <div class="col-md-2">
            <br>
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
            <input type="hidden" name="op_id" id="op_id" value="<?= $_SESSION['op_inv_id'] ?>">
            <input type="hidden" name="det_id" id="det_id" value="">
            <input type="hidden" name="operation" id="operation_inv" value="Add">
          </div>
        </div>
      </form>
      <table class="table table-striped table-bordered table-hover" id="data-table">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Qt</th>
            <th>Prix</th>
            <th>-</th>
            <th>-</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $datas = $details->select_all_by_type('Inventaire', $_POST['id_per'], $_POST['pos_id']);
          $tot = 0;
          foreach ($datas as $un) {

            //$qt_stk=$stock->qt_stock_lot($_POST['pos_id'],$_POST['pack_id'],$un['prod_id'],$un['date_exp'],'9');
            if ($un['quantity'] >= 0) {
              $prod = $products->getProductId($un['prod_id']);
              $cat = $categories->getCategoryId($prod->category_id);
              $tot += $un['quantity'] * $un['amount'];

              echo '<tr><td>' . $prod->product_name . '</td>
          <td class="edit_qt_inv" contenteditable="truex" id="' . $un['details_id'] . '" data-id="quantity">' . number_format($un['quantity']) . '</td>';

              echo '<td class="edit_qt_inv" contenteditable="truex" id="' . $un['details_id'] . '" data-id="amount">' . number_format($un['amount']) . '</td>';
              //echo '<td>'.number_format($un['quantity']*$un['amount']).'</td>';
              echo '<td>
          <button class="btn btn-sm btn-warning btn-circle fetch_inv_op" id="' . $un['details_id'] . '" data-id="' . $un['details_id'] . '"><i class="fa fa-edit"></i></button></td><td>

          <button class="btn btn-sm btn-danger btn-circle del_det_inv" id="' . $un['details_id'] . '" data-id="' . $un['details_id'] . '"><i class="fa fa-times"></i></button>

          </td>
          ';

              echo '</tr>';
            }
          }
          ?>
        </tbody>
        <tfoot>
          <!-- <tr>
          <th>Totaux</th><th>-</th><th>-</th><th>-</th><th>-</th><th><?php //echo number_format($tot) 
                                                                      ?></th><th>-</th><th>-</th>
        </tr> -->
        </tfoot>
      </table>
    </div>
  </div>
<?php
}
?>

<script src="assets/js/data-tables.js"></script>