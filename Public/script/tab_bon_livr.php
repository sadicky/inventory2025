<?php
$pers = $user->select($op->party_code);

$pers2 = $user->select($op->user_id);
if(isset($_SESSION['op_bon_id'])) {
    $opId=$_SESSION['op_bon_id']; $livraisons->select($opId);
}
elseif(isset($_SESSION['op_vente_id'])) {$opId=$_SESSION['op_vente_id'];  $livraisons->select_pro($opId);}
elseif(isset($_SESSION['op_chg_id'])) {$opId=$_SESSION['op_chg_id']; $livraisons->select_pro($opId);}
?>

<div id="bon_liv" class="ms-panel" style="width: 200mm; height: 287mm;  margin: 0; padding: 0;  border: 2px solid black;  box-sizing:content-box;">
    <div class="ms-panel-header" style="font-size: 14px; font-weight: bold; text-align: center;">BON DE LIVRAISON</div>
    <div class="ms-panel-body">
        <table width="100%" border="1" class="table table-bordered table-sm" style="font-size: 12px;" >
            <tr>
                <th style="text-align: center;width:35%; border:1px solid black; border-collapse:collapse;" valign="top">
                    <img src="assets/img/costic/costic-logo.png" alt="logo" style="width:70px;">
                    <?php
        echo $cfg['rpt_header'];
        ?>
                 
                </th>
                <th colspan="2" style="text-align: center;width:35%; border:1px solid black;" valign="top">
                    <h4>
                    No Bon de Livraison : <?php echo $livraisons->getLivNum(); ?><br>
                    Date : <?php echo $operations->getCreateDate(); ?><br>
                    Expédié par :  <?php echo $pers2->noms; ?><br>
                    Origine: <?php echo $livraisons->getDest(); ?><br>
                    Destination: <?php echo $livraisons->getDest(); ?><br>
                   
                </th>
            </tr>
        </table>
           
            <table class="table table-bordered table-striped table-sm display my_tab" cellspacing="0" width="100%" style="font-size: 12px;" border="1">
                <thead>
                    <tr>
                        <th>No</th><th>Désignation</th><th>Qté</th><th>Prix</th><th>PT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pthtva=0;
                    $pttvac=0;
                    $ttva=0;
                    $tva=0; 
                    $datas2=$details->select_all($opId);
                    // var_dump($opId);
                    if(count($datas2)==0) $datas2=$details->select_all_2($opId);
                    $i=1;
                    foreach ($datas2 as $un) {
                        $prod = $products->getProductId($un['product_id']);
                        $tx='*';
                        $price=$un['amount'];

                        $pt=$un['quantity']*$price;
                        $ptc=$un['quantity']*$un['amount'];
                        $ttva +=$tva;
                        $pttvac +=$ptc;
                        $pthtva +=$pt;

                        echo '<tr><td>'.$i.'</td><td>'.$prod->product_name;
                       echo '</td><td align="right">'.number_format($un['quantity']).'</td><td align="right">';
                        if($un['amount']>0)
                        echo number_format($un['amount']);
                        else
                            echo '-';
                        echo '</td><td align="right">'.number_format($ptc).'</td>';

                        echo '</tr>';
                        $i++;
                    }
                    
                    echo '<tr><th>-</th><th>Totaux</th><th>-</th><th style="text-align:right">'.number_format($pthtva).'</th><th style="text-align:right">'.number_format($pttvac).'</th></tr>';

                    ?>
                </tbody>
            </table>
            <table class="table table-bordered table-striped table-sm display" cellspacing="0" width="100%" style="font-size: 12px; border: solid black 2px; margin-top: 20px;">
                <tr>
                    
                    <th style="text-align:right;height: 100px;" colspan="2">
                        <h3 style="font-weight: bold;">Pour MARCO PHARMA </h3>
                    </th>
                </tr>
                <tr>
                    <th style="text-align: left; height: 50px;">
                        Réceptionné par  : <p></p><p></p>
                    </th>
                    <th style="text-align: left;">
                        Vérifié par  : <p></p><p></p>
                    </th>
                </tr>
            </table>
            
            
        </div>
    </div>
