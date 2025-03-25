<?php
require_once('../../Models/Admin/product.class.php');
$product = new Product();
$id = isset($_POST['id']) ? $_POST['id'] : '';
$view = $product->getProductId($id);
var_dump($view);die();
?>
<form id="formulaire_mod_product_price" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="row p-2" style="border: 2px gray solid;">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Produit</label>
                <input type="text" readonly value="<?=$view->product_name?>" class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Branche</label>
                <select name="branche" id="branche" class="custom-select">
                    <option readonly value="<?=$view->branche_id?>" selected><?=$view->branche?></option>
                   </select>
            </div>
        </div>
        <div class="col col-md-3">
            <label class=" form-control-label">Prix</label>
            <input type="number" id="price" name="price" class="form-control" value="<?= $view->price ?>" required>
        </div>
        <div class="col col-md-2">
            <input type="hidden" id="product_id" name="product_id" value="<?= $view->product_id ?>">
            <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i> Modifier
            </button>
        </div>
    </div>
</form>