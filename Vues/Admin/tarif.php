<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
        </ol>
    </nav>
    <div id="message"></div>
    <div id="page-content"></div>
    <div class="ms-panel">
        <div class="ms-panel-header text-center">
            <h5>Tarif par Article : <?= $data->details; ?></h5>
        </div>
        <div class="ms-panel-body">
            <div class="row">
                <div class="col-md-6">
                    <?php if ($_SESSION['role'] == 1): ?>
                        <form id="formulaire_product_price" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row p-2" style="border: 2px gray solid;">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">Branche</label>
                                        <select name="branche" id="branche" class="custom-select" required>
                                            <option value="">-- Choisir --</option>
                                            <option value="all">Pour Tous</option>
                                            <?php foreach ($branches as $value): ?>
                                                <option value="<?= $value->branche_id ?>"><?= $value->branche ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-md-3">
                                    <label class=" form-control-label">Prix</label>
                                    <input type="number" id="price" name="price" class="form-control" value="<?= @$data->product_price ?>" required>
                                </div>
                                <div class="col col-md-2">
                                    <input type="hidden" id="product_id" name="product_id" value="<?= @$data->product_id ?>">

                                    <button type="submit" name="enregistrer" class="btn btn-primary btn-sm"> <i class="fa fa-plus-circle"></i> Enregistrer
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php endif ?>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered table-sm display">
                        <thead>
                            <tr>
                                <th>Branche</th>
                                <?php if ($_SESSION['role'] == 1): ?>
                                    <th>Prix d'Achat</th>
                                <?php endif; ?>
                                <th>Prix de Vente</th>
                                <th>Dernière modification</th>
                        </thead>
                        <tbody>
                            <?php
                            // var_dump($priceData);
                            if ($priceData) {
                                foreach ($priceData as $pr): ?>
                                    <tr>
                                        <td><?= $pr->branche ?></td>
                                        <?php if ($_SESSION['role'] == 1): ?>
                                            <td><?php echo number_format($data->product_price) ?></td>
                                        <?php endif; ?>
                                        <td><?php echo number_format($pr->montant, 0, ',', ' ') ?></td>
                                        <td><?= $pr->price_last_update ?></td>
                                    </tr>
                            <?php
                                endforeach;
                            } else {
                                echo "<b class='text-danger text-center'>Aucun prix pour ce produit</b>";
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>