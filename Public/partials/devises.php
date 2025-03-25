<?php
require_once("../../Models/Admin/devise.class.php");
$devise = new Devise();

if (!empty($_GET['id'])) {
    $dat = $devise->getDeviseId($_GET['id']);
    // var_dump($dat);
}
//  var_dump($user);
$data = $devise->getDevises();
?>
<div class="card" style="margin:25px; margin-bottom:50px;">

    <div class="card-header bg-light">
        <h3>Devises </h3>
    </div>
    <div class="card-wrapper">
        <div class="card-body">
            <div class="row">
                <!-- /.panel-heading -->
                <div class="col-lg-4 my-2">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <form method="post" id="formulaire_devise">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b><label>Dévise </label></b>
                                            <input type='text' name="devise" value="<?php if (isset($_GET['id'])) echo $dat->devise; ?>" placeholder="Dévise" class="form-control" id="devise">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b><label>Short </label></b>
                                            <input type='text' name="short" value="<?php if (isset($_GET['id'])) echo $dat->short; ?>" placeholder="Short" class="form-control" id="short">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b><label>Taux </label></b>
                                            <input type='text' name="taux" value="<?php if (isset($_GET['id'])) echo $dat->taux; ?>" placeholder="Taux du Jours" class="form-control" id="short">
                                        </div>
                                    </div>

                                    <!-- <div class="col-sm-12 my-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block btn-sm" type="submit"><i class="fa fa-plus fa-fw"></i> Créer</button>
                            </div>
                        </div> -->

                                </div>

                                <div class="form-actions">
                                    <?php
                                    if (!empty($_GET['id'])) {
                                    ?>
                                        <input type="hidden" name="operation" id="operation" value="Edit" />
                                        <input type="hidden" name="devise_id" id="devise_id" value="<?php echo $_GET['id']; ?>" />
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
                </div>
                <div class="col-lg-8 my-2">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <table class="tab table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>Short</th>
                                        <th>Taux</th>
                                        <th>Primary</th>
                                        <th>Supprimer</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $e) : ?>
                                        <tr class="odd gradeX">
                                            <td><?= $e->short ?></td>
                                            <td><?= $e->taux ?></td>
                                            <td><?php
                                                if ($e->statut == '1') echo "<span class='label label-primary'>Dévise de Base</span>";
                                                else echo "<span class='label label-default'>Dévise de Contrepartie</span>";   ?>
                                            </td><?php
                                                    if ($e->statut == '0') : ?>
                                                <td><button type='button' id='<?= $e->devise_id ?>' name='delete' class='ms-btn btn-sm btn-danger delete-devise'></span> <span style="color:white;" class='fa fa-trash'></span> Supprimer?</button></td>

                                                <td class="center">
                                                    <button class='ms-btn btn-info btn-sm btn-block update_devise' id="<?= $e->devise_id ?>" title='Modification'>
                                                        <span class='fa fa-edit' style="color:white;"></span> Modifier
                                                    </button>

                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
                <!-- /.panel -->
            </div>
        </div>
    </div>

    <div style="padding-top: 20px;"></div>