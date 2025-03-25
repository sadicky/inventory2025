<?php
if(isset($_SESSION['op_vente_id']))
{
?>
<form method="post" action="javascript:void(0)" class="form-inline" id="form_add_red">
<!-- <div class="row">
    <div class="col-md-6"> -->
        <label class="control-label mr-2">Réductions(Montant)</label>
         <input type="number" id="val_red" name="val_red" class="form-control input-sm" value="0" required>
         <input type="hidden" id="op_id_red" name="op_id_red" class="form-control input-sm" value="<?php echo $_SESSION['op_vente_id']; ?>" required>
    <!-- </div>
    <div class="col-md-6"> -->
        <label class="control-label">&nbsp;</label><br/>
        <button id="add_red" data-id="<?php echo $_SESSION['op_vente_id']; ?>" type="submit" class="ms-btn-icon btn-warning btn-sm" name="action" style="bottom: 0;"> <span class="fa fa-check"></span></button>
     <!-- </div> -->
<!-- </div> -->
</form>
<?php
}
?>