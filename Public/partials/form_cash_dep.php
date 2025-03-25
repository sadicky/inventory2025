<?php
@session_start();

require_once("../../Models/Admin/caisse.class.php");
require_once("../../Models/Admin/transaction.class.php");
require_once("../../Models/Admin/journal.class.php");
require_once("../../Models/Admin/store.class.php");
$store = new POS();
$caisses = new Caisse();
$transactions = new Transactions();
$journal = new Journal();

$jour = $journal->select($_SESSION['jour']);

if (!empty($_GET['trans_id'])) {
    $trans = $transactions->select($_GET['trans_id']);
    list($lib, $comment) = explode(":", $trans->descript);
}

if ($_SESSION['role'] == 1) {
    // $stores = $store->getStorePrincipal();
    $caisse = $caisses->getCaisses();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBranchePOS($st->branche_id);
    $caisse = $caisses->getIdCaisseBranche($st->branche_id);
}
?>

<div class="card" style="margin:25px; margin-bottom:50px;">
    <div class="card-header text-center">
        <strong>Saisie de dépenses</strong>
    </div>
    <div class="card-body card-block">
        <form method="post" id="form_cash_out" enctype="multipart/form-data">
            <div class="row">
                <div class="col col-md-3">
                    <label class=" form-control-label">Date</label>
                    <input type="date" id="trans_date" name="trans_date" class="form-control" value="<?php if (!empty($_GET['trans_id'])) echo @$trans->create_date;
                                                                                                        else echo @$jour->jour_state; ?>" required>
                </div>
                <div class="col-md-3">

                    <label class="control-label">Caisse</label>
                    <select id="id_bq" name="id_bq" class="custom-select" required>
                        <?php
                        // $mode=$caisses->getCaisses();
                        foreach ($caisse as $e) {
                            echo '<option value="' . $e->caisse_id . '">' . $e->caisse_name . '(' . $e->branche . ')</option>';
                        }
                        ?>
                    </select>

                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Mode Paiement</label>
                        <select id="mode_paie" name="mode_paie" class="custom-select" required>
                            <?php
                            $dat = array('Espèce', 'Chèque', 'Virement');
                            foreach ($dat as $key => $value) {

                                if (!empty($_GET['trans']) and $value == $trans->mode_paie()) {
                                    echo '<option value="' . $value . '" selected>' . $value . '</option>';
                                }
                                echo '<option value="' . $value . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Motif Dépenses</label>
                        <input type="text" name="lib_dep" id="autocomplete_field" class="form-control" value="<?php if (!empty($_GET['trans_id'])) echo $lib; ?>">
                        <input type="hidden" name="id_typ" id="select_id" value="<?php if (!empty($_GET['trans_id'])) echo 'x'; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class=" form-control-label">Valeur Montant</label>
                        <input type="text" id="mont_trans" name="mont_trans" class="form-control number-separator" value="<?php if (!empty($_GET['trans_id'])) echo number_format($trans->amount, 0, ' ', '.');
                                                                                                                            else '0'; ?>" required>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Commentaire</label>
                        <textarea id="comment_trans" name="comment_trans" class="form-control"><?php if (!empty($_GET['trans_id'])) echo $comment; ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php if (!empty($_GET['trans_id'])) {
                    ?>
                        <input type="hidden" id="operation" name="operation" value="Edit">
                        <input type="hidden" id="trans_id" name="trans_id" value="<?php echo $_GET['trans_id']; ?>">
                    <?php
                    } else {
                    ?>
                        <input type="hidden" id="operation" name="operation" value="Add">
                    <?php } ?>
                    <br />
                    <button type="submit" name="enregistrer" id="enregistrer" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div style="padding-top: 20px;"></div>