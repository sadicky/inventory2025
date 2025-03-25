 <!-- Add Room-->
 <div class="modal fade" tabindex="-1" role="dialog" id="transferer">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
             <div class="modal-body modal-body-md">
                 <h5 class="modal-title">Transferer</h5>
                 <form class="mt-2" id="formulaire-payer" method="post">
                     <div class="row g-gs">

                         <div class="col-md-6">
                             <label class="form-label">Bank&nbsp;Montant=><span id="resultat"></span></label>
                             <div class="form-control-wrap">
                                 <select class="form-select js-select2" id="mois" name="mois">
                                     <option value="Janvier">Janvier</option>
                                     <option value="Fevrier">Fevrier</option>
                                     <option value="Mars">Mars</option>
                                     <option value="Avril">Avril</option>
                                     <option value="Mai">Mai</option>
                                     <option value="Juin">Juin</option>
                                     <option value="Juillet">Juillet</option>
                                     <option value="Aout">Aout</option>
                                     <option value="Septembre">Septembre</option>
                                     <option value="Octobre">Octobre</option>
                                     <option value="Novembre">Novembre</option>
                                     <option value="Decembre">Decembre</option>
                                 </select>
                             </div>
                         </div>

                         <div class="col-md-6">
                             <label class="form-label">Dispo</label>
                             <input type="text" class="form-control" id="dispo" readonly value="0 ">
                         </div>

                         <div class="col-md-6">
                             <label class="form-label">Somme</label>
                             <input type="text" name="somme" class="form-control" id="somme" value="0 ">
                         </div>

                         <div class="form-group">
                             <button type="submit" class='btn btn-info btn-md' name="save" title='Modification'>
                                 <span class='icon ni ni-edit'></span>
                             </button>
                         </div>
                     </div><!-- .modal-body -->
                 </form>
             </div><!-- .modal-content -->
         </div><!-- .modal-dialog -->
     </div><!-- .modal -->
 </div>