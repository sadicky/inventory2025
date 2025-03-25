<div class="card">
  <div class="card-header">
    <h5>Informations Générales (*Champs obligatoire)</h5>
  </div>
  <div class="card-wrapper">
    <div class="card-body">
      <form id="form_supplier" method="post">
        <div class="row">
          <div class="col-md-6">
            <label class="control-label">Nom Complet (Raison Sociale)*</label>
            <input type="text" id="nom" name="nom" class="form-control" required
              value="<?php if (@$view->supplier_id) echo $view->supplier_name;
                      else echo ""; ?>">
          </div>
          <div class="col-md-6">
            <label class="control-label">Identification Nationale</label>
            <input type="text" id="nif" name="nif" class="form-control" value="<?= @$view->sup_nif ?>">
          </div>
          <div class="col-md-4">
            <label class="control-label">Tél</label>
            <input type="number" id="tel" name="tel" class="form-control" value="<?= @$view->sup_contact ?>">
          </div>
          <div class="col-md-4">
            <label class="control-label">Adresse</label>
            <input type="text" id="adresse" name="adresse" class="form-control" value="<?= @$view->sup_adresse ?>">
          </div>
          <div class="col-md-4">
            <br>
            <button id="Enregistrer" type="submit" class="btn btn-success" name="Enregistrer"><i class="fa fa-save"></i> Enregistrer</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<div style="padding-top: 20px;"></div>