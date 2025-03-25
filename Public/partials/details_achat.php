<?php
if (isset($_SESSION['op_appro_id'])) { ?>
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-striped table-condensed display table-sm tab">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produit</th>
                    <th>Unité</th>
                    <th>Qt</th>
                    <th>Sup</th>
                    <th>Mod</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $datas2 = $details->select_all($_SESSION['op_appro_id']);
                // var_dump($datas2);
                $tot = 0;
                $totF = $autres->select_sum_op($_SESSION['op_appro_id']);

                $tot += $totF;
                $i = 1;
                foreach ($datas2 as $un) {

                    $d = $products->getProductId($un['product_id']);

                    $tot +=  $un['quantity'];
                    echo '<tr><td>' . $i . '</td><td >' . $d->details . '</td>';

                    echo '<td>' . $d->unt_mes . '</td><td>' . $un['quantity'] . '</td>';

                    if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)
                        echo '<td><button class=" del_det_appro" name="delete" data-id="' . $un["details_id"] . '" id="' . $un["details_id"] . '"><i class="fa fa-times"></i></button></td><td><button class="fetch_inv_op" name="update" id="' . $un["details_id"] . '" data-id="' . $un["details_id"] . '"><i class="fa fa-edit"></i></button></td></tr>';
                    else echo '<td>-</td>';
                    $i++;
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Totaux</th>
                    <th>-</th>
                    <th>-</th>
                    <th style="text-align:left"><?php echo number_format($tot, 0, ' ', '.'); ?></th>
                    <th>-</th>
                    <th>-</th>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
<?php
}
?>

<div style="padding-top: 20px;"></div>