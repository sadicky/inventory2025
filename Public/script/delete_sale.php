<?php
@session_start();

require_once '../../Models/Admin/product.class.php';
require_once '../../Models/Admin/detOperation.class.php';
require_once '../../Models/Admin/operation.class.php';
require_once '../../Models/Admin/stock.class.php';
require_once '../../Models/Admin/vente.class.php';
$products = new Product();
$details = new DetOperation();
$stocks = new Stock();
$operations = new Operation();
$ventes = new Vente();

$op = $operations->getOperationId($_SESSION['op_vente_id']);
$vente = $ventes->select($_SESSION['op_vente_id']);
$m_vente = 0;

$det = $details->getDetail($_POST["det_id"]);

$posId = $op->pos_id;
$prodId = $det->product_id;
$lot = $det->lot;
$prod = $products->getProductId($det->product_id);
if (isset($_POST["det_id"])) {

  $stock = $stocks->select_by_prod($prodId, $posId); 
  $qt = $stock->quantity + $det->quantity;
  $m_vente = $det->quantity * $det->amount;

  if ($details->delete($_POST["det_id"])) {
    // $stocks->update_qt($stock->stock_id, $qt); 
    echo 'Détail vente annulé';

    $m_vente = $vente->amount - $m_vente;

    $ventes->update($_SESSION['op_vente_id'], $m_vente);
  } else {
    echo 'Echec opération ';
  }
} else {
  echo " pas Id";
}
