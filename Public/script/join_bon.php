<?php
@session_start();

require_once '../../Models/Admin/operation.class.php';
require_once '../../Models/Admin/vente.class.php';
require_once '../../Models/Admin/detOperation.class.php';
require_once '../../Models/Admin/livraison.class.php';
$operations = new Operation();
$ventes = new Vente();
$details = new DetOperation();
$livraisons = new Livraison();
// var_dump($_SESSION['op_vente_id']);
//$liv->update_one($_POST['op_id'],'op_id','op_id',$_SESSION['op_vente_id']);

if (isset($_POST['op_id'])) {
    $op = $operations->getOperationId($_POST['op_id']);
    $posId = $op->pos_id;
    $details->update_one($_POST['op_id'], 'op_id', 'det', $_POST['op_id']);
    $details->update_one($_POST['op_id'], 'op_id', 'op_id', $_SESSION['op_vente_id']);
    $ventes->update_one($_SESSION['op_vente_id'], 'op_id', 'amount', $details->select_sum_op($_SESSION['op_vente_id']));
    $livraisons->update_one($_POST['op_id'], 'op_id', 'pro_id', $_SESSION['op_vente_id']);
} else {
    /*Bon de livraison*/

    if (isset($_SESSION['op_vente_id'])) {
        $op = $operations->getOperationId($_SESSION['op_vente_id']);
        $posId = $op->pos_id;
        $last_bon = $livraisons->select_last_num($posId);
        $last_liv = ($last_bon + 1);

        if (!$livraisons->exist_op($_SESSION['op_vente_id'])) {

            $livraisons->insert($last_liv, '0', '-', '-', $_SESSION['op_vente_id']);

            $livraisons->update_one($_SESSION['op_vente_id'], 'op_id', 'product_id', $_SESSION['op_vente_id']);
        }
    } elseif (isset($_SESSION['op_chg_id'])) {
        $op = $operations->getOperationId($_SESSION['op_chg_id']);
        $posId = $op->pos_id;
        $last_bon = $livraisons->select_last_num($posId);
        $last_liv = ($last_bon + 1);
        if (!$livraisons->exist_op($_SESSION['op_chg_id'])) {
            $livraisons->insert($last_liv, '0', '-', '-', $_SESSION['op_chg_id']);

            $livraisons->update_one($_SESSION['op_chg_id'], 'op_id', 'pro_id', $_SESSION['op_chg_id']);
        }
    }
    // fin Bon de livraison	
}
