<form id="form_inventaire" method="post">
  <div class="row">
    <div class="col-md-3">
      <label class="control-label">Periode</label>
      <select name="id_per" id="id_per" class="custom-select" data-live-search="true" data-style="btn-darkx" required>
        <option value="">Choisir Période</option>
        <?php
        $datas=$periodes->select_all();
        foreach ($datas as $key => $value) {
          if($value['id_per']==$_SESSION['periode']) 
          {
            echo '<option value="'.$value['periode_id'].'" selected>'.$value['code_per'].'</option>';
          }
          else
          {
          echo '<option value="'.$value['periode_id'].'">'.$value['code_per'].'</option>';
        }
        }
        ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="control-label">Stock</label>
      <select name="pos_id" id="pos_id" class="custom-select" data-live-search="true" data-style="btn-darkx" required>
        <!-- <option value="">Choisir Pos</option> -->
        <?php
        $datas=$stores->getStores();
        foreach ($datas as $key => $value) {
          if($value->store_id==$_SESSION['pos']) 
          {
            echo '<option value="'.$value->store_id.'" selected>'.$value->store.'('.$value->type.')</option>';
          }
          else
          {
          echo '<option value="'.$value->store_id.'">'.$value->store.'('.$value->type.')</option>';
         }
        }
        ?>
      </select>
    </div>
    <div class="col-md-2">
      <br/>
      <button class="btn btn-primary btn-sm" type="submit">Inventaire</button>
    </div>
  </div>
</form>


<div style="padding-top: 20px;"></div>