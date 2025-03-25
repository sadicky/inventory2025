<?php
session_start();
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/store.class.php");
require_once("../../Models/Admin/branches.class.php");
require_once("../../Models/Admin/personne.class.php");
// $users = new User();
$personnes = new Personne();
$branches = new Branches();
$store = new POS();


$salaires = new User();
$branches = new Branches();



if($_SESSION['role']==1){
    // $datas = $users->getStaff();
    $datas = $salaires->getStaffSalaire();
    // $stores = $store->getStorePrincipal();
    // $caisse = $caisses->getCaisses();
}else{
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBranchePOS($st->branche_id);
    // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
    // $datas = $users->getStaffBranche($st->branche_id);
    $datas = $salaires->getStaffBrancheSalaire($st->branche_id);
    
}
// var_dump($datas);
?>

<div class="card" style="margin:25px; margin-bottom:50px;">

    <div class="card-header bg-light">
        <h3>Les Salaires <?php if($_SESSION['role']==1):?> <a href="javascript:void(0)" class="ms-btn btn-sm btn-primary" id="new_sal"> <i class="fa fa-plus"></i> Nouveau</a> <?php endif?> <a href="javascript:void(0)" class="ms-btn btn-sm btn-danger" id="form-paiement"> <i class="fa fa-dollar"></i> Paiements</a>  </h3>
    </div>
    <div class="card-wrapper">
        <div class="card-body">
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-condensed table-striped display table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Noms </th>
                            <th>Branche</th>
                            <th>Fonction</th>
                            <th>Contact</th>
                            <th>Salaire</th>
                            <th>Modifier</th>
                            <!-- <th>Suspendre</th> -->
                            <!-- <th>Supprimer</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (!empty($datas)) {
                            foreach ($datas as $un) {
                                // $user = $users->select_2($un->personne_id);
                                // $pos = $stores->getPOS($user->pos_id);

                                echo '<tr><td>' . $un->noms . '</td><td>' . $un->branche . '</td>';
                              
                                echo '<td>' . $un->role . '</td>';
                                echo '<td>' . $un->tel . '</td>';
                                echo '<td>' . $un->salaire . ''.$un->short.'</td>';
                                echo '<td>';

                                echo '<a href="javascript:void(0)" class="update_sal" id="' . $un->staff_id . '"><i class="fa fa-edit"></i></a>';

                                echo '</td>';
                            
                                echo '</tr>';
                            }
                        } else {
                            echo '<h2 class="text-danger">Aucune Donnée</h2>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div style="padding-top: 20px;"></div>
<script src="assets/js/data-tables.js"></script>