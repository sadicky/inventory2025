<div class="card" >
  <div class="card-header bg-light"><h3>Votre Compte</h3></div>
  <div class="card-wrapper">
    <div class="card-body">
          <form id="frm_account_sup" method="post" autocomplete="off">
              <div class="row" >
                <div class="col-md-3">
                  <label class="control-label">Statut</label>
                  <select id="status" name="status" class="custom-select">
                    <?php 
                    $datas = array('Ouvert','Suspendu','Fermé');
                    foreach ($datas as $key => $value) {
                      if(!empty($_GET['id']) and ($key+1)==$acc->getStatus())
                        echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
                      else
                      echo '<option value="'.($key+1).'">'.$value.'</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="control-label">Monnaie</label>
                  <select id="acc_cur" name="acc_cur" class="custom-select">
                    <?php 
                    $datas = array('BIF','US $');
                    foreach ($datas as $key => $value) {
                      if(!empty($_GET['id']) and $value==$acc->getAccCur())
                        echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
                      else
                      echo '<option value="'.($key+1).'">'.$value.'</option>';
                    }
                    ?>
                  </select>
                </div>
                <!-- <div class="col-md-6">
                  <label class="control-label">Balance Courante</label> -->
                  <input type="hidden" id="closing_bal" name="closing_bal" class="form-control" value="<?php if(!empty($_GET['id'])) echo $acc->getClosingBal();?>" readonly>
                <!-- </div> -->
                <!-- <div class="col-md-4">
                  <label class="control-label">Crédit en cours</label> -->
                  <input type="hidden" id="credit" name="credit" class="form-control number-separator" value="0" readonly>
                <!-- </div> -->
                <input type="hidden" name="cred_limit" id="cred_limit" value="0">
                <div class="col-md-2">
                  <br>
                  <?php 
                            if(!empty($_GET['id']))
                            {
                                ?>
                                <button id="Enregistrer" type="submit" class="btn btn-success" name="Enregistrer"><i class="fa fa-save"></i> Enregistrer</button>
                                <input type="hidden" name="personne_id" id="pes=rsonne_id" value="<?php echo $_GET['id'];?>" />
                                <?php
                            }
                            
                            ?>
                </div>
              </div>
            
          </form>
    </div>
  </div>
</div>