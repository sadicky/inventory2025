<?php
require_once("../../Models/Admin/N2TEXT.php");
$conv = new ConvertNumberToText();
$all = $ventes->select($_SESSION['op_vente_id']);
// var_dump($all);
?>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<h5 class="box-title m-b-0">Facture</h5>
<hr>
<div id="facture" class="ms-panel">
    <div class="ms-panel-header bg-light" style="float: left;">
        <span> <img src="assets/img/costic/costic-logo-216x62.png" width="110px" alt="logo"></span>
        <?php
        echo $cfg['rpt_header'];
        ?>
    </div>
    <div style="float: right; margin-top: 5px;margin-right:90px">
        <br>
        <h4>

        </h4>
        <h4 style="font-size: 12px;">
            N° Fact : #000<?php echo $all->idvente; ?> <br>
            Date : <?php echo $op->create_date; ?><br>
            Par : <?php echo $_SESSION['nom']; ?>
        </h4>

        <h3 style="font-size: 13px; font-weight: bold;">
            Client : <?php echo $cust->customer_name; ?><br>
            Contact : <?php echo $cust->customer_num; ?>
        </h3>

    </div>
    <?php
    $pos = $stores->getPOS($op->pos_id);
    $cust = $customers->selectId($op->party_code);
    $bens = $ben->select($op->ben_id);
    ?>
    <div class="ms-panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed" width="100%" border="1" style="font-size: 10px;">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Qté</th>
                        <th>PU</th>
                        <th>PT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['op_vente_id'])) {
                        $datas2 = $details->select_all($_SESSION['op_vente_id']);
                        // var_dump($datas2);
                        $cnt = 1;
                        $ptg = 0;
                        $tot_ass = 0;
                        $pt = 0;
                        $tva = 0;
                        $ttva = 0;
                        $phtva = 0;
                        $pttc = 0;
                        $tot = 0;
                        $tot_tm = 0;
                        foreach ($datas2 as $un) {
                            $op = $operations->getOperationId($un['op_id']);
                            $tar = $tarifs->select($all->ass_id);
                            $prod = $products->getProductId($un['product_id']);
                            $amount = $un['amount'];
                            $pt = $un['amount'] * $un['quantity'];
                            $pt_tm = $amount * $un['quantity'];

                            $pttc += $pt;
                            $tot_tm += $pt_tm;

                            echo '<tr><td >' . $prod->product_name . '</td><td align="right">' . $un['quantity'] . '</td><td align="right">' . number_format($un['amount'], 0, ',', ' ') . ' </td><td align="right">' . number_format($pt, 0, ',', ' ') . ' </td></tr>';
                            $cnt += 1;
                        }
                        echo '</tbody><tfoot>';
                        echo '<tr><th>Total</th><th>-</th><th>-</th><th style="text-align:right" >' . number_format($pttc, 0, ',', ' ') . ' </th></tr>';
                        echo '</tfoot>';
                    }

                    ?>
            </table>
            <?php
            $c = $conv->Convert($pttc);
            // echo "<p>Nous disons" . $c . "</p>"; 
            ?>
            <p align="right" style="font-weight:bold; font-size: 12px;"> <?php echo $c; ?>&nbsp;</p>

            <p align="center" style="font-weight:bold; font-size: 10px;">Etablie par <?= $_SESSION['noms'] ?>, le <?= date('Y-m-d') ?></p>

            <p align="center" style="font-weight:bold; font-size: 9px;"><b>Merci et à bientôt</b></p>

            <p align="center" style="font-weight:bold; font-size: 8px;"><i>La marchandise vendue n'est ni reprise ni échangée</i></p>
        </div>
    </div>
</div>