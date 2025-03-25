<?php
session_start();
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/devise.class.php");
require_once("../../Models/Admin/personne.class.php");
require_once("../../Models/Admin/branches.class.php");
require_once("../../Models/Admin/store.class.php");
$users = new User();
$personnes = new Personne();
$devise = new Devise();
$store = new POS();
$branches = new Branches();

if (!empty($_GET['id'])) {
    $pers = $personnes->select($_GET['id']);
    $user = $users->getStaffId($_GET['id']);
    // var_dump($user);
}

if($_SESSION['role']==1){
    $datas = $branches->getBranches();
    // $stores = $store->getStorePrincipal();
    // $caisse = $caisses->getCaisses();
}else{
    $st = $store->getStoreId($_SESSION['pos']);
    // $stores = $store->getBranchePOS($st->branche_id);
    // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
    $datas = $branches->getBrancheId($st->branche_id);
}
// $data = $users->getStaffSalaire();
//  var_dump($user);
?>
<div class="ms-panel" style="margin: 10px 50px 10px 50px;">
    <div class="ms-panel-header bg-light">
        <h3>Paiement de Salaire</h3>
    </div>
    <div class="ms-panel-body">
        <form id="form_paie" method="post" autocomplete="false">
            <div class="row g-gs">
                <table class="table table-condensed table-stripped" id="data-table">
                    <hr>
                    <tbody>
                        <form class="mt-2" id="formulaire-payer" method="post">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Branche</label>
                                <select class="custom-select" name="branche_id" id="branche_id" required>
                                    <option value="">Choisir</option>
                                    <?php
                                    if(!empty($_GET['id'])) {
                                        echo '<option selected value="'.$user->branche_id.'">'.$user->branche.'</option>';
                                    }else{                                        
                                        foreach($datas as $un)
                                        {
                                            echo '<option value="'.$un->branche_id.'">'.$un->branche.'</option>';
    
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <label class="form-label">Mois</label>
                                <div class="form-control-wrap">
                                    <select class="custom-select" id="mois" name="mois">
                                    <option value="<?php if(date('m')-1==0) echo '12'; else echo date('m')-1;?>" ><?php if(date('m')-1==0) echo '12'; else echo date('m')-1;?></option>
                                    <option value="<?=date('m')?>" selected><?=date('m')?></option>
                                    <option value="<?=date('m')+1?>" ><?=date('m')+1?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Année</label>
                                <div class="form-control-wrap">
                                    <select class="custom-select" id="annee" name="annee">
                                    <option value="<?=date('Y')-1?>" ><?=date('Y')-1?></option>
                                    <option value="<?=date('Y')?>" selected><?=date('Y')?></option>
                                    <option value="<?=date('Y')+1?>" ><?=date('Y')+1?></option>
                                    </select>
                                </div>
                            </div>
                            <div id="staff_info"></div>                           
                        </form>
                    </tbody>
                </table>
                <!--col-->
            </div><!-- .modal-body -->
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

                <input id="tel_ut" type="hidden" name="tel_ut" value="-" />
                <input id="email_ut" type="hidden" name="email_ut" value="-" />



            </div>
        </form>
    </div>
</div>

<div style="padding-top: 20px;"></div>