<?php
session_start();
require_once("../../Models/Admin/N2TEXT.php");
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
require_once('../../Models/Admin/autresfrais.class.php');
require_once('../../Models/Admin/transaction.class.php');
require_once('../../Models/Admin/tarif.class.php');
require_once('../../Models/Admin/sortie.class.php');
require_once('../../Models/Admin/personne.class.php');
require_once('../../Models/Admin/config.class.php');
require_once('../../Models/Admin/vente.class.php');
require_once('../../Models/Admin/stock.class.php');
require_once('../../Models/Admin/customer.class.php');
require_once('../../Models/Admin/livraison.class.php');

$achats = new Achat();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$details = new detOperation();
$journals = new Journal();
$operations = new Operation();
$products = new Product();
$livraisons = new Livraison();
$periodes = new Periode();
$store = new POS();
$suppliers = new Supplier();
$users = new User();
$autres = new AutreFrais();
$transactions = new Transactions();
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();
$conf = new Config();
$customers = new Customer();
$ventes = new Vente();
$stocks = new Stock();
$conv = new ConvertNumberToText();

$op = $operations->getOperationId($_POST['op_id']);
// var_dump($op);
$pers = $personnes->select($op->party_code);
$pers2 = $users->select($op->user_id);
$liv = $livraisons->select($_POST['op_id']);
$vente = $ventes->select($_POST['op_id']);
$cust = $customers->select($op->party_code);
$pos = $store->getPOS($op->pos_id);
$staff = $users->getStaffId($op->tar_id);

$cfg = $conf->select(1);
// $store = $stores->getPOS($op->pos_id);
?>

<!-- Impression -->
<link rel="stylesheet" href="assets/print_c/style.css">
<!-- <link rel="stylesheet" href="assets/css/paper.css"> -->

<div style="margin-left: 20px;" class="ticket">
    <p class="centered">
        <span> <img src="assets/img/costic/costic-logo-216x62.png" height="40px" width="60px" alt="logo"></span>
        <?php
        echo $cfg['rpt_header'];
        ?>
        <strong>Branche: <?= $pos->store ?></strong>
        <br> <br>
        <span>
            Fact:
            <span> <?php if ($op->is_paid == 0) echo "<b>Dette</b>";
                    elseif ($op->is_paid == 1) echo "<b>Cash</b>";
                    else echo "<b>Proformat</b>"; ?> - N° #<?php echo $vente->idvente; ?>
            </span> <br><br>
            Pour <b><?php echo $cust->customer_name; ?></b><br><br>
            Agent: <b style="font-size: 15px;"><?= $staff->noms ?></b>
        </span>
    </p>
    <table>
        <thead>
            <tr>
                <th class="description">Produit</th>
                <th class="quantity">Qté</th>
                <th class="price">PU</th>
                <th class="price">PT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_POST['op_id'])) {
                $datas2 = $details->select_all($_POST['op_id']);
                $ptg = 0;
                $tot_ass = 0;
                $pt = 0;
                $tva = 0;
                $ttva = 0;
                $phtva = 0;
                $pttc = 0;
                $tot = 0;
                $tot_tm = 0;
                foreach ($datas2 as $val) {
                    $op = $operations->getOperationId($val['op_id']);
                    $prod = $products->getProductId($val['product_id']);

                    $amount = $val['amount'];
                    $pt = $val['amount'] * $val['quantity'];

                    $pttc += $pt;

                    echo '<tr><td class="description">' . $prod->product_name . '</td><td align="center" class="quantity">' . $val['quantity'] . '</td><td align="center" class="price">' . $val['amount'] . '</td><td align="center" class="price">' .  number_format($pt, 0, ',', ' ') . '</td></tr>';
                }
                echo '</tbody><tfoot>';
                echo '<tr><th class="description">Total</th><th>-</th><th>-</th><th class="price">' .   number_format($pttc, 0, ',', ' ') . '</th></tr>';
                echo '</tfoot>';
            }

            ?>
    </table>

    <?php
    $v = number_format($pttc, 0, ',', ' ');
    $c = $conv->Convert($v);
    ?>
    <p align="left" style="font-weight:bold; font-size: 10px;"> <?php echo $c; ?></p>

    <p align="center" style="font-weight:bold; font-size: 9px;">Etablie par <?= $pers2->noms ?>, le <?= date('Y-m-d') ?></p>

    <img class="bar">

    <p class="centered">Merci de nous avoir choisi!</p>

</div>

<script src="assets/js/data-tables.js"></script>
<script>
    JsBarcode(".bar", "Facture", {
        height: 40,
        background: "#FFFFFF",
        displayValue: true
    });
</script>