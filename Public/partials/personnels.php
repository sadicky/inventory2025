<?php
session_start();
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/branches.class.php");
require_once("../../Models/Admin/personne.class.php");
require_once("../../Models/Admin/store.class.php");
$store = new POS();
$users = new User();
$personnes = new Personne();
$branches = new Branches();


if ($_SESSION['role'] == 1) {
    $datas = $users->getStaff();
    // $stores = $store->getStorePrincipal();
    // $caisse = $caisses->getCaisses();
} else {
    $st = $store->getStoreId($_SESSION['pos']);
    $stores = $store->getBranchePOS($st->branche_id);
    // $caisse = $caisses->getIdCaisseBranche($st->branche_id);
    $datas = $users->getStaffBranche($st->branche_id);
}
// var_dump($datas);
?>

<div class="card" style="margin:25px; margin-bottom:50px;">

    <div class="card-header bg-light">
        <h3>Personnel | <a href="javascript:void(0)" id="new_perso"> <i class="fa fa-plus"></i> Nouveau</a> </h3>
    </div>
    <div class="card-wrapper">
        <div class="card-body">
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-condensed table-striped display table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Noms </th>
                            <th>Sexe</th>
                            <th>Branche</th>
                            <th>Etat</th>
                            <th>Fonction</th>
                            <th>Dettes Clients</th>
                            <th>Commission</th>
                            <th>Modifier</th>
                            <th>Suspendre</th>
                            <!-- <th>Supprimer</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (!empty($datas)) {
                            foreach ($datas as $un) {
                                // $user = $users->select_2($un->personne_id);
                                // $pos = $stores->getPOS($user->pos_id);

                                echo '<tr><td>' . $un->noms . '</td><td>' . $un->sexe . '</td><td>' . $un->branche . '</td>';
                                if ($un->etat == '1') {
                                    echo '<td><span class="badge badge-primary" >Actif</span></td>';
                                } else {
                                    echo '<td><span class="badge badge-danger" >Suspendu</span></td>';
                                }
                                echo '<td>' . $un->role . '</td>';
                                echo '<td><a href="javascript:void(0)" class="get_dettes" id="' . $un->staff_id . '"><i class="fa fa-file"></i> Afficher</a></td>';
                                echo '<td><a href="javascript:void(0)" class="get_coms" id="' . $un->staff_id . '"><i class="fa fa-file"></i> Afficher</a></td>';
                                echo '<td>';

                                echo '<a href="javascript:void(0)" class="update_perso" id="' . $un->staff_id . '"><i class="fa fa-edit"></i></a>';

                                echo '</td><td>';

                                if ($un->etat == '1') {
                                    echo '<a href="javascript:void(0)" class="active_perso" id="' . $un->staff_id . '" data-id="0"><i class="fa fa-arrow-down"></i></a>';
                                } else {
                                    echo '<a href="javascript:void(0)" class="active_perso" id="' . $un->staff_id . '" data-id="1"><i class="text-danger fa fa-arrow-up"></i></a>';
                                }

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