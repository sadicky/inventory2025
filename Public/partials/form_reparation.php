<?php
session_start();
require_once('../../Models/Admin/autresfrais.class.php');
$branches = new AutreFrais();
// var_dump($_GET['id']);
if (!empty($_GET['id'])) {
    $user = $branches->getReparation_encours_by_branche($_GET['id']);
    // var_dump($_GET['id']);
}

?>
<div class="ms-panel" style="margin: 10px 20px 0px 20px;">
    <div class="ms-panel-header bg-light">
        <h3>Ajouter une réparation</h3>
    </div>
    <div class="ms-panel-body">

        <form method="post" id="formulaire_reparation" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <b><label>Client : </label> <span class="text-danger"></span></b>
                        <input type="hidden" name="branche_id" id="branche_id" value="<?= $_GET['id'] ?>" class='form-control'>
                        <input type="text" placeholder="Nom du Client" name="client" id="client" class='form-control' required>
                    </div>
                    <div class="form-group">
                        <b><label>Montant : </label> <span class="text-danger"></span></b>
                        <input type="number" placeholder="Montant" name="montant" id="montant" class='form-control' required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <b><label>Adresse : </label></b>
                        <input type="text" placeholder="Adresse du client" name="adresse" id="adresse" class='form-control'>
                    </div>

                    <div class="form-group">
                        <b><label>Motif de Réparation: </label></b>
                        <textarea name="motif" id="motif" class='form-control' placeholder="Motif d'entree"> </textarea>
                    </div>


                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <b><label>Téléphone : </label></b>
                        <input type="text" class="form-control" placeholder="Numero de téléphone" name="tel" id="tel">
                    </div>

                    <div class="form-group">
                        <b><label>Date : </label> <span class="text-danger">*</span></b>
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>
                </div>

            </div>
            <b><label>&nbsp; </label></b><br>
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-plus fa-fw"></i> Valider</button>

        </form>
    </div>
</div>

<div style="padding-top: 20px;"></div>