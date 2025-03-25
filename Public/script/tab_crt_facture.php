<?php
require_once("../../Models/Admin/N2TEXT.php");
$conv = new ConvertNumberToText();
$pers = $personnes->select($op->party_code);
$pers2 = $users->select($op->user_id);
$staff = $users->getStaffId($op->tar_id);
$liv = $livraisons->select($un['op_id']);
$vente = $ventes->select($un['op_id']);
$cust = $customers->select($op->party_code);
$pos = $store->getPOS($op->pos_id);
?>

<link rel="stylesheet" href="../../assets/print_c/style.css">
<link rel="stylesheet" href="../../assets/css/paper.css">
<div id="facture<?php echo $un['op_id']; ?>" class="ticket" style="width: 200mm;
          height: 287mm;
          margin: 0;
          padding: 0; 
          border: 2px solid black;
          box-sizing:content-box;">
    <div class="card-header bg-light" style="float: left;margin-left:20px">
        <!-- <span><img src="img/logo.png" width="150" style="float:left; margin: 5px;"></span> -->
        <span> <img src="assets/img/costic/costic-logo-216x62.png" width="110px" alt="logo"></span>
        <?php
        echo $cfg['rpt_header'];
        ?>
        <h4> Type Facture : <?php if ($op->is_paid == 0) echo "Dette";
                            elseif ($op->is_paid == 1) echo "Cash";
                            else echo "Proformat"; ?><br></h4>
    </div>
    <div style="float: right; margin-top: 25px;margin-right:90px">
        <br>
        <h4 style="font-size: 12px;">
            N° Fact : #000<?php echo $vente->idvente; ?> <br>
            Date : <?php echo $op->create_date; ?><br>
            Par : <?php echo $pers2->noms; ?>
        </h4>
        <h3 style="font-size: 13px; font-weight: bold;">
            Client : <?php echo $cust->customer_name; ?><br>
            Contact : <?php echo $cust->customer_num; ?><br>
            Agent: <b style="font-size: 15px;"><?= $staff->noms ?></b>
        </h3>

    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered table-striped table-condensed display table-sm tabx" border="1" width="100%" style="font-size: 10px;">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Qté</th>
                        <th>PHTVA</th>
                        <th>PT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($un['op_id'])) {
                        $datas2 = $details->select_all($un['op_id']);
                        $ptg = 0;
                        $tot_ass = 0;
                        $pt = 0;
                        $tva = 0;
                        $ttva = 0;
                        $phtva = 0;
                        $pttc = 0;
                        $tot = 0;
                        $tot_tm = 0;
                        foreach ($datas2 as $val) {
                            $op = $operations->getOperationId($val['op_id']);
                            // $tar->select($vente2->getAssId());
                            //  $pers2 = $users->select($value['user_id']);
                            $prod = $products->getProductId($val['product_id']);

                            $amount = $val['amount'];
                            $pt = $val['amount'] * $val['quantity'];
                            $pttc += $pt;

                            echo '<tr><td >' . $prod->product_name . '</td><td align="right">' . $val['quantity'] . '</td><td align="right">' . number_format($val['amount'], 0, ',', ' ') . '</td><td align="right">' . number_format($pt, 0, ',', ' ') . 'FC</td></tr>';
                        }
                        echo '</tbody><tfoot>';
                        echo '<tr><th>Total</th><th>-</th><th>-</th><th style="text-align:right">' .  number_format($pttc, 0, ',', ' ')  . '</th></tr>';
                        echo '</tfoot>';
                    }

                    ?>
            </table>

            <?php
            $v = number_format($pttc, 0, ',', ' ');
            $c = $conv->Convert($v);
            ?>
            <p align="right" style="font-weight:bold; font-size: 12px;"> <?php echo $c; ?>&nbsp;</p>

            <p align="center" style="font-weight:bold; font-size: 10px;">Etablie par <?= $pers2->noms ?>, le <?= date('Y-m-d') ?></p>

            <p align="center" style="font-weight:bold; font-size: 9px;"><b>Merci et à bientôt</b></p>

            <p align="center" style="font-weight:bold; font-size: 8px;"><i>La marchandise vendue n'est ni reprise ni échangée</i></p>
        </div>
    </div>

</div>