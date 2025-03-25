<div class="table-responsive">
    <h3 align="center">Factures Non encore Cloturées</h3>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Date</th><th>Client</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $datas=$operations->select_all_no_send_0('Vente',$_SESSION['pos']);
            // var_dump($datas);
            $totM=0;
            $jour = $journals->select($_SESSION['jour']);

            foreach ($datas as $value) {
                
            // echo($value['user_id']);
            
                $pers = $customers->selectId($value['party_code']); 

                
                // $branche = $stores->getPOS(@$op->pos_id);
                
                // $acc = $accounts->select($op->party_code);
                // $bq = $caisses->select_status('2',$branche->branche_id);

                // $bq =$caisses->select_id($value['pay_type']);
                if(!$operations->exist_in_vente($value['op_id']) and @$value['user_id']==$_SESSION['id'])
                {
                    echo '<tr>
                    <td>'.$value['create_date'].'</td><td><a href="javascript:void(0)" class="row_edit_sale_hist" style="cursor:pointer" data-id="'.$value['op_id'].'">'.@$pers->customer_name.'</a>';
                    
                    if($details->nb_op($value['op_id'])==0)
                        echo '<a href="javascript:void(0)" class="del_op_sale" data-id="'.$value['op_id'].'" id="'.$value['op_id'].'"><i class="fa fa-times"></i></a>';

                    echo '</td></tr>';
                    //$totM +=$det->select_sum_op($value['op_id']);
                }
            }
            ?>
        </tbody>
</table>
</div>

<!-- <a href="javascript:void(0)" class="btn btn-info btn-sm m-2" id="no_app"><i class="fa fa-trash"></i> Corbeille</a> -->