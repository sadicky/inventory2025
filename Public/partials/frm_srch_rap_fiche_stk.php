
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

$products = new Product();
// $stock = new Stock();
$pos = new POS();
$store = new POS();
$tarif = new Tarif();

$periodes = new Periode();

if($_SESSION['role']==1){
    $stores = $store->getStores();
    // $caisse = $caisses->getCaisses();
}else{
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBranchePOS($st->branche_id);
    // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}
// $tar= new BeanTarif();
// $pos=new BeanPos();
// $prod=new BeanProducts();
// $per=new BeanPeriode();

// $pos->select_status('Oui');
?>
<input type="hidden" name="is_sale" id="is_sale" value="Tous">
<div class="card card-info" >
    <div class="card-header bg-light">Fiche du stock</div>
    <div >
        <div class="card-body">
            <form id="frm_srch_rap_fiche_stk" method="post" autocomplete="off">
                <div class="form-body">
                    <div class="form-row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Periode</label>
                                <select class="custom-select" id="id_per" name="id_per" required>
                                    <option value="">Choisir</option>
                                    <?php
                                    $datas=$periodes->select_all();
                                    foreach ($datas as $value) {
                                        if ($value['periode_id']==$_SESSION['periode']) {
                                            echo '<option value="'.$value['periode_id'].'" selected>'.$value['code_per'].'</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="'.$value['id_per'].'">'.$value['code_per'].'</option>';
                                        }
                                    }
                                    ?>
                                    <!--  <option value="tous">Tous</option> -->
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">POS</label>
                                <select class="custom-select" id="pos_id" name="pos_id" required>
                                    <option value="">Choisir</option>
                                    <?php
                                    // $datas=$pos->getStores();
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
                        
                        <div class="col-md-3">
                        <label class="control-label">Produits*</label>
                                
                        <input type="text" id="autocomplete_art" name="content_lib_prod" class="form-control" value="" required> 
                                    
                        <input type="hidden" name="prod_id" id="prod_id" value="" />
                              
                        </div>
                        <div class="col-md-2">
                                <label class="control-label">Du : </label>
                                <input type="date" id="date_from" name="date_from" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                        <div class="col-md-2">
                                <label class="control-label">Au : </label>
                                <input type="date" id="date_to" name="date_to" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                        <div class="col-md-1" >
                            <div class="form-group" style="bottom:0;">
                                &nbsp;<br/>
                                <button id="action" data-id="Add" type="submit" class="ms-btn-icon btn-success" name="search"> <span class="fa fa-search text-white"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<section class="" id="tab_rap_fiche_stk">
<!-- <div class="col-lg-12" >
<div class="alert alert-info" style="background-color: white;" >

</div>
</div> -->
</section>
