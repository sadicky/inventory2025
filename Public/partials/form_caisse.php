<?php
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/branches.class.php');
$caisses = new Caisse();
$branches = new Branches();
$branches = $branches->getBranches();
@$caisses = $caisses->getCaisseId($_GET['id']);
?>
<form id="formulaire_compte" method="post" enctype="multipart/form-data" class="form-horizontal">

    <div class="card">
        <div class="card-header text-center">
            <strong>Caisses</strong>
        </div>
        <div class="card-body card-block">

            <div class="row form-group">
                <div class="col col-md-3">
                    <label class=" form-control-label">Libellé</label>
                    <input type="text" id="libelle" name="libelle" class="form-control" value="<?php if (!empty($_GET['id'])) echo $caisses->caisse_name; ?>">
                </div>

                <!-- <div class="col col-md-3">
                    <label class=" form-control-label">Type de Caisse</label>
                    <select type="text" id="type_caisse" name="type_caisse" <?php if (!empty($_GET['id'])) echo 'readonly'; ?> class="custom-select">
                        <?php if (!empty($_GET['id'])): ?>
                            <option value="<?php if (!empty($_GET['id'])) echo 'selected'; ?>"><?= $caisses->caisse_type ?></option>
                        <?php endif; ?>
                        <option value="Banque">Banque</option>
                        <option value="Vente">Vente</option>
                        <option value="Dépense">Dépense</option>
                    </select>
                </div> -->
                <div class="col col-md-3">
                    <label class=" form-control-label">Branche</label>
                    <select type="text" id="branche" name="branche" <?php if (!empty($_GET['id'])) echo 'readonly'; ?> class="custom-select">
                        <?php if (!empty($_GET['id'])): ?>
                            <option value="<?php if (!empty($_GET['id'])) echo 'selected'; ?>"><?= $caisses->branche ?></option>
                        <?php endif; ?>
                        <?php if (empty($_GET['id'])): ?>
                        <option value="all">Pour Tous</option>
                        <?php foreach ($branches as $branche): ?>
                            <option value="<?= $branche->branche_id ?>"><?= $branche->branche ?></option>
                        <?php endforeach ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="col col-md-3">
                    <label class=" form-control-label">Statut</label>
                    <select type="text" id="status" name="status" <?php if (!empty($_GET['id'])) echo 'readonly'; ?> class="custom-select">
                        <?php if (!empty($_GET['id'])): ?>
                            <option value="<?php if (!empty($_GET['id'])) echo 'selected'; ?>"><?php if($caisses->status==0) echo "Suspendu";else echo "Actif"; ?></option>
                        <?php endif; ?>
                        <option value="1">Actif</option>
                        <option value="0">Suspendu</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <br>
                    <input type="hidden" id="caisse_id" name="caisse_id" value="<?php if (!empty($_GET['id'])) {  echo $_GET['id'];} ?>">
                    <input type="hidden" id="operation" name="operation" value="<?php if (!empty($_GET['id'])) { echo 'Edit';  } else {  echo 'Add';  } ?>">
                    <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> Enregistrer </button>
                </div>
            </div>
        </div>
    </div>
</form>

<div style="padding-top: 20px;"></div>