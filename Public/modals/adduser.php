 <!-- Add Room-->
 <div class="modal fade" tabindex="-1" role="dialog" id="add-user">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
             <div class="modal-body modal-body-md">
                 <h5 class="modal-title">Ajouter un nouvel utilisateur</h5>
                 <form action="#" class="mt-2" id="formulaire">
                     <div class="row g-gs">
                         <!--col-->
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="form-label" for="bed-no-add">Username</label>
                                 <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="form-label" for="bed-no-add">Noms Complets</label>
                                 <input type="text" class="form-control" name="noms" id="noms" placeholder="Noms Complets">
                             </div>
                         </div>
                         <!--col-->
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="form-label">Role</label>
                                 <div class="form-control-wrap">
                                     <select class="form-select js-select2" data-search="on" id="role" name="role">
                                         <option value="">Select Role</option>
                                         <option value="admin">Admin</option>
                                         <option value="caissier">Caissier</option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                         <!--col-->
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="form-label" for="bed-no-add">Password</label>
                                 <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
                             </div>
                         </div>
                         <!--col-->
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="form-label" for="bed-no-add">Confirmer le Password</label>
                                 <input type="password" class="form-control" id="cpwd" name="cpwd" placeholder="Confirm Password">
                             </div>
                         </div>

                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="form-label" for="bed-no-add">E-mail</label>
                                 <input type="email" class="form-control" name="email" id="email" placeholder="E-mail">
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="form-label" for="bed-no-add">Numero de Téléphone</label>
                                 <input type="tel" class="form-control" name="tel" id="tel" placeholder="Noms Complets">
                             </div>
                         </div>
                         <!--col-->
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="form-label">Ville</label>
                                 <div class="form-control-wrap">
                                     <select class="form-select js-select2" data-search="on" id="city" name="city">
                                         <option value="">Select ville</option>
                                         <?php foreach ($cities as $f) { ?>
                                             <option value='<?= $f->city_id ?>'><?= $f->city ?> (<?= $f->pays ?>)</option>
                                         <?php } ?>
                                     </select>
                                 </div>
                             </div>
                         </div>

                         <!--col-->
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="form-label" for="bed-no-add">Adresse</label>
                                 <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse">
                             </div>
                         </div>
                         <!--col-->
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="form-label">Portefeuille</label>
                                 <div class="form-control-wrap">
                                     <select class="form-select js-select2" data-search="on" id="bank" name="bank">
                                         <option value="">Select ville</option>
                                         <?php foreach ($banks as $f) { ?>
                                             <option value='<?= $f->bank_id ?>'><?= $f->bank ?></option>
                                         <?php } ?>
                                     </select>
                                 </div>
                             </div>
                         </div>
                         <!--col-->
                         <div class="col-md-12">
                             <div class="form-group">
                                 <button class="btn btn-primary btn-block" type="submit" data-bs-dismiss="modal">Sauvegarder</button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div><!-- .modal-body -->
         </div><!-- .modal-content -->
     </div><!-- .modal-dialog -->
 </div><!-- .modal -->