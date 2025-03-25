<?php
@session_start();
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/stock.class.php');

$details = new detOperation();
$caisses = new Caisse();
$operations = new Operation();
$products = new Product();
$ventes = new Vente();
$stocks = new Stock();

if (isset($_SESSION['op_vente_id'])) {

    $all = $details->select_all($_SESSION['op_vente_id']);
    $op = $operations->getOperationId($_SESSION['op_vente_id']);
    $posId = $op->pos_id;
    $bq = $caisses->getCaisseId($op->caisse_id);
    $statut = $_POST['status'];

    if ($statut != 2) {
        foreach ($all as $s) {
            $st = $stocks->select_by_prod($s['product_id'], $_SESSION['pos']);
            $qt_stk = $st->quantity - $s['quantity'];
            $b =  $stocks->update_qt($st->stock_id, $qt_stk);
        }
    }
    /*Vente*/
    if (!$operations->exist_in_vente($_SESSION['op_vente_id'])) {
        $last_vente = $ventes->select_last_num($_SESSION['pos']);
        $last_num = ($last_vente + 1);

        $ventes->setAmount($details->select_sum_op($_SESSION['op_vente_id']));
        $ventes->setNumVente($last_num);
        $ventes->setOpId($_SESSION['op_vente_id']);
        $ventes->setIsPaid($op->is_paid);
        $ventes->setSendState('0');
        $ventes->setType($statut);
        $add = $ventes->insert();

    }
} else {
    echo "Aucune Donnee";
}

/* Fin Vente*/
