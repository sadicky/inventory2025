<?php
session_start();
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/branches.class.php");
require_once("../../Models/Admin/config.class.php");
$users = new User();
$config = new Config();
$branches = new Branches();

if (!empty($_GET['id'])) {
    $pers = $personnes->select($_GET['id']);
    $user = $users->getStaffId($_GET['id']);
    // var_dump($user);
}
// var_dump($_SESSION['role']);
$det = $config->getSociety();
?>
<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
        </ol>
    </nav>

    <div id="message"></div>
    <div class="ms-panel">
        <div class="ms-panel-body">
        <?php if($_SESSION['role']==1):?>
            <form id="frm_society" method="post">
                <div class="form-body">
                    <div class="form-row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Type de Contribuable</label>
                                <select class="custom-select" name="tp_type" id="tp_type">
                                    <?php
                                    $datas = array('Physique', 'Morale');
                                    foreach ($datas as $key => $value) {
                                        if (($key + 1) == $det['tp_type']) {
                                            echo '<option value="' . ($key + 1) . '" selected>' . $value . '</option>';
                                        }
                                        echo '<option value="' . ($key + 1) . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Raison Social</label>
                                <input type="text" id="tp_name" name="tp_name" class="form-control" value="<?php echo $det['tp_name']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">NIF</label>
                                <input type="text" id="tp_tin" name="tp_tin" class="form-control" value="<?php echo $det['tp_tin']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">RC</label>
                                <input type="text" id="tp_trade_number" name="tp_trade_number" class="form-control" value="<?php echo $det['tp_trade_number']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Tél</label>
                                <input type="text" id="tp_phone_number" name="tp_phone_number" class="form-control" value="<?php echo $det['tp_phone_number']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">BP</label>
                                <input type="text" id="tp_postal_number" name="tp_postal_number" class="form-control" value="<?php echo $det['tp_postal_number']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Province / Ville</label>
                                <input type="text" id="tp_address_province" name="tp_address_province" class="form-control" value="<?php echo $det['tp_address_province']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Commune</label>
                                <input type="text" id="tp_address_commune" name="tp_address_commune" class="form-control" value="<?php echo $det['tp_address_commune']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Quartier</label>
                                <input type="text" id="tp_address_quartier" name="tp_address_quartier" class="form-control" value="<?php echo $det['tp_address_quartier']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Avenue</label>
                                <input type="text" id="tp_address_avenue" name="tp_address_avenue" class="form-control" value="<?php echo $det['tp_address_avenue']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Rue</label>
                                <input type="text" id="tp_address_rue" name="tp_address_rue" class="form-control" value="<?php echo $det['tp_address_rue']; ?>">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">No</label>
                                <input type="text" id="tp_address_number" name="tp_address_number" class="form-control" value="<?php echo $det['tp_address_number']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">TVA</label>
                                <select class="custom-select" name="vat_taxpayer" id="vat_taxpayer">
                                    <?php
                                    $datas = array('Non', 'Oui');
                                    foreach ($datas as $key => $value) {
                                        if ($value == $det['vat_taxpayer']) {
                                            echo '<option value="' . ($key) . '" selected>' . $value . '</option>';
                                        }
                                        echo '<option value="' . ($key) . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Taxe de Conso</label>
                                <select class="custom-select" name="ct_taxpayer" id="ct_taxpayer">
                                    <?php
                                    $datas = array('Non', 'Oui');
                                    foreach ($datas as $key => $value) {
                                        if ($value == $det['ct_taxpayer']) {
                                            echo '<option value="' . ($key) . '" selected>' . $value . '</option>';
                                        }
                                        echo '<option value="' . ($key) . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Forfaitaire</label>
                                <select class="custom-select" name="tl_taxpayer" id="tl_taxpayer">
                                    <?php
                                    $datas = array('Non', 'Oui');
                                    foreach ($datas as $key => $value) {
                                        if ($value == $det['tl_taxpayer']) {
                                            echo '<option value="' . ($key) . '" selected>' . $value . '</option>';
                                        }
                                        echo '<option value="' . ($key) . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Centre Fiscal</label>
                                <select class="custom-select" name="tp_fiscal_center" id="tp_fiscal_center">
                                    <?php
                                    $datas = array('DGC', 'DMC', 'DPMC');
                                    foreach ($datas as $key => $value) {
                                        if ($value == $det['tp_fiscal_center']) {
                                            echo '<option value="' . ($key + 1) . '" selected>' . $value . '</option>';
                                        }
                                        echo '<option value="' . ($key + 1) . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Secteur d'activité</label>
                                <input type="text" id="tp_activity_sector" name="tp_activity_sector" class="form-control" value="<?php echo $det['tp_activity_sector']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Forme Juridique</label>
                                <input type="text" id="tp_legal_form" name="tp_legal_form" class="form-control" value="<?php echo $det['tp_legal_form']; ?>">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <br />
                            <?php
                            if (!empty($_GET['id'])) {
                            ?>
                                <input type="hidden" name="operation" id="operation" value="Edit" />
                                <input type="hidden" name="cat_id" id="category_id" value="<?php echo $_GET['id']; ?>" />
                            <?php
                            } else {
                            ?>
                                <input type="hidden" name="operation" id="operation" value="Add" />
                            <?php
                            }
                            ?>
                            <input type="hidden" name="coeff" id="coeff" value="0" />
                            <label class="control-label">&nbsp;</label>
                            <button id="action" data-id="Add" type="submit" class="btn btn-sm btn-success" name="action"> <span class="fa fa-save"></span> Enregistrer</button>

                        </div>
                    </div>
                </div>
            </form>
<?php endif?>
        </div>

        <div style="padding-top: 20px;"></div>
    </div>

    <script src="assets/js/data-tables.js"></script>