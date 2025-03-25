<div class="card card-info">
    <div class="card-header">
        <?php
        if (isset($_SESSION['op_vente_id'])) {
            // $acc->select($op->party_code); 
        ?>
            <span style="display: none;"><?php include('../../Public/partials/tab_facture.php'); ?></span>
            <span style="display: none;"><?php //include('../../Public/script/tab_bon_ass.php');  ?></span>
            <span style="display: none;"><?php //include('../../Public/script/tab_proformat.php'); ?></span>

            <!-- <a href="javascript:void(0)" id="print_facture" class="btn btn-danger btn-sm"><i class="fa fa-print"></i> Facture</a> -->
            <!-- <a href="javascript:void(0)" class="btn btn-info btn-sm new_sale btn-sm"><i class="fa fa-plus"></i> Ajouter</a> -->

            <!-- <a href="javascript:void(0)" id="print_bon_proformat" class="btn btn-danger btn-sm mr-2"><i class="fa fa-print"></i> Proformat</a> -->

            <a href="javascript:void(0)" id="print_facture" class="btn btn-danger btn-sm mr-2"><i class="fa fa-print"></i> Imprimer</a>

            <?php
            // if (@$vente->send_state == 15) { ?>
                <!-- <a href="javascript:void(0)" class="btn btn-primary btn-sm end_sale" id="end_sale" data-id="<?php echo $_SESSION['op_vente_id']; ?>"><i class="fa fa-check"></i> Terminer</a> -->
            <?php //} ?>

            <?php

            $op = $operations->getOperationId($_SESSION['op_vente_id']);
            $cust = $customers->selectId($op->party_code);
            $branche = $stores->getPOS($op->pos_id);

            $acc = $accounts->select($op->party_code);
            $bq = $caisses->select_status('1', $branche->branche_id);
            $credit = $transactions->select_sum_cred_2($op->party_code, $bq->caisse_id);
            $pers  = $personnes->select($op->party_code);

            $vente = $ventes->select($_SESSION['op_vente_id']); ?>


        <?php
        }
        ?>
    </div>
    <div class="card-body">
        <?php
        if (isset($_SESSION['op_vente_id'])) { ?>
            <!-- <hr> -->
            <?php //include('../../Public/partials/form_red.php'); ?>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Qté</th>
                            <th>PU</th>
                            <th>PT</th>
                            <th>-</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $datas2 = $details->select_all($_SESSION['op_vente_id']);
                        $ptg = 0;
                        $pt = 0;
                        $tva = 0;
                        $ttva = 0;
                        $phtva = 0;
                        $pttc = 0;
                        $tot = 0;
                        $tot_perc = 0;
                        foreach ($datas2 as $un) {
                            $op = $operations->getOperationId($un['op_id']);

                            $tar = $tarifs->select(@$vente->ass_id);
                            $prod = $products->getProductId($un['product_id']);
                            $amount = $un['amount'];
                            $pt = $un['quantity'] * $amount;
                            $ptg += $pt;

                            echo '<tr><td >' . $prod->product_name . '</td><td align="right">' . $un['quantity'] . '</td><td align="right">' . $amount. '</td><td align="right">' .$pt. '</td>';
                            echo '<td>';

                            if ($change == true)
                                echo '<a href="javascript:void(0)" class="fetch_inv_op" name="update" id="' . $un["details_id"] . '" data-id="' . $un["details_id"] . '"><i class="fa fa-edit"></i></a>';

                            echo '</td><td>';
                            if ( $change == true)
                                echo '<a href="javascript:void(0)" class="del_det_sale" name="delete" data-id="' . $un["details_id"] . '" id="' . $un["details_id"] . '"><i class="fa fa-times"></i></a>';

                            echo '</td></tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="card-footer">
        <?php
        if (isset($_SESSION['op_vente_id'])) {
            $ch_sell = $details->select_sum_op_0($_SESSION['op_vente_id']);
            $ch_paid = number_format($ch_sell,2,'.',' ');

            // var_dump($ch_paid);
        ?>
            <form>
       
                <!-- <div class="form-row">
                    <div class="col-md-6">
                <label class="control-label" style="margin-right:2px;">Réductions(Montant)</label>
                <input type="number" id="val_red" name="val_red" class="form-control" value="0" required>
                </div>
                </div><br> -->
                <div class="form-row">
                    <!-- <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Total Général</label>
                            <div class="input_container">
                                <input type="text" id="ch_paid" name="ch_paid" class="form-control" value="<?php echo  $ch_paid; ?>" readonly>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Reçu</label>
                            <div class="input_container">
                                <input type="text" id="ch_rec" name="ch_rec" class="form-control" value="">
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Total Général</label>
                            <div class="input_container">
                                <input type="text" id="ch_back" name="ch_back" class="form-control" value="<?php echo  $ch_paid; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <button id="1" class="end_sale btn btn-md btn-success" style="margin-right:2px;"><i class="fa fa-check-circle"></i> Enregistrer</button>
            <a href="javascript:void(0)" class="btn btn-dark btn-md end_sale" id="end_sale" data-id="<?php echo $_SESSION['op_vente_id']; ?>"> Annuler</a>
            <!-- <button id="3" class="end_sale btn btn-sm btn-primary"><i class="fa fa-times-circle"></i>  Facture Proformat</button>
            <button id="2" class="end_sale btn btn-sm btn-danger" style="margin-right:2px;" ><i class="fa fa-print"></i>Credit</button> -->

        <?php
        } else {
            include('../../Public/partials/tab_no_send_fact_0.php');
        ?>
            <input type="text" name="srch_bill" id="autocomplete_bill" placeholder="Factures antécédantes" class="form-control">
        <?php
        }
        ?>
    </div>
</div>