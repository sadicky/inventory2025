<?php

require_once('../../Models/Admin/category.class.php');
$categories = new Category();

$title = "Produits";

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
    <div class="ms-panel" style="margin: 10px 50px 10px 50px;">

        <div class="ms-panel-header">
            <h6>Produits</h6>
        </div>
        <div class="ms-panel-body">
            <form method="post" id="formulaire_product" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="control-label"> <a href="javascript:void(0)" id="getcategories">Catégorie <i class="fa fa-plus"></i></a></label>
                        <select required class="custom-select" name="category" id="category">
                            <?php foreach ($data as $d): ?>
                                <option value="<?= $d->category_id ?>"><?= $d->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="Produits">Produits</label>
                        <input type="text" required class="form-control" name="produit" id="produit">
                        <span id="available_msg"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="branche">Details(Compatibilité)</label>
                        <textarea name="details" id="details" class="form-control"></textarea>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="branche">Conditionnement</label>
                        <select class="custom-select" name="cond" id="cond">
                            <?php
                            $cond = array('Pièce', 'Carton');
                            foreach ($cond as $value) {
                                echo '<option value="' . $value . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="branche">Prix d'Achat</label>
                        <input type="text" id="pa" name="pa" class="form-control">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="branche">Prix de Vente</label>
                        <input type="text" id="pv" name="pv" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-sm enreg" type="submit"> <span style="color: white;" class="fa fa-save"></span> Enregistrer</button>
                    </div>
                </div>
            </form>
            <hr>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3 pb-4">
                    <label>Produit : </label>
                    <input type="text" id="searchProd" placeholder="Votre mot clé ici" class="form-control" />
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-stripped table-bordered table-sm display">
                    <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Produit</th>
                            <th>Details</th>
                            <th>Prix</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody class="res_srch"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="padding-top: 20px;"></div>

</div>

<script src="assets/js/data-tables.js"></script>