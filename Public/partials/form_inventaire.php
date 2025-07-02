<?php
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/supplier.class.php');
require_once('../../Models/Admin/personne.class.php');
$caisses = new Caisse();
$branches = new Branches();
$operations = new Operation();
$details = new detOperation();
$achats = new Achat();
$store = new POS();
$autres = new AutreFrais();
$products = new Product();
$users = new Personne();
$suppliers = new Supplier();

$branches = $branches->getBranches();
$posId = $_SESSION['pos'];
$idPer = $_SESSION['periode'];
$role = $_SESSION['role'];

     // $datas=$stores->getStores(); 
     if ($_SESSION['role'] == 1) {
      $datas = $store->getStorePrincipal();
      // $caisse = $caisses->getCaisses();
  } else {
      $st = $store->getStoreId($_SESSION['pos']);
      $datas = $store->getBrancheStockPOS($st->branche_id);
      // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
  }
?>
<form id="form_inventaire" method="post">
  <div class="row">
    <div class="col-md-3">
      <label class="control-label">Periode</label>
      <select name="id_per" id="id_per" class="custom-select" data-live-search="true" data-style="btn-darkx" required>
        <option value="">Choisir Période</option>
        <?php
        $data=$periodes->select_all();
        foreach ($data as $key => $value) {
          if($value['id_per']==$_SESSION['periode']) 
          {
            echo '<option value="'.$value['periode_id'].'" selected>'.$value['code_per'].'</option>';
          }
          else
          {
          echo '<option value="'.$value['periode_id'].'">'.$value['code_per'].'</option>';
        }
        }
        ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="control-label">Stock</label>
      <select name="pos_id" id="pos_id" class="custom-select" data-live-search="true" data-style="btn-darkx" required>
        <!-- <option value="">Choisir Pos</option> -->
        <?php
   
        foreach ($datas as $key => $value) {
          if($value->store_id==$_SESSION['pos']) 
          {
            echo '<option value="'.$value->store_id.'" selected>'.$value->store.'('.$value->type.')</option>';
          }
          else
          {
          echo '<option value="'.$value->store_id.'">'.$value->store.'('.$value->type.')</option>';
         }
        }
        ?>
      </select>
    </div>
    <div class="col-md-2">
      <br/>
      <button class="btn btn-primary btn-sm" type="submit">Inventaire</button>
    </div>
  </div>
</form>


<div style="padding-top: 20px;"></div>