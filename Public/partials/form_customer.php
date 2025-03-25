<?php
require_once("../../Models/Admin/customer.class.php");
require_once("../../Models/Admin/account.class.php");
require_once("../../Models/Admin/personne.class.php");
require_once("../../Models/Admin/transaction.class.php");
$transactions = new Transactions();
$customers = new Customer();
$personnes = new Personne();
$accounts = new Account();
// $branches = $branches->getBranches();
@$cust = $customers->select($_GET['id']);

@$pers = $personnes->select($_GET['id']);
@$acc = $accounts->select($_GET['id']);
@$cred = $transactions->tot_sum_cred($_GET['id']);

?>
<div class="card" style="margin:25px; margin-bottom:50px;">

  <div id="message"></div>
  <div class="card-header bg-light">
    <h3>Informations Générales (*Champs obligatoire)</h3>
  </div>
  <div class="card-wrapper">
    <div class="card-body">
      <form id="form_client" method="post">
        <div class="row">
          <div class="col-md-4">
            <label class="control-label">NIF(RCCM)</label>
            <input type="number" id="cust_num" name="cust_num" class="form-control" value="<?php if (!empty($_GET['id'])) echo $cust->customer_num; ?>">
            <span id="check_message"></span>
          </div>
          <div class="col-md-4">
            <label class="control-label">Nom Complet (Raison Sociale)*</label>
            <input type="text" id="nom" name="nom" class="form-control" required value="<?php if (!empty($_GET['id'])) echo $pers->nom_complet; ?>">
          </div>
          <div class="col-md-4">
            <label class="control-label">Catégorie de Client</label>
            <select id="cust_cat" name="cust_cat" class="custom-select">
              <?php
              $datas = array('Affilié', 'Anonyme');
              foreach ($datas as $value) {
                if (!empty($value == $cust->customer_cat))
                  echo '<option value="' . $value . '" selected>' . $value . '</option>';
                else
                  echo '<option value="' . $value . '">' . $value . '</option>';
              }
              ?>

            </select>
          </div>
          <div class="col-md-4">
            <label class="control-label">Tél</label>
            <input type="number" id="tel" name="tel" class="form-control" value="<?php if (!empty($_GET['id'])) echo $pers->contact; ?>">
          </div>
          <div class="col-md-4">
            <label class="control-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php if (!empty($_GET['id'])) echo $pers->email; ?>">
          </div>
          <div class="col-md-4">
            <label class="control-label">Adresse</label>
            <input type="text" id="adresse" name="adresse" class="form-control" value="<?php if (!empty($_GET['id'])) echo $pers->adresse; ?>">
          </div>
          <div class="col-md-4">
            <label class="control-label">Limite de Crédit</label>
            <input type="text" id="cred_limit" name="cred_limit" class="form-control number-separator" value="<?php if (!empty($_GET['id'])) echo @$cust->credit_limit; ?>">
          </div>
          <div class="col-md-4">
            <label class="control-label">Crédit en cours</label>
            <input type="text" id="credit" name="credit" class="form-control number-separator" value="<?= @$cred->credit_total ?>" readonly>
          </div>
          <div class="col-md-4">
            <label class="control-label">Statut</label>
            <select id="status" name="status" class="custom-select">
              <?php
              $datas = array('Ouvert', 'Suspendu', 'Fermé');
              foreach ($datas as $key => $value) {
                if (!empty($_GET['id']) and ($key + 1) == @$cust->actif)
                  echo '<option value="' . ($key + 1) . '" selected>' . $value . '</option>';
                else
                  echo '<option value="' . ($key + 1) . '">' . $value . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="col-md-8">
            <br>
            <?php
            if (!empty($_GET['id'])) {
            ?>
              <input type="hidden" name="operation" id="operation" value="Edit" />
              <input type="hidden" name="personne_id" id="personne_id" value="<?php echo $_GET['id']; ?>" />
            <?php
            } else {
            ?>
              <input type="hidden" name="operation" id="operation" value="Add" />
            <?php
            }
            ?>

            <button id="Enregistrer" type="submit" class="btn btn-success btn-sm" name="Enregistrer"><i class="fa fa-save"></i> Enregistrer</button>
            <!-- <a href="javascript:void(0)" class="btn btn-dark btn-sm" id="newcustomer"><i class="fa fa-plus"></i> Nouveau</a> -->
          </div>
        </div>

      </form>
    </div>
  </div>

</div>

<div style="padding-top: 20px;"></div>