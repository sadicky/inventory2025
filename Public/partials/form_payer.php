<?php
require_once('../../Models/Admin/vente.class.php');
require_once("../../Models/Admin/transaction.class.php");
$transactions = new Transactions();
$vente = new Vente();
$reste = 0;

if (isset($_GET['op_id'])) {
    $d = $transactions->getDetteId($_GET['op_id']);
    $total = $d->total;
    $m_paye = $d->paid;
    $reste = $total - $m_paye;
    $id = $d->credits_id;
?>
    <div class="card" style="padding: 10px;">
        <form method="post" id="form_pay_tiers" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" id="op_id" name="op_id" value="<?= $_GET['op_id'] ?>">
                <div class="col-md-6">
                    <label class="control-label">Déjà Payé</label>
                    <input type="number" class="form-control input-sm" value="<?= $m_paye ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="control-label"> Reste à Payer</label>
                    <input type="number" class="form-control input-sm" value="<?= $reste ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="control-label"> Montant</label>
                    <input type="number" id="dette" name="dette" class="form-control input-sm" placeholder="montant à payer">
                </div>
                <div class="col-md-6">
                    <label class="control-label">&nbsp;<br><br></label>
                    <button type="submit" id="enregistrer" class="btn btn-primary btn-sm">
                        <i class="fa fa-save"></i> Valider
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php
}
?>