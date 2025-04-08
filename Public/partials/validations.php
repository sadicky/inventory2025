<?php
@session_start();
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/detOperation.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/periode.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once "../../Models/Admin/caisse.class.php";
require_once('../../Models/Admin/customer.class.php');
$user = new User();
$details = new detOperation();
$categories = new Category();
$stores = new POS();
$products = new Product();
$periodes = new Periode();
$stocks = new Stock();
$ventes = new Vente();
$customers = new Customer();
$operations = new Operation();
$caisses = new Caisse();

$pos = $_SESSION['pos'];
$pos_id = $stores->getPOS($pos);
$caisse = $caisses->getCaisseBranche($pos_id->branche_id);

$datas = $operations->select_all_facture_no_0($caisse->caisse_id);

?>
<div class="ms-panel" style="margin: 30px;">
  <div class="ms-panel-header">
    <h3 class="box-title m-b-0">Validation des opérations</h3>
  </div>
  <div class="ms-panel-body">
    <div class="table-responsive">
      <table class="table table-bordered table-condensed" id="data-table">
        <thead>
          <tr>
            <th>Op. Id</th>
            <th>Date</th>
            <th>Type</th>
            <th>Branche</th>
            <th>Par</th>
            <th>Valider</th>
            <th>Supprimer</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <?php $totM = 0;
          // print_r($datas);
          foreach ($datas as $value):
            $pers2 = $user->select($value['user_id']);
            $data = $operations->select_all_facture_no_1($value['op_id'], $value['op_type']);
            $pers = $customers->selectId($value['party_code']);
          ?>
            <?php foreach ($data as $d) {

              $st = $stores->getStoreId($d->pos_id);
              // $pers2 = $user->select_2($value['party_code']);
              // $vente = $ventes->select($value['op_id']);
              // $pers = $customers->selectId($value['party_code']);
              // $achat = $achats->getAchat($value['op_id']);
            ?>

              <tr>
                <td><?= $d->op_id ?></td>
                <td><?= $d->create_date ?></td>
                <td><?= $d->op_type ?></td>
                <td><?= $st->branche ?></td>
                <td><?= $pers2->noms ?></td>
                <td> <a href="javascript:void(0)" id="<?= $d->op_id ?>" class="btn-ms btn-primary btn-sm valider_stock">Valider </a></td>
                <td> <a href="javascript:void(0)" id="<?= $d->op_id ?>" class="btn-ms btn-danger btn-sm delete_op"> Supprimer </a> </td>
                <?php if ($d->op_type == 'Approvisionnement'): ?>
                  <td><a href="javascript:void(0)" class="row_edit_appro_hist" style="cursor:pointer" data-id="<?= $value['op_id'] ?>"><i class="text-danger fa fa-file fa-fw"></i></a< /td>
                    <?php elseif ($d->op_type == 'Sortie'): ?>
                  <td><a href="javascript:void(0)" class="row_edit_sort_hist" style="cursor:pointer" data-id="<?= $value['op_id'] ?>"><i class="text-danger fa fa-file fa-fw"></i></a< /td>
                    <?php elseif ($d->op_type == 'Transfert'): ?>
                  <td><a href="javascript:void(0)" class="row_edit_chg_hist" style="cursor:pointer" data-id="<?= $value['op_id'] ?>"><i class="text-danger fa fa-file fa-fw"></i></a< /td>
                    <?php else: ?>
                  <td><a href="javascript:void(0)" class="row_edit_appro_hist" style="cursor:pointer" data-id="<?= $value['op_id'] ?>"><i class="text-danger fa fa-file fa-fw"></i></a< /td>
                    <?php endif ?>
              </tr>
          <?php }
          endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="assets/js/data-tables.js"></script>