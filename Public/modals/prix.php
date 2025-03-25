 <!-- Add Room-->
 <div class="modal fade" tabindex="-1" role="dialog" id="edit-prix">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
             <div class="modal-body modal-body-md">
                 <h5 class="modal-title">Modifier les prix</h5>
                 <div class="row g-gs">
                     <table class="table">
                         <thead>
                             <tr class="tb-tnx-head">
                                 <th>Carburant</th>
                                 <th>Prix Actuel / L</th>
                                 <th>Nouveau Prix / L</th>
                             </tr>
                         </thead>
                         <tbody>
                             <form class="mt-2" id="formulaire-prix" method="post">
                                 <?php
                                    foreach ($carburants as $e) : ?>
                                     <tr class="odd gradeX">
                                         <td><?= $e->type ?></td>
                                         <input type="hidden" name="id[]" id="id" readonly value="<?= $e->id_carburant ?>">
                                         <td>
                                             <div class="form-group">
                                                 <input type="text" class="form-control" name="prixa" id="prixa" readonly value="<?= $e->prix ?>">
                                             </div>
                                         </td>
                                         <td class="fw-bold">
                                             <div class="form-group">
                                                 <input type="text" class="form-control" name="prix[]" id="prix" value="<?= $e->prix ?>">
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