<?php

require_once('../../Models/Admin/category.class.php');
$categories = new Category();

$title = "Categories";

$data = $categories->getCategories();

?>

<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
        </ol>
    </nav>

    <div id="message"></div>
    <div class="ms-panel" style="margin: 10px 50px 10px 50px; padding-bottom:100px;">

        <div class="ms-panel-header">
            <h6>Categorie des Produits | <a href="javascript:void(0)" id="getproducts"><i class="fa fa-plus"></i> Nouveau produit</a></h6>
        </div>
        <div class="ms-panel-body">
            <form method="post" id="form_category" class="needs-validation" novalidate>
                <div class="form-body">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Libellé</label>
                                <input type="text" id="category_name" name="category_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Par Défaut</label>
                                <select class="custom-select" name="status" id="status">
                                    <?php
                                    $datas = array('0' => 'Non', '1' => 'Oui');
                                    foreach ($datas as $key => $value) {
                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="hidden" name="is_sale" id="is_sale" value="Oui" />
                                <label class="control-label">Catégorie Parent</label>
                                <select name="cat_parent" id="cat_parent" class="custom-select" data-live-search="true" data-style="btn-dark" style="border:1px solid gray">
                                    <option value="">Choisir Catégorie</option>
                                    <?php foreach ($data as $d): ?>
                                        <option value="<?= $d->category_id ?>"><?= $d->category_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">&nbsp;</label>
                            <button type="submit" class="btn btn-sm btn-success"> <span class="text-white fa fa-save"></span> Enregistrer</button>

                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-sm display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Categorie</th>
                            <th>Par défaut</th>
                            <th>Parent</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $un) : $cat = $categories->getCategoryId($un->category_parent); ?>
                            <tr>
                                <td><?= $un->category_name ?></td>
                                <td><?= $un->statut ?></td>
                                <td><?= @$cat->category_name ?></td>
                                <td> <button id="<?= $un->category_id ?>" data-id="<?= $un->category_id ?>"><i class="text-warning fa fa-edit"></i></button></td>
                                <td>
                                    <?php
                                    if (!$categories->getCategoryId($un->category_id)): ?>
                                        <button class='btn btn-sm btn-danger btn-circle trash_art' id='<?= $un->category_id ?>' data-id='1'><i class="fa fa-times"></i></button>
                                    <?php else : ?>
                                        <b>-</b>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="padding-top: 20px;"></div>
</div>

<script src="assets/js/data-tables.js"></script>