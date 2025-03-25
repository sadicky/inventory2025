<?php
$all = $ventes->select($_SESSION['op_vente_id']);
?>
<h5 class="box-title m-b-0">Facture</h5>
<hr>
<div id="bon_liv" class="card">
    <div class="card-header bg-light">
        <?php
        echo $cfg['rpt_header'];
        ?>
    </div>
    <?php

    $pos = $stores->getPOS($op->pos_id);
    $cust = $customers->selectId($op->party_code);
    $bens = $ben->select($op->ben_id);
    ?>
    <div class="card-body">
        <div class="table-responsive">
            <!-- <p align="center" style="font-weight: bold; font-size: 10px;">La Facture a été ajoutée à l'OBR</p> -->

            <h4>Assurance : <?php echo $cust->customer_name; ?></h4>
            <table class="table table-bordered table-striped table-sm display" cellspacing="0" width="100%" border="1" style="font-size: 12px;">
                <tr>
                    <th>Date</th>
                    <th>Service</th>
                    <th>No Carte Affilié</th>
                    <th>Nom Affilié</th>
                    <th>Médicament</th>
                    <th>Qté</th>
                    <th>P.U</th>
                    <th>P.T</th>
                    <th>% T.M</th>
                    <th>Montant TM</th>
                    <th>Montant Ass.</th>
                </tr>
                <tr>
                    <th><?php echo $op->create_date; ?></th>
                    <th><?php echo $cust->customer_serv; ?></th>
                    <th><?php echo $cust->customer_code; ?></th>
                    <th><?php echo $cust->customer_name; ?></th>
                    <th colspan="9"></th>

                </tr>
                <tr>
                    <?php
                    $datas2 = $details->select_all($_SESSION['op_vente_id']);
                    $pttc = 0;
                    $tot_ass = 0;
                    $pt_ass = 0;
                    $tot_tm = 0;
                    foreach ($datas2 as $un) {


                        $amount = round($un['amount'] * ((100 - $un['det']) / 100));
                        $m_tm = $amount * $un['quantity'];
                        $ass_amount = round($un['amount'] * (($un['det']) / 100));
                        $m_ass = $ass_amount * $un['quantity'];
                        $pt = $un['amount'] * $un['quantity'];
                        $pt_tm = $amount * $un['quantity'];
                        $pt_ass = $ass_amount * $un['quantity'];

                        $pttc += $pt;
                        $tot_ass += $pt_ass;
                        $prod = $products->getProductId($un['product_id']);

                        echo '<tr>
        <td colspan="6"></td><td >' . $prod->product_name . '</td><td align="right">' . $un['quantity'] . '</td><td align="right">' . number_format(($un['amount']), 0, '.', ',') . '</td><td align="right">' . number_format($pt, 0, '.', ',') . '</td><td align="right">' . (100 - $un['det']) . '</td><td align="right">' . number_format($m_tm, 0, '.', ',') . '</td><td align="right">' . number_format($pt_ass, 0, '.', ',') . '</td><tr>';
                    }
                    //echo '</tr>';


                    ?>
            </table>
        </div>
    </div>

</div>



<?php
//}
?>