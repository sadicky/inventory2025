
<?php
@session_start();

require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/commande.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/journal.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/supplier.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/config.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/customer.class.php');

$cat = new Category();
$products = new Product();
$stock = new Stock();
$pos = new POS();
$store = new POS();
// $pack=new Package();
$pr = new Tarif();
$tarif = new Tarif();
$det = new DetOperation();

$operations = new Operation();
$user = new User();
$cust = new Customer();
$periodes = new Periode();

$datas = $periodes->select_all();
// $store = $pos->getStores();
if($_SESSION['role']==1){
    $stores = $store->getStores();
    // $caisse = $caisses->getCaisses();
}else{
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBranchePOS($st->branche_id);
    // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}
// $store = $pos->select_status('Oui');
?>
<input type="hidden" name="is_sale" id="is_sale" value="Tous">
<div class="ms-panel card-info" >
    <div class="ms-panel-header bg-light">Synthèse de mouvement du stock</div>
    <div >
        <div class="ms-panel-body">
            <form id="frm_search_rap_syn" method="post" autocomplete="off">
                <div class="form-body">
                    <div class="form-row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Periode</label>
                                <select class="custom-select" id="id_per" name="id_per" required>
                                    <option value="">Choisir</option>
                                    <?php
                                    foreach ($datas as $value) {
                                        if ($value['periode_id']==$_SESSION['periode']) {
                                            echo '<option value="'.$value['periode_id'].'" selected>'.$value['debut'].'</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="'.$value['periode_id'].'">'.$value['debut'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">POS</label>
                                <select class="custom-select" id="pos_id" name="pos_id" required>
                                    <option value="">Choisir</option>
                                    <?php
                                    foreach ($stores as $value) {
                                        if ($value->store_id==$_SESSION['pos']) {
                                            echo '<option value="'.$value->store_id.'" selected>'.$value->type.'('.$value->store.')</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="'.$value->store_id.'" selected>'.$value->type.'('.$value->store.')</option>';
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Du : </label>
                                <input type="date" id="date_from" name="date_from" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Au : </label>
                                <input type="date" id="date_to" name="date_to" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-1" >
                        <label class="control-label">&nbsp; </label>
                                <br/>
                                <button id="action" data-id="Add" type="submit" class="ms-btn-icon btn-success" name="search"> <i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<section class="" id="tab_rap_syn">

</section>
