<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
        </ol>
    </nav>
    <div id="message"></div>

    <div class="ms-panel">

        <div class="ms-panel-header">
            <h6>Produits</h6>
        </div>
        <div class="ms-panel-body">
            <form method="post" id="update_product" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="control-label">Catégorie </label>
                        <select required class="custom-select" name="category" id="category">
                            <!-- <option value="<?= $data->category_id ?>" selected><?= $data->category_name ?></option> -->
                            <?php foreach ($categories as $d): ?>
                                <option value="<?= $d->category_id ?>"><?= $d->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="Produits">Produits</label>
                        <input type="text" required class="form-control" value="<?= $data->product_name ?>" name="produit" id="produit">
                        <span id="available_msg"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="branche">Details(Compatibilité)</label>
                        <textarea name="details" id="details" class="form-control"><?= $data->details ?></textarea>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="branche">Cond.</label>
                        <select class="custom-select" name="cond" id="cond">
                            <option value="<?= $data->unt_mes ?>" selected><?= $data->unt_mes ?></option>
                            <?php
                            $datas = array('Pièce', 'Carton');
                            foreach ($datas as $value) {
                                echo '<option value="' . $value . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="branche">Prix d'Achat</label>
                        <input type="number" id="pv" name="pv" class="form-control" value="<?= $data->product_price ?>">
                        <input type="hidden" id="product_id" name="product_id" class="form-control" value="<?= $data->product_id ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="branche">Qt Minimum</label>
                        <input type="number" id="qt_min" name="qt_min" class="form-control" value="<?= $data->qt_min ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm enreg" type="submit"> <span style="color: white;" class="fa fa-save"></span> Enregistrer</button>
                </div>
        </div>
        </form>

    </div>
</div>

</div>