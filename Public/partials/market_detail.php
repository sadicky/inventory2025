<?php

require_once("../../Models/Admin/N2TEXT.php");
$conv = new ConvertNumberToText();

if (isset($_SESSION['op_vente_id'])) {
    $op = $operations->getOperationId($_SESSION['op_vente_id']);
    $vente = $ventes->select($_SESSION['op_vente_id']);
    $cust = $customers->select($op->party_code);
    $staff = $users->getStaffId($op->tar_id);

    $st = $stores->getStoreId($_SESSION['pos']);
    $store = $stores->getPOS($_SESSION['pos']);
?>

    <div class="ms-panel">
        <div class="ms-panel-header header-mini">
            <div class="d-flex justify-content-between">
                <h4><?php if ($_GET['id'] == 0) echo 'FACTURE VENTE DETTE';
                    if ($_GET['id'] == 1) echo 'FACTURE VENTE CASH';
                    if ($_GET['id'] == 2) echo 'FACTURE PROFORMAT'; ?></h4>
                <!-- <h6></h6> -->
            </div>
            <hr>
        </div>
        <div class="ms-panel-body">
            <div id="facture">
                <!-- Invoice To -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="invoice-address">
                            <img src="assets/img/costic/costic-logo-216x62.png" width="110px" alt="logo">
                            <?php echo $cfg['rpt_header']; ?>
                            <h5>Branche: <?= $store->store ?></h5>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <p>client: <b style="font-size: 15px;"><?= $cust->customer_name ?></b></p>
                        <!-- <p>Agent: <b style="font-size: 15px;"><?= $staff->noms ?></b></p> -->
                    </div>
                </div>
                <!-- Invoice Table -->
                <form id="add_sales" method="POST" class="form">
                    <input type="hidden" id="cust_id" name="cust_id" value="<?= $cust->customer_id ?>" />
                    <div class="ms-invoice-table table-responsive mt-5">
                        <table class="table text-right thead-light">
                            <thead>
                                <tr class="text-capitalize">
                                    <th class="text-left">Produit</th>
                                    <th class="text-left">Qté</th>
                                    <th class="text-left">PV</th>
                                    <th class="text-right">PHTVA</th>
                                    <th>-</th>
                                    <th>-</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['op_vente_id'])) {
                                    $datas2 = $details->select_all($_SESSION['op_vente_id']);
                                    $pt = 0;
                                    $tva = 0;
                                    $ttva = 0;
                                    $phtva = 0;
                                    $pttc = 0;
                                    $tot = 0;
                                    $tot_tm = 0;
                                    foreach ($datas2 as $un) {
                                        $op = $operations->getOperationId($un['op_id']);
                                        $prod = $products->getProductId($un['product_id']);

                                        $amount = $un['amount'];
                                        $pt = $un['amount'] * $un['quantity'];
                                        $pttc += $pt;

                                        echo '<tr><td class="text-left"><input type="hidden" id="product_id" name="product_id" value="' . $prod->product_id . '"/>' . $prod->product_name . '</td><td class="text-left"><input type="hidden" id="qty" name="qty" value="' . $un['quantity'] . '"/>' . $un['quantity'] . '</td><td class="text-left">' . number_format($un['amount'], 0, ',', ' ') . '</td><td class="text-right">' . number_format($pt, 0, ',', ' ') . '</td>';

                                        echo '<td><a href="javascript:void(0)" class="fetch_inv_op" name="update" id="' . $un["details_id"] . '" data-id="' . $un["details_id"] . '"><i class="fa fa-edit"></i></a></td>';

                                        echo '<td><a href="javascript:void(0)" class="del_det_market" name="delete" data-id="' . $un["details_id"] . '" id="' . $un["details_id"] . '"><i class="fa fa-times"></i></a></td>';
                                    }
                                    echo '</tr></tbody><tfoot>';
                                    echo '<tr><th>Total</th><th>-</th><th>-</th><th class="text-right">' . number_format($pttc, 0, ',', ' ') . ' </th><th>-</th><th>-</th></tr>';
                                    echo '</tfoot>';
                                }

                                ?>
                        </table>

                        <?php
                        // echo $pttc ;
                        $v = number_format($pttc, 0, ',', ' ');
                        $c = $conv->Convert($v);
                        ?>
                        <p align="left" style="font-weight:bold; font-size: 14px;"><i> <?php echo @$c; ?>&nbsp;</i></p>

                        <p align="left" style="font-weight:bold; font-size: 10px;">Etablie par <?= $_SESSION['noms'] ?>, le <?= date('d/m/Y H:i') ?></p>

                        <p align="left" style="font-weight:bold; font-size: 9px;"><b>Merci et à bientôt</b></p>

                        <p align="left" style="font-weight:bold; font-size: 8px;"><i>La marchandise vendue n'est ni reprise ni échangée</i></p>
                    </div>
            </div>
            <div class="invoice-buttons text-left">
                <!-- <a href="javascript:void(0)" id="print_facture" class="btn btn-danger btn-sm mr-2"><i class="fa fa-print"></i> Sauvegarder</a> -->
                <button type="submit" class="btn btn-sm btn-success add_sale_market" id="<?= $_GET['id'] ?>" style="margin-right:2px;"><i class="fa fa-check-circle"></i> Cloturer</button>
            </div>
            </form>
            <div class="invoice-buttons text-right">
                <a href="javascript:void(0)" class="btn btn-dark btn-sm new_sale_market" id="end_sale_market" data-id="<?php echo $_SESSION['op_vente_id']; ?>"><i class="fa fa-times"></i> Annuler / <i class="fa fa-check-circle"></i> Nouveau</a>
            </div>
        </div>
    </div>
<?php
}
?>

<div style="padding-top: 20px;"></div>