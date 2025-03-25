<?php
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/devise.class.php");
require_once("../../Models/Admin/personne.class.php");
$users = new User();
$personnes = new Personne();
$devise = new Devise();

if (!empty($_GET['id'])) {
    $pers = $personnes->select($_GET['id']);
    $user = $users->getStaffId($_GET['id']);
    // var_dump($user);
}
// $datas = $branches->getBranches();
$user = $users->getStaff();
//  var_dump($user);
$devises = $devise->getDevises();
?>
<div class="ms-panel" style="margin: 10px 50px 10px 50px;">
    <div class="ms-panel-header bg-light">
        <h3>Salaire</h3>
    </div>
    <div class="ms-panel-body">
        <form id="form_sal" method="post" autocomplete="false">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Staff</label>
                        <div class="form-control-wrap">
                            <select class="custom-select" data-search="on" id="staff" name="staff">
                                <option value="">--Select--</option>
                                <?php foreach ($user as $s): ?>
                                    <option value="<?= $s->staff_id ?>"><?= $s->noms ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--col-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Devise</label>
                        <div class="form-control-wrap">
                            <select class="custom-select" data-search="on" id="devise" name="devise">
                                <option value="">--Select--</option>
                                <?php foreach ($devises as $s): ?>
                                    <option value="<?= $s->devise_id ?>"><?= $s->short ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="bed-no-add">Salaire Basique</label>
                        <input type="text" class="form-control" id="sal" name="sal" placeholder="150$">
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
                    <input id="Enregistrer" type="submit" class="ms-btn btn-primary" name="Enregistrer" value="Enregistrer" />
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