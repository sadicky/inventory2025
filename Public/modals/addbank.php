 <!-- Add Room-->
 <div class="modal fade" tabindex="-1" role="dialog" id="add-bank">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
             <div class="modal-body modal-body-md">
                 <h5 class="modal-title">Ajouter un nouvel Portefeuille</h5>
                 <form method="post" id="formulaire_bank">
                     <div class="row">
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <b><label>Portefeuille </label></b>
                                 <input type='text' name="bank" placeholder="Nouveau Portefeuille" class="form-control" id="bank" required>
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <b><label>Montant </label></b>
                                 <input type='text' name="montant" placeholder="Montant initial" class="form-control" id="montant">
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <b><label>Dévise </label></b>
                                 <div class="form-control-wrap">
                                     <select class="form-select js-select2" id="devise" name="devise">
                                         <option value="">Select Role</option>
                                         <?php foreach ($devises as $e) : ?>
                                             <option value="<?= $e->devise_id ?>"><?= $e->short ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                 </div>

                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <b><label>Ville </label></b>
                                 <div class="form-control-wrap">
                                     <select class="form-select js-select2" id="city" name="city">
                                         <option value="">Select Ville</option>
                                         <?php foreach ($cities as $e) : ?>
                                             <option value="<?= $e->city_id ?>"><?= $e->city ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                 </div>

                             </div>
                         </div>

                         <div class="col-sm-3">
                             <b><label># </label></b>
                             <button class="btn btn-primary btn-block btn-sm" type="submit"><i class="fa fa-plus fa-fw"></i> Enregistrer </button>
                         </div>

                     </div>
                 </form>
             </div><!-- .modal-body -->
         </div><!-- .modal-content -->
     </div><!-- .modal-dialog -->
 </div><!-- .modal -->