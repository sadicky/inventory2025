<?php
session_start();
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/store.class.php");
require_once("../../Models/Admin/personne.class.php");

$users = new User();
$personnes = new Personne();
$stores = new POS();

$datas = $personnes->select_all_role('users');
$role = $users->getRoleId($_SESSION['role']);
// var_dump($datas);
?>

<div class="card" style="margin:25px; margin-bottom:50px;">

    <div class="card-header bg-light">
        <h3>Profiles </h3>
    </div>
    <div class="card-wrapper">
        <div class="card-body">

            <div id="messages"> </div>
            <div class="row">
                <div class="col-md-8">
                    <?php
                    if ($_SESSION['id']) { ?>
                        <form method="POST" class="form" id="formprofile">
                            <input type="hidden" name="id" class="form-control" value="<?= $_SESSION['id'] ?>">
                            <div class="form-group">
                                <label>Noms</label>
                                <input type="text" name="nom_ut" id="nom" class="form-control" value="<?= $_SESSION['noms'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Nom d'utilisateur(Login username)</label>
                                <input type="text" name="pseudo_ut" id="pseudo" class="form-control" value="<?= $_SESSION['username'] ?>">
                                <span id="availability"></span>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <input readonly class="form-control" value="<?= $role->role; ?>">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-info submitb">Valider</button>
                            </div>
                        </form>
                    <?php  }
                    ?>
                </div>
                <div class="col-md-4">
                    <form method="post" id="formprof">
                        <div class="form-group">
                            <label>Nouveau mot de passe</label>
                            <input type="hidden" name="id" class="form-control" value="<?= $_SESSION['id'] ?>">
                            <input type="text" name="mp_ut" id="mp" class="form-control" required>
                            <span id="availability_pswd"></span>
                        </div>
                        <div class="form-group">
                            <label>Confirmer mot de passe</label>
                            <input type="text" name="conf_ut" id="conf" class="form-control" required>
                            <span id="availability_conf"></span>
                        </div>
                        <button type="submit" id="Enregistrer" class="btn btn-danger pwdBtn">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="padding-top: 20px;"></div>
<script src="assets/js/data-tables.js"></script>