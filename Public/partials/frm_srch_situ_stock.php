<?php
@session_start();
require_once '../../Models/Admin/user.class.php';
require_once '../../Models/Admin/category.class.php';
$pers=new User();
$cat=new Category();
?>
<div class="form-row">
<div class="col-md-3">
        <div class="form-group">
            <label class="control-label">Stock</label>
            <select class="form-control" id="situ_stock_pos" name="pos" required>
            <option value="">Choisir</option>
                <?php
                  $datas=$pers->select_all_role('pos');
                       foreach ($datas as $value) {
                     /*if ($value['personne_id']==$pos) {
                            echo '<option value="'.$value['personne_id'].'" selected>'.$value['nom_complet'].'</option>';
                        }
                        else
                        {*/
                      echo '<option value="'.$value['personne_id'].'">'.$value['nom_complet'].'</option>';
                    //}
                }
            ?>
            <!-- <option value="tous">Tous</option> -->
        </select>

        </div>
    </div>
  <div class="col-md-3">
        <div class="form-group">
            <label class="control-label">Categorie</label>
            <select class="form-control" id="situ_cat" name="situ_cat" required>
            <option value="">TOUS</option>
                <?php
                  $datas=$cat->select_all_type('Bar_Resto');
                       foreach ($datas as $value) {

                      if($value['is_stock']=='Oui')
                      {
                      echo '<option value="'.$value['category_id'].'">'.$value['category_name'].'</option>';
                      }
                }
            ?>
            <!-- <option value="tous">Tous</option> -->
        </select>

        </div>
    </div>
</div>
<hr>
<div id="situation_stock">
</div>
