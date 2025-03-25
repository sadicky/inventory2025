<?php
@session_start();

require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/store.class.php');
require_once('../../Models/Admin/customer.class.php');
require_once('../../Models/Admin/vente.class.php');


$user = new User();
$cust = new Customer();
$branche = new Branches();
$transactions = new Transactions();
$customers = new Customer();
$store = new POS();
$ventes = new Vente();

if (!empty($_GET['from_d'])) $from_d = $_GET['from_d'];
else $from_d = date('Y-m-d');
if (!empty($_GET['to_d'])) $to_d = $_GET['to_d'];
else $to_d = date('Y-m-d');

if (!empty($_GET['branche_id'])) $branche_id = $_GET['branche_id'];
else $branche_id = '';

if ($_SESSION['role'] == 1) {
    $stores = $branche->getBranches();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBrancheStockPOS_0($st->branche_id);
}

//echo $_GET['pos_id'];
?>
<div class="card" style="margin: 30px;">

    <div class="card-header bg-light">Rapport des Produits vendues Du <?php echo $from_d; ?> Au <?php echo $to_d; ?></div>
    <div class="card-body">
        <form method="post" id="ad-searcher">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Branche</label>
                        <select class="custom-select" id="pos_id" name="pos_id" required readonly>
                            <option value="">--Choisir--</option>
                            <?php
                            foreach ($stores as $e) {
                                echo '<option value="' . $e->store_id . '">' . $e->type . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Du : </label>
                        <input type="date" id="from_d" name="from_d" class="form-control" value="<?php echo $from_d; ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Au : </label>
                        <input type="date" id="to_d" name="to_d" class="form-control" value="<?php echo $to_d; ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <br>
                    <button type="submit" name="valider" class="ms-btn-icon btn-primary"><i class="text-white fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <?php if (!empty($_GET['branche_id'])): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm tab">
                    <thead>
                        <tr>
                            <th>Categorie</th>
                            <th>Produits</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (!empty($_GET['branche_id']))
                            $datas = $ventes->select_plus_vendus_branche($_GET['branche_id'], $from_d, $to_d);

                        // var_dump($datas);
                        foreach ($datas as $key => $value) { ?>

                            <tr>
                                <td><?= $value->category_name ?></td>
                                <td><?= $value->details ?></td>
                                <td><?= number_format($value->total_vendu, 0, ',', ' ')  ?> </td>

                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    </div>
</div>