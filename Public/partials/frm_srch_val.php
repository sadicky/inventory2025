
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

$achats = new Achat();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$details = new detOperation();
$journals = new Journal();
$operations = new Operation();
$products = new Product();
$periodes = new Periode();
$stores = new POS();
$categories = new Category();
$users = new User();
// $autres = new AutreFrais();
$trans = new Transactions();
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();
$conf = new Config();
$customers = new Customer();
$ventes = new Vente();
$stocks = new Stock();
include '../partials/N2TEXT.php'; 
$categorie = $categories->getCategories();
// var_dump($categorie);
$pos = $stores->getStores();
?>
<input type="hidden" name="is_sale" id="is_sale" value="Tous">
<div class="ms-panel card-info" style="margin:20px">
    <div class="ms-panel-header bg-light">Valorisations du Stock</div>
    <div >
        <div class="ms-panel-body" style="border: 1px solid gary;">
            <form id="form_srch_valorisation" method="post" autocomplete="off">
                <div class="form-body">
                    <div class="form-row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Category</label>
                                <select class="custom-select" id="cat_id" name="cat_id">
                                    <option value="">Tous</option>
                                    <?php
                                    foreach ($categorie as $value) {
                                        echo '<option value="'.$value->category_id.'">'.$value->category_name.'</option>';
                                        
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
                                    foreach ($pos as $value) {
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
                        
                        <div class="col-md-1" >
                        <label class="control-label">&nbsp;</label>
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

<section class="" id="tab_situ_val">

</section>
