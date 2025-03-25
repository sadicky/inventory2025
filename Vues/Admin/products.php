<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
        </ol>
    </nav>
    <?php
    require_once('Models/Admin/product.class.php');
    $products = new Product();
    if (isset($_POST["import"])) {
        $fileName = $_FILES["excel"]["name"];
        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));
        $newFileName = date("Ymd") . "" . date("hms") . "." . $fileExtension;

        $targetDirectory = "assets/importExcelToMySQL/uploads/" . $newFileName;
        move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

        require 'assets/importExcelToMySQL/excelReader/excel_reader2.php';
        require 'assets/importExcelToMySQL/excelReader/SpreadsheetReader.php';

        $reader = new SpreadsheetReader($targetDirectory);
        // echo "<pre>".print_r( $reader )."</pre>";die();
        foreach ($reader as $key => $row) {
            $idc = $row[0];
            $product = $row[1];
            $details = $row[2];
            $cond = 'pièce';
            $qt_min = 5;
            $price = $row[3];
            $pa = 0;

            $add = $products->setProduct($idc, $details, $price, $pa, $product, $cond, $qt_min);
        }
    }

    ?>
    <div id="message"></div>
    <form method="post" class="form-inline" action="" enctype="multipart/form-data">
        <div class="input-group">
            <div class="form-file">
                <input type="file" id="excel" name="excel" class="form-control">
                <button name="import" type="submit" class="btn btn-danger btn-md"><em class="icon ni ni-file-xls"></em> Import</button>
            </div>
        </div>
    </form>

    <div class="ms-panel">

        <div class="ms-panel-header">
            <h6>Produits</h6>
        </div>
        <div class="ms-panel-body">
            <form method="post" id="formulaire_product" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="Produits">Produits</label>
                        <input type="text" required class="form-control" name="produit" id="produit">
                        <span id="available_msg"></span>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="branche">Cond.</label>
                        <select class="custom-select" name="cond" id="cond">
                            <?php
                            $datas = array('Amp', 'Bte', 'Fl', 'Jar', 'Pce', 'Roll', 'Tbe', 'Paire', 'Vial');
                            foreach ($datas as $value) {
                                echo '<option value="' . $value . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="control-label">Catégorie <a href="<?= WEBROOT ?>category"><i class="fa fa-plus"></i></a></label>
                        <select required class="custom-select" name="category" id="category">
                            <?php foreach ($data as $d): ?>
                                <option value="<?= $d->category_id ?>"><?= $d->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="branche">Qt Minimum</label>
                        <input type="number" id="qt_min" name="qt_min" class="form-control" value="<?= 500 ?>">
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
                            <th>#</th>
                            <th>Catégorie</th>
                            <th>Produit</th>
                            <th>Qt Min</th>
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
</div>