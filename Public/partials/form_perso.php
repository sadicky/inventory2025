<?php
session_start();
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/branches.class.php");
require_once("../../Models/Admin/personne.class.php");
require_once("../../Models/Admin/store.class.php");
$store = new POS();
$users = new User();
$personnes = new Personne();
$branches = new Branches();

if (!empty($_GET['id'])) {
    $pers = $personnes->select($_GET['id']);
    $user = $users->getStaffId($_GET['id']);
    // var_dump($user);
}
if ($_SESSION['role'] == 1) {
    // $datas = $users->getStaff();
    $datas = $branches->getBranches();
    // $stores = $store->getStorePrincipal();
    // $caisse = $caisses->getCaisses();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBranchePOS($st->branche_id);
    // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
    $datas = $branches->getBrancheId($st->branche_id);
}
?>
<div class="ms-panel" style="margin: 10px 50px 10px 50px;">
    <div class="ms-panel-header bg-light">
        <h3>Personnel</h3>
    </div>
    <div class="ms-panel-body">
        <form id="form_perso" method="post" autocomplete="false">
            <div class="form-body">

                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nom & Prénom</label>
                            <input type="text" id="nom" name="nom_ut" class="form-control" value="<?php if (!empty($_GET['id'])) echo $user->noms; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Sexe</label>
                            <?php
                            $sexe = array('Homme', 'Femme');
                            ?>
                            <select class="custom-select" name="sexe_ut" id="genre">
                                <?php
                                foreach ($sexe as $e) {
                                    if (!empty($_GET['id']) and $e == $user->sexe)
                                        echo '<option value="' . $e . '" selected>' . $e . '</option>';

                                    echo '<option value="' . $e . '">' . $e . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Branche</label>
                            <select class="custom-select" name="pos_id" id="pos_id" required>
                                <?php if ($_SESSION['role'] == 1): ?><option value="">Choisir</option><?php endif ?>
                                <?php
                                if (!empty($_GET['id']))
                                    echo '<option selected value="' . $user->branche_id . '">' . $user->branche . '</option>';
                                foreach ($datas as $un) {
                                    echo '<option value="' . $un->branche_id . '">' . $un->branche . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Fonction</label>
                            <input type="text" id="fonction" name="fonction" class="form-control" value="<?php if (!empty($_GET['id'])) echo $user->role; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Contact</label>
                            <input type="text" id="tel" name="tel" value="<?php if (!empty($_GET['id'])) echo $user->tel; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Adresse</label>
                            <textarea id="adresse" name="adresse" class="form-control"><?php if (!empty($_GET['id'])) echo $user->adresse; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Pseudo</label>
                            <input type="text" id="pseudo" name="pseudo_ut" value="<?php if (!empty($_GET['id'])) echo $user->username; ?>" class="form-control" required>
                            <span id="availability"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Mot de passe</label>
                            <input type="password" id="mp" name="mp_ut" value="" class="form-control" <?php if (empty($_GET['id'])) echo 'required'; ?>>
                            <span id="availability_pswd"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Confirmer</label>
                            <input type="password" id="conf" name="conf_ut" class="form-control"
                                value="" <?php if (empty($_GET['id'])) echo 'required'; ?>>
                            <span id="availability_conf"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?php
                if (!empty($_GET['id'])) {
                ?>
                    <input type="hidden" name="operation" id="operation" value="Edit" />
                    <input type="hidden" name="personne_id" id="person_id" value="<?php echo $_GET['id']; ?>" />
                    <input id="Enregistrer" type="submit" class="btn btn-success" name="Enregistrer" value="Modifier" />
                <?php
                } else {
                ?>
                    <input type="hidden" name="operation" id="operation" value="Add" />
                    <input id="Enregistrer" type="submit" class="btn btn-success" name="Enregistrer" value="Enregistrer" />
                <?php
                }
                ?>

                <input id="tel_ut" type="hidden" name="tel_ut" value="-" />
                <input id="email_ut" type="hidden" name="email_ut" value="-" />



            </div>
        </form>
        <div id="last_inserted"></div>
    </div>
</div>

<div style="padding-top: 20px;"></div>