<?php
session_start();
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/branches.class.php");
require_once("../../Models/Admin/store.class.php");
require_once("../../Models/Admin/presence.class.php");
$store = new POS();
$salaires = new User();
$appels = new Presence();
$branches = new Branches();



// Générer la liste de présence pour chaque jour du mois
$days_of_month = range(1, 31);

if ($_SESSION['role'] == 1) {
    $datas = $salaires->getStaffSalaire();
    // $stores = $store->getStorePrincipal();
    // $caisse = $caisses->getCaisses();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    // $stores = $store->getBranchePOS($st->branche_id);
    // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
    $datas = $salaires->getStaffBrancheSalaire($st->branche_id);
}
?>

<div class="card" style="margin:25px; margin-bottom:50px;">

    <div class="card-header bg-light">
        <h3>Presences &nbsp;<a href="javascript:void(0)" class="ms-btn btn-sm btn-primary" id="new_pres"> <i class="fa fa-plus"></i> Ajouter</a> </h3>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label>Mois</label>
                    <input type="month" id="month" name="month" class="form-control" required="Choisir le mois">
                </div>
                <div class="form-group col-md-3"><br>
                    <button class="btn btn-sm btn-primary" name="filtrer" id="filtrer" type="submit"> <i class="fa fa-eye"></i>Filtrer</button>
                </div>
            </div>
        </form>
        <hr>
        <?php
        if (isset($_POST['id'])) {
            if (empty($datas)): ?> <h3 class="alert alert-danger">Aucune data trouvé.</h3>
            <?php else: ?>
                <h4 class="card-title">FORMULAIRE DE PRESENCE (<?= $_POST['id'] ?>)</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table table-condensed tab">
                        <thead>
                            <tr>
                                <th class="text-left">Personnel</th>
                                <?php $m= $_POST['id']; 
                                foreach ($days_of_month as $day): ?>
                                    <th><?= date('D', strtotime("$m-$day")) === 'Sun' ? '—' : $day ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datas as $p): ?>
                                <tr>
                                    <td class="text-left"><?= $p->noms ?></td>
                                    <?php $m= $_POST['id']; 
                                     foreach ($days_of_month as $day): ?>
                                    <td>
                                        <?php
                                        // $count = $appels->countPresence($p->staff_id);
                                        // var_dump($count->nbr);
                                        $date_presence = $m.'-'. str_pad($day, 2, '0', STR_PAD_LEFT);                                        
                                        $presences = $appels->getPresences_by_branche($p->staff_id, $date_presence);
                                        // var_dump($date_presence);
                                        foreach ($presences as $presence){
                                        if($presence['presence'] === 1)  echo '<i class="fas fa-check text-success"></i>';
                                        // elseif($presence['presence'] === 0) echo '<i class="fas fa-times text-danger"></i>';
                                        else echo (date('D', strtotime($date_presence)) === 'Sun') ? '<i class="fas fa-minus text-muted"></i>' : '<i class="fas fa-times text-danger"></i>';                                        
                                        ?>
                                    </td>
                                    <?php } endforeach;?>
                                   
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
        <?php 
        endif;
        } ?>

    </div>
</div>

<div style="padding-top: 20px;"></div>
<script src="assets/js/data-tables.js"></script>