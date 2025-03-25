<?php
session_start();
require_once('../../Models/Admin/supplier.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/achat.class.php');
$supplier = new Supplier();       
$products = new Product();     
$operations = new Operation();   
$users = new User(); 
$achats = new Achat();

if(!empty($_GET['from_d'])) $from_d=$_GET['from_d']; else $from_d=date('Y-m-01');
if(!empty($_GET['to_d'])) $to_d=$_GET['to_d']; else $to_d=date('Y-m-d');

// $pers->select($_GET['id']);

?>
<hr>
<div class="card card-block">
  <div class="card-header bg-light"><h3>Historique d'achats</h3></div>
  <div class="card-wrapper">
    <div class="card-body">
<form method="post" id="frm_srch_achat_tiers">
    <div class="row">
        <div class="col-md-4">
            <label class="control-label">Du</label>
            <input type="date" name="from_d" id="from_d" class="form-control" value="<?php echo $from_d ?>">
        </div>
        <div class="col-md-4">
            <label class="control-label">Au</label>
            <input type="date" name="to_d" id="to_d" class="form-control" value="<?php echo $to_d; ?>">
        </div>

        <div class="col-md-2">
            <br>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
<h3 class="m-3" style="text-align: center; font-weight: bold; font-size: 14px;">Achats Du <?php echo $from_d;?> Au <?php echo $to_d;?></h3>
<div class="table-responsive">
    <table class="table table-bordered table-sm tab">
        <thead>
            <tr>
                <th>No</th><th>Date</th><th>Fournisseur</th><th style="width:150px;">Produit</th><th>Mont</th>
            </tr>
        </thead>

        <tbody>
            <?php

            $datas=$operations->select_all_by_period_tiers('Approvisionnement',$_GET['id'],$from_d,$to_d);
            $tot=0;
            foreach ($datas as $key => $value) {
                $users->getUser($value->party_code);
                $achats->getAchat($value->op_id);

                $tot +=$operations->select_sum_op($value->op_id);

                echo '<tr><td>'.$achats->getNumAchat().'</td>
				<td><a href="javascript:void(0)" class="row_edit_appro_hist" style="cursor:pointer" data-id="'.$value['op_id'].'">'.$value['create_date'].'</a></td><td>'.$pers->getNomComplet().'</td><td>';

                echo '<ul>';
                $datas2=$operations->getDetailOperation($value->op_id);
                foreach ($datas2 as $un2) {
                    $products->getProductId($un2['product_id']);
                    echo '<li><b>'.$un2['quantity'].'</b> - '.$products->getProdName().'</li>';
                }
                if($operations->nb_op($value['op_id'])==0) echo '<a href="javascript:void(0)" class="del_op_appro" data-id="'.$value['op_id'].'" id="'.$value['op_id'].'"><i class="fa fa-times text-danger"></i></a>';
                echo '</td><td align="right">'.number_format($operations->select_sum_op($value['op_id'])).'</td></tr>';
            }
            ?>
        </tbody>
        <tfoot>
            <tr><th>-</th><th>Total</th><th>-</th><th>-</th><th style="text-align: right"><?php echo number_format($tot) ?></th></tr>
        </tfoot>
    </table>
</div>
</div>
</div>
</div>