<?php @session_start();
require_once('../../Models/Admin/supplier.class.php');
require_once('../../Models/Admin/operation.class.php');
require_once('../../Models/Admin/user.class.php');
require_once('../../Models/Admin/product.class.php');
require_once('../../Models/Admin/achat.class.php');
$supplier = new Supplier();       
$products = new Product();     
$operations = new Operation();   
$users = new User(); 
$achats = new Achat();
if(!empty($_GET['trans_id']))
{
$trans->select($_GET['trans_id']);
list($lib,$comment)=explode(":", $trans->getDescript());
}
?>
<hr>
<div class="card">
   <div class="card-header text-center">
    <strong>Saisie de dépenses</strong>
    </div>
    <div class="card-body card-block">
    <form method="post" id="frm_dep_tiers" enctype="multipart/form-data">
        <div class="row">
            
            <div class="col-md-3">

                <label class="control-label">Provenance</label>
                <select id="id_bq" name="id_bq" class="custom-select"required>
                    <option value="">-- Choisir --</option>
                    <?php
                    $mode=$bq->select_all();
                    foreach($mode as $e)
                    {
                        if($e['personne_id']==$_GET['id']) 
                        echo '<option value="'.$e['personne_id'].'" selected>'.$e['lib_bq'].'</option>';
                    }
                    ?>
                </select>

            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Mode Paiement</label>
                    <select id="mode_paie" name="mode_paie" class="custom-select" required>
                        <?php
                        $dat = array('Espèce','Chèque','Virement');
                        foreach ($dat as $key => $value) {

                            if(!empty($_GET['trans']) and $value==$trans->getModePaie())
                            {
                                echo '<option value="'.$value.'" selected>'.$value.'</option>';
                            }
                            echo '<option value="'.$value.'">'.$value.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
       
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Catégorie (Dépenses) <a href="javascript:void(0)" id="typ_dep"><i class="fa fa-plus"></i></a></label>
                    <input type="text" name="lib_dep" id="autocomplete_field" class="form-control" value="<?php if(!empty($_GET['trans_id'])) echo $lib; ?>">
                    <input type="hidden" name="id_typ" id="select_id" value="<?php if(!empty($_GET['trans_id'])) echo 'x'; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Autres détails</label>
                    <input type="text" id="comment_trans" name="comment_trans" class="form-control"  value="<?php if(!empty($_GET['trans_id'])) echo $comment;?>">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class=" form-control-label">Montant</label>
                    <input type="text" id="'mont_trans" name="mont_trans"  class="form-control number-separator" value="<?php if(!empty($_GET['trans_id'])) echo number_format($trans->getAmount()); else '0';?>" required>
                    
                </div>
            </div>
            <div class="col-md-6">
                <input type="hidden" name="party_code" id="party_code" value="<?php echo $_GET['id']; ?>">
            <?php if(!empty($_GET['trans_id']))
            {
                ?>
                <input type="hidden" id="operation" name="operation" value="Edit">
                <input type="hidden" id="trans_id" name="trans_id" value="<?php echo $_GET['trans_id']; ?>">
                <?php
            }
            else
            {
                ?>
                <input type="hidden" id="operation" name="operation" value="Add">
            <?php } ?>  
                <br/>
                <button type="submit" name="enregistrer" class="btn btn-success btn-sm">
                    <i class="fa fa-save"></i> Enregistrer
                </button>
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" d="new_cash_trans" data-id="disp_dep"><i class="fa fa-plus"></i> Nouveau</a>
            </div>
        </div>
    </form>
</div>
</div>