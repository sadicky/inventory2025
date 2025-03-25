<?php
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/store.class.php");
require_once("../../Models/Admin/personne.class.php");
$users = new User();
$personnes = new Personne();
$stores = new POS();

if (!empty($_GET['id'])) {
    $pers = $personnes->select($_GET['id']);
    $user = $users->select_2($_GET['id']);
}
$role = $users->getRoles();
$datas = $stores->getStores();
?>
<div class="ms-panel" style="margin: 10px 50px 10px 50px;">
    <div class="ms-panel-header bg-light">
        <h3>Utilisateurs</h3>
    </div>
    <div class="ms-panel-body">
        <form id="form_utilisateur" method="post" autocomplete="false">
            <div class="form-body">

                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Nom & Prénom</label>
                            <input type="text" id="nom" name="nom_ut" class="form-control" value="<?php if (!empty($_GET['id'])) echo $pers->nom_complet; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Genre</label>
                            <?php
                            $sexe = array('Homme', 'Femme');
                            ?>
                            <select class="form-control select2" name="sexe_ut" id="genre">
                                <?php
                                foreach ($sexe as $e) {
                                    if (!empty($_GET['id']) and $e == $pers->genre)
                                        echo '<option value="' . $e . '" selected>' . $e . '</option>';

                                    echo '<option value="' . $e . '">' . $e . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">POS</label>
                            <select class="custom-select" name="pos_id" id="pos_id" required>
                                <option value="">Choisir</option>
                                <?php
                                foreach ($datas as $un) {
                                    if (!empty($_GET['id']) and $un->store_id == $user->pos_id)
                                        echo '<option value="' . $un->store_id . '" selected>' . $un->store . '(' . $un->type . ')</option>';
                                    echo '<option value="' . $un->store_id . '">' . $un->store . '(' . $un->type . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Role</label>
                            <select class="custom-select" name="type_ut" id="type_user" required>
                                <option value="">--Choisir--</option>
                                <?php
                                foreach ($role as $value) {
                                    echo '<option value="' . $value->role_id . '">' . $value->role . '</option>';
                                }
                                ?>
                            </select>
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