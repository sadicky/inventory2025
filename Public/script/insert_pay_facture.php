<?php
@session_start();
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/branches.class.php');
require_once('../../Models/Admin/caisse.class.php');
require_once('../../Models/Admin/category.class.php');
require_once('../../Models/Admin/paiement.class.php');
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

$achats = new Achat();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$paie = new Paiement();
$details = new detOperation();
$journals = new Journal();
$operations = new Operation();
$products = new Product();
$periodes = new Periode();
$stores = new POS();
$suppliers = new Supplier();
$users = new User();
$autres = new AutreFrais();
$trans = new Transactions();
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();
$conf = new Config();
$customers = new Customer();
$ventes = new Vente();
$stocks = new Stock();

// var_dump($_POST);die();
$op = $operations->getOperationId($_POST['op_id']);
$vente = $ventes->select($_POST['op_id']);

$st = $stores->getStoreId($_SESSION['pos']);

$bq = $caisses->getCaisseId($st->branche_id);

$jourId = $_SESSION['jour'];
$jour = $journals->select($jourId);
$amount = $details->select_sum_op_2($_POST['op_id']);
// var_dump($_POST);die();
if ($trans->select_all_op_count($_POST['op_id']) == 0) {

    if ($_POST['status'] == 0) {
        // $jourId = 0;
        $OpId =  $_POST['op_id'];
        $transaction_type = '3';
        $personne_id = $_SESSION['id'];
        $descript = 'Dette';
        $id_bq = $bq->caisse_id;
        $pos_id = $_SESSION['pos'];
        $create_date = $op->create_date;
        $status = 1;
        $partyCode = $op->party_code;
        $staff_id = $op->tar_id;
        $mode_paie = "DETTE";

        $trans_id = $trans->insert($jourId, $OpId, $transaction_type, $descript, $amount, $partyCode, $id_bq, $pos_id, $personne_id, $status, $create_date, $mode_paie, $staff_id);
        $operations->update_one($_POST['op_id'], 'op_id', 'is_paid', '0');

        $trans->setDette($_POST['op_id'], $partyCode, $st->branche_id,  $staff_id, $amount, 0);


        $paie->setOpId($_POST['op_id']);
        $paie->setTransactionId($trans_id);
        $paie->setAmount($amount);
        $paie->setModePaie($bq->caisse_name);
        $paie->setcaisseId($bq->caisse_id);
        $paie->setAutref('0');
        $paie->insert();
    } elseif ($_POST['status'] == 2) {
        // $jourId = 0;
        $OpId =  $_POST['op_id'];
        $transaction_type = '3';
        $personne_id = $_SESSION['id'];
        $descript = 'Proformat';
        $id_bq = $bq->caisse_id;
        $pos_id = $_SESSION['pos'];
        $create_date =  $op->create_date;
        $status = 1;
        $staff_id = $op->tar_id;
        $partyCode = $op->party_code;
        $mode_paie = "PROFORMAT";

        $trans_id = $trans->insert($jourId, $OpId, $transaction_type, $descript, $amount, $partyCode, $id_bq, $pos_id, $personne_id, $status, $create_date, $mode_paie, $staff_id);
        $operations->update_one($_POST['op_id'], 'op_id', 'is_paid', '2');
    } elseif ($_POST['status'] == 1) {

        $OpId =  $_POST['op_id'];
        $transaction_type = '3';
        $personne_id = $_SESSION['id'];
        $descript = 'Vente des produits';
        $id_bq = $bq->caisse_id;
        $partyCode = $op->party_code;
        $pos_id = $_SESSION['pos'];
        $create_date =  $op->create_date;
        $status = 1;
        $staff_id = $op->tar_id;
        $mode_paie = "CAISSE";

        $trans_id = $trans->insert($jourId, $OpId, $transaction_type, $descript, $amount, $partyCode, $id_bq, $pos_id, $personne_id, $status, $create_date, $mode_paie, $staff_id);
        $operations->update_one($_POST['op_id'], 'op_id', 'is_paid', '1');

        $paie->setOpId($_POST['op_id']);
        $paie->setTransactionId($trans_id);
        $paie->setAmount($amount);
        $paie->setModePaie($bq->caisse_name);
        $paie->setcaisseId($bq->caisse_id);
        $paie->setAutref('0');
        $paie->insert();
    }

    if (isset($_SESSION['op_vente_id'])) {
        unset($_SESSION['op_vente_id']);
    }
}
