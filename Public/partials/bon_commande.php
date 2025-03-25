<?php

if (isset($_SESSION['op_cmd_id'])) {
    $datas2 = $operations->getDetailOperation($_SESSION['op_cmd_id']);
    $datas = $operations->getOperationId($_SESSION['op_cmd_id']);
?>
    <div id="rapport">
        <table class="table table-bordered table-striped table-condensed display" cellspacing="0" width="100%" border="1">
            <thead>
                <tr>
                    <th colspan="5">
                        <?php // include('../entete.php'); ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="5">
                        Bon de commande N°000 <?php echo $achats->getAchat($_SESSION['op_cmd_id'])->num_achat; ?><br />
                        Date : <?php echo $datas->create_date; ?>
                    </th>
                </tr>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $tot = 0;
                foreach ($datas2 as $un) {
                    $d = $products->getProductId($un->product_id);
                    // var_dump($prod);die();
                    echo '<tr><td >' . $d->product_name. '</td><td>' . number_format($un->quantity,0,',','') . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
}
?>

<div style="padding-top: 20px;"></div>