
<div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModal">

  <!-- Modal content -->
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 style="text-align: center">Ajouter un client</h3>
        <span class="close text-danger">&times;</span>
      </div>
      <div class="form-body" style="padding:5px;margin-bottom:2px;margin:0">
        <form id="form_client" method="post">
          <div class="row">
            <div class="col-md-4">
              <label class="control-label">NIF(RCCM)</label>
              <input type="number" id="cust_num" name="cust_num" class="form-control">
              <span id="check_message"></span>
            </div>
            <div class="col-md-6">
              <label class="control-label">Nom Complet (Raison Sociale)*</label>
              <input type="text" id="nom" name="nom" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="control-label">Tél</label>
              <input type="number" id="tel" name="tel" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="control-label">E-mail</label>
              <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="control-label">Adresse</label>
              <input type="text" id="adresse" name="adresse" class="form-control">
            </div>
            <div class="col-md-8">
              <br>
                <input type="hidden" name="operation" id="operation" value="Add" />
                           <button id="Enregistrer" type="submit" class="btn btn-success btn-sm" name="Enregistrer"><i style="color:white;" class="fa fa-save"></i> Enregistrer</button>
              <!-- <a href="javascript:void(0)" class="btn btn-dark btn-sm" id="newcustomer"><i class="fa fa-plus"></i> Nouveau</a> -->
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>