<div class="table-responsive">
    <table class="table table-bordered table-sm tab">
        <thead>
            <tr>
                <th>No Fact</th><th>Date</th><th>Client</th><th>Montant</th><th>Produits</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $datas=$op->select_all_no_send('Vente',$_SESSION['pos']);
            $totM=0;
            $jour->select($_SESSION['jour']);
            foreach ($datas as $key => $value) {
                $pers2->select($value['personne_id']);
                $vente->select($value['op_id']);
                $liv->select($value['op_id']);
                $pers->select($value['party_code']);
                if($vente->getAmount()>0 and $value['personne_id']==$_SESSION['perso_id'] and $jour->getStartDate()==$value['create_date'])
                {
                    echo '<tr  ';
                    if($vente->getSendState()==0) echo 'class="text-danger"';
                    if($vente->getSendState()==2) { echo 'style="color:red;text-decoration:line-through;"';}
                    echo ' >
                    <td><a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="'.$value['op_id'].'"> ';
                    echo $vente->getPlace().'</a></td>
                    <td>'.$value['create_date'].'</td><td>'.$pers->getNomComplet().'</td><td align="right">'.number_format($det->select_sum_op($value['op_id'])).'</td><td><ul>';
                    $dt=$det->select_all($value['op_id']);
                    foreach ($dt as $key => $value2) {
                        $prod->select($value2['prod_id']);
                        echo '<li><b>'.$value2['quantity'].'</b>-'.$prod->getProdName().'</li>';
                    }
                    echo '</ul>';

                   if($det->nb_op($value['op_id'])==0)
                        echo '<a href="javascript:void(0)" class="del_op_sale" data-id="'.$value['op_id'].'" id="'.$value['op_id'].'"><i class="fa fa-times"></i></a>';

                    echo '</td></tr>';
                    //$totM +=$det->select_sum_op($value['op_id']);
                }
            }
            ?>
        </tbody>
</table>
</div>
