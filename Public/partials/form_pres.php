<?php
session_start();
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/devise.class.php");
require_once("../../Models/Admin/personne.class.php");
require_once("../../Models/Admin/store.class.php");
$store = new POS();
$users = new User();
$personnes = new Personne();
$devise = new Devise();

if (!empty($_GET['id'])) {
    $pers = $personnes->select($_GET['id']);
    $user = $users->getStaffId($_GET['id']);
    // var_dump($user);
}
// $datas = $branches->getBranches();
if($_SESSION['role']==1){
    $datas = $users->getStaff();
    // $stores = $store->getStorePrincipal();
    // $caisse = $caisses->getCaisses();
}else{
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBranchePOS($st->branche_id);
    // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
    $datas = $users->getStaffBranche($st->branche_id);
}
?>
<div class="ms-panel" style="margin: 10px 50px 10px 50px;">
    <div class="ms-panel-header bg-light">
        <h3>Formulaire de Presence</h3>
    </div>
    <div class="ms-panel-body">
    <form id="form_presences" method="POST">
                <div class="form-group col-md-3">
                    <label for="">Date</label>
                    <input type="date" class="form-control" name="date_presence" value="<?= date('Y-m-d') ?>">
                </div>
                <br>
                
                <table class="table table-bordered tab">
                    <thead>
                        <tr>
                            <th>Eleve</th>
                            <th>Présence</th>
                            <th>Motif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($datas as $eleve):?>
                        <tr>
                           <input type="hidden" id="staff_id" value="<?=$eleve->staff_id?>" name="staff_id[]">
                           <input type="hidden" name="presences[<?= $eleve->staff_id ?>][presence]" value="0">
                            <td><?=$eleve->noms?></td>
                            <td> <input type="checkbox" id="check"  value="1" class="presence-checkbox form-control" name="presences[<?=$eleve->staff_id?>][presence]"> </td>
                            <td> <input type="text"  class="form-control form-sm" placeholder="Motif (si nécessaire)" name="presences[<?= $eleve->staff_id ?>][motif]"> </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <div class="form-actions">
                <?php
                if (!empty($_GET['id'])) {
                ?>
                    <input type="hidden" name="operation" id="operation" value="Edit" />
                    <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $_GET['id']; ?>" />
                    <input id="Enregistrer" type="submit" class="ms-btn btn-success" name="Enregistrer" value="Modifier" />
                <?php
                } else {
                ?>
                    <input type="hidden" name="operation" id="operation" value="Add" />
                    <input id="Enregistrer" type="submit" class="ms-btn btn-primary" name="Enregistrer" value="Enregistrer" />
                <?php
                }
                ?>
            </div>
            </form>
    </div>
</div>

<div style="padding-top: 20px;"></div>