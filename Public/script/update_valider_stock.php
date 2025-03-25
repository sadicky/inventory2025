<?php
@session_start();
require_once("../../Models/Admin/detOperation.class.php");
require_once("../../Models/Admin/operation.class.php");
require_once("../../Models/Admin/vente.class.php");
require_once("../../Models/Admin/stock.class.php");
$details = new detOperation(); 
$op = new Operation();
$vente = new Vente();
$stocks = new Stock();
$operations = $op->getOperationId($_POST['op_id']);
$det = $details->select_one_det_op($_POST['op_id']);

$posId = $operations->pos_id;

if ($operations->state == 0) {

    $op->update_state($_POST["op_id"],1,1);

    if($operations->op_type != 'Requisition') {
    foreach ($det as $d){
        $prodId = $d->product_id;
        $quantity = $d->quantity;
        
        $exist = $stocks->existstock_by_prod($prodId, $posId);
        
        if (!$exist) {
            $last_stk = $stocks->insert($prodId,$quantity,$posId);
        } else {
            
            $st = $stocks->select_by_prod($prodId, $posId);
            $qt_stk = $st->quantity - $quantity; 
            $last_stk = $stocks->update_qt($st->stock_id, $qt_stk);
        }
    }
} else {
        foreach ($det as $d){
            $prodId = $d->product_id;
            $quantity = $d->quantity;
            
            $exist = $stocks->existstock_by_prod($prodId, $posId);
            
            if (!$exist) {
                $last_stk = $stocks->insert($prodId,$quantity,$posId);
            } else {
                
                $st = $stocks->select_by_prod($prodId, $posId);
                $qt_stk = $st->quantity + $quantity; 
                $last_stk = $stocks->update_qt($st->stock_id, $qt_stk);
            }
        }
    }
}

$msg = '<div class="alert alert-success" role="alert">
<i class="flaticon-tick-inside-circle"></i> <strong>Reussi!</strong> Validation avec success!.
</div>';
echo $msg;
