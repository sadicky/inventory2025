<?php
if (isset($_SESSION['op_cmd_id'])) { ?>
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-striped table-condensed display table-sm tab">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produit</th>
                    <th>Qt</th>
                    <th>-</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $datas2 = $operations->getDetailOperation($_SESSION['op_cmd_id']);
                $i = 1;
                foreach ($datas2 as $un) {
                    $data = $products->getProductId($un->product_id);
                    echo '<tr><td>' . $i . '</td><td >' . $data->product_name . '</td>';
                    echo '<td>' . number_format($un->quantity) . '</td>';

                    echo '<td><a href="#" class="del_det_cmd" name="delete" data-id="' . $un->details_id . '" id="' . $un->details_id . '"><i class=" text-danger fa fa-times"></i></a></td></tr>';
                    $i++;
                }
                ?>
            </tbody>
            </tbody>
        </table>
    </div>
<?php
}
?>

<div style="padding-top: 20px;"></div>