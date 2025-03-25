 <!-- Add Room-->
 <div class="modal fade" tabindex="-1" role="dialog" id="add-dep">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
             <div class="modal-body modal-body-md">
                 <h5 class="modal-title">Ajouter une dépense</h5>
                 <form method="post" class="mt-2" id="formulaire-dep">
                     <div class="row">
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <b><label>Dévise : </label> <span class="text-danger">*</span></b>
                                 <select name="devise" id="devise" class='form-select js-select2 devises-change' data-search="on" required>
                                     <option selected value="" disabled>Choisir Devise</option>
                                     <?php foreach ($devises as $f) { ?>
                                         <option value='<?= $f->devise_id ?>'><?= $f->short ?></option>
                                     <?php } ?>
                                 </select>
                                 <input type="hidden" value="<?= date('Y-m-d') ?>" class="form-control" name="date" id="date" required>
                             </div>
                             <div class="form-group">
                                 <b><label>Bénéficiaire : </label> <span class="text-danger"></span></b>
                                 <input type="text" placeholder="Nom du Client" name="client" id="client" class='form-control' required>
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <b><label>Montant : </label> (<span id="resultatdev"></span>)</b>
                                 <input type="number" placeholder="Montant" name="montant" id="montant" class='form-control' required>
                             </div>
                             <div class="form-group">
                                 <b><label>Motif : </label></b>
                                 <input type="text" placeholder="Motif d'entree" name="motif" id="motif" class='form-control'>
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <b><label>Téléphone : </label></b>
                                 <input type="text" class="form-control" placeholder="Numero de téléphone" name="tel" id="tel">
                             </div>
                             <div class="form-group ">
                                 <b><label>&nbsp; </label></b><br>
                                 <button class="btn btn-primary btn-block btn-sm" type="submit"><i class="fa fa-plus fa-fw"></i> Ajouter</button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div><!-- .modal-body -->
         </div><!-- .modal-content -->
     </div><!-- .modal-dialog -->
 </div><!-- .modal -->