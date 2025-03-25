<div class="card" style="margin:25px; margin-bottom:50px;">
  <div class="card-header bg-light">
    <h3>Informations Supplémentaires</h3>
  </div>
  <div class="card-wrapper">
    <div class="card-body">
      <form id="frm_more_customer" method="post" autocomplete="off">
        <div class="form-body">
          <div class="row">

            <div class="col-md-4">
              <label class="control-label">Catégorie de Client</label>
              <select id="cust_cat" name="cust_cat" class="custom-select">
                <!-- <option value="">-- Choisir --</option> -->
                <?php
                $datas = array('Compagnie', 'Particulier', 'Assureur', 'Anonyme');
                foreach ($datas as $key => $value) {
                  if (!empty($_GET['id']) and $value == $cust->customer_cat)
                    echo '<option value="' . $value . '" selected>' . $value . '</option>';
                  else
                    echo '<option value="' . $value . '">' . $value . '</option>';
                }
                ?>

              </select>
            </div>
            <div class="col-md-2">
              <label class="control-label">Assujetit(TVA)</label>
              <select id="cust_tva" name="cust_tva" class="custom-select">
                <?php
                $datas = array('Non', 'Oui');
                foreach ($datas as $key => $value) {
                  if (!empty($_GET['id']) and $key == $cust->customer_tva)
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                  else
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-md-2">
              <label class="control-label">MB</label>
              <input type="number" id="cust_mb" name="cust_mb" class="form-control" value="<?php if (!empty($_GET['id'])) echo $cust->customer_mb; ?>">
            </div>
            <div class="col-md-2">
              <label class="control-label">Réduction</label>
              <input type="number" id="cust_disc" name="cust_disc" class="form-control" value="<?php if (!empty($_GET['id'])) echo $cust->customer_disc; ?>">
            </div>
            <!--  <div class="col-md-5">
                  <label class="control-label">Chèque (Bancaire)</label>
                  <select id="cust_check" name="cust_check" class="custom-select">
                    <?php
                    /*$datas = array('Refusé','Accepté');
                    foreach ($datas as $key => $value) {
                      if(!empty($_GET['id']) and $key==$cust->getCustomerCheck())
                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                      else
                      echo '<option value="'.$key.'">'.$value.'</option>';
                    }*/
                    ?>
                  </select>
                </div> -->
            <div class="col-md-4">
              <br>
              <?php
              if (!empty($_GET['id'])) {
              ?>
                <button id="Enregistrer" type="submit" class="btn btn-success btn-sm" name="Enregistrer"><i class="fa fa-save"></i> Enregistrer</button>
                <input type="hidden" name="personne_id" id="pes=rsonne_id" value="<?php echo $_GET['id']; ?>" />
              <?php
              }

              ?>
              <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="newcustomer"><i class="fa fa-plus"></i> Nouveau</a>
            </div>
          </div>
        </div>
      </form>


    </div>
  </div>
</div>

<div style="padding-top: 20px;"></div>