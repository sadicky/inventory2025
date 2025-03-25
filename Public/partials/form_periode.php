<?php
session_start();
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
$details = new detOperation();
$categories = new Category();
$stores = new POS();
$products = new Product();
$periodes = new Periode();


if(!empty($_GET['id']))
{
    $per = $periodes->getPeriode($_GET['id']);
}
?>

<div class="card"  style="margin: 20px;">
    <div class="card-header text-center">
        <strong>Inventaire</strong>
    </div>
    <div class="card-body card-block">
        <div class="row">
            <div class="col-md-3" style="display: none;">
                <form action="javascript:void(0)" id="form_periode" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="row p-2 mb-2" style="border: 1px gray solid; border-radius: 5px;">
                        <div class="col col-md-12">
                            <label class=" form-control-label">Code</label>
                            <input type="text" id="lib" name="lib"  class="form-control" value="<?php //if(!empty($_GET['id'])) echo $per->code_per;?>" required>
                        </div>
                        <div class="col col-md-12">
                            <label class=" form-control-label">Début</label>
                            <input type="date" id="debut" name="debut"  class="form-control" value="<?php //if(!empty($_GET['id'])) echo $per->debut; else echo date('Y-m-d');?>" required>
                        </div>
                        <div class="col col-md-12">
                            <label class=" form-control-label">Encours :</label>
                            <select class="custom-select" name="enc" id="enc">
                                <?php
                                $datas=array('1'=>'Oui',''=>'Non');
                                foreach ($datas as $key => $value) {
                                    if(!empty($_GET['id']) and $value==$per->crt)
                                    {
                                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                    }
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col col-md-12">
                            <br>
                            <input type="hidden" id="idmod" name="idmod" value="<?php  if(!empty($_GET['id'])) { echo $_GET['id'];}?>">
                            <input type="hidden" id="operation" name="operation" value="<?php if(!empty($_GET['id'])) {echo 'Edit';} else { echo 'Add';}?>">
                            <button type="submit" name="enregistrer" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Enregistrer</button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered table-sm table-striped display" style="display: none;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Code</th><th>Debut</th><th>Etat</th><th>-</th><th>-</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $datas=$periodes->select_all();

                        foreach ($datas as $key => $value) {

                            echo '<tr><td>'.$value['code_per'].'</td><td>'.$value['debut'].'</td><td>';
                            if($value['crt']=='1')
                            {
                                echo 'Encours';
                            }
                            else
                            {
                                echo 'Ancienne';
                            }

                            echo '</td><td>';
                            echo '<a href="javascript:void(0)" class="nv_periode" data-id="'.$value['periode_id'].'" data-id="1"><i class="fa fa-edit"></i></a';
                            echo '</td><td>';
                            if(!$periodes->exist_per($value['periode_id']))
                            {
                                echo '<a href="javascript:void(0)" class="btn btn-danger btn-sm trash_stk" id="'.$value['periode_id'].'" data-id="'.$value['periode_id'].'"><i class="fa fa-times"></i></a>';
                            }
                            else
                            {
                                echo '-';
                            }

                            echo '</td></tr>';


                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" style="margin-top:10px;">
                <?php include('../../Public/partials/form_inventaire.php'); ?>
                <hr style="color:blue;" />
                <div class="details_inv">
                
                
                </div>
            </div>
        </div>
    </div>
</div>


<div style="padding-top: 20px;"></div>