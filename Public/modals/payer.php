 <!-- Add Room-->
 <div class="modal fade" tabindex="-1" role="dialog" id="payer">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
             <div class="modal-body modal-body-md">
                 <h5 class="modal-title">Paiement de Salaire</h5>
                 <div class="row g-gs">
                     <table class="table">
                         <thead>
                             <tr class="tb-tnx-head">
                                <th>Noms</th>
                                 <th>Salaire Net</th>
                                 <th>A Payer</th>
                             </tr>
                         </thead>
                         <tbody>
                             <form class="mt-2" id="formulaire-payer" method="post">
                                 <div class="col-md-6">
                                    <label class="form-label">Mois</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2"  id="mois" name="mois" >
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
                                    <label class="form-label">Année</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2"  id="annee" name="annee" >
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                            <option value="2031">2031</option>
                                            <option value="2032">2032</option>
                                            <option value="2033">2033</option>
                                            <option value="2034">2034</option>
                                            <option value="2035">2035</option>
                                            <option value="2036">2036</option>
                                            <option value="2037">2037</option>
                                        </select>
                                    </div>
                                 </div>
                                 <?php 
                                    foreach ($data as $e) : ?>
                                     <tr class="odd gradeX">
                                        <td><?= $e->noms ?></td>
                                         <input type="hidden" name="staff_id[]" id="staff_id" readonly value="<?= $e->staff_id ?>">
                                         <input type="hidden" name="devise[]" id="devise" readonly value="<?= $e->devise_id ?>">
                                         <td>
                                             <div class="form-group">
                                                 <div class="form-text-hint">
                                                     <span class="overline-title"><?= $e->short ?></span>
                                                 </div>
                                                 <input type="text" class="form-control" id="default-05" readonly value="<?= $e->salaire ?> ">
                                             </div>
                                         </td>
                                         <td class="fw-bold">
                                             <div class="form-group">
                                                 <div class="form-text-hint">
                                                     <span class="overline-title"><?= $e->short ?></span>
                                                 </div>
                                                 <input type="text" class="form-control" name="salaire[]" id="salaire" value="<?= $e->salaire ?>">
                                             </div>
                                         </td>
                                     </tr>
                                 <?php endforeach ?>
                                 <tr>
                                     <td>
                                         <div class="form-group">
                                             <button type="submit" class='btn btn-info btn-md' name="save" title='Modification'>
                                                 <span class='icon ni ni-edit'></span>
                                             </button>
                                         </div>
                                     </td>
                                 </tr>
                             </form>
                         </tbody>
                     </table>
                     <!--col-->
                 </div><!-- .modal-body -->
             </div><!-- .modal-content -->
         </div><!-- .modal-dialog -->
     </div><!-- .modal -->
 </div>