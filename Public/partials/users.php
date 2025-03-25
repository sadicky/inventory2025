<?php
require_once("../../Models/Admin/user.class.php");
require_once("../../Models/Admin/store.class.php");
require_once("../../Models/Admin/personne.class.php");
$users = new User();
$personnes = new Personne();
$stores = new POS();

$datas = $personnes->select_all_role('users');
// var_dump($datas);
?>

<div class="card" style="margin:25px; margin-bottom:50px;">

    <div class="card-header bg-light">
        <h3>Utilisateurs | <a href="javascript:void(0)" class="btn btn-success btn-sm" id="new_user"> <i class="fa fa-plus"></i> Nouveau</a></h3>
    </div>
    <div class="card-wrapper">
        <div class="card-body">
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-condensed table-striped display table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Identifiant</th>
                            <th>Nom </th>
                            <th>Genre</th>
                            <th>POS</th>
                            <th>Branche</th>
                            <th>Etat</th>
                            <th>Fonction</th>
                            <th>Modifier</th>
                            <th>Suspendre</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (!empty($datas)) {
                            foreach ($datas as $un) {
                                $user = $users->select_2($un->personne_id);
                                $pos = $stores->getPOS(@$user->pos_id);

                                echo '<tr><td>' . @$user->username . '</td><td>' . $un->nom_complet . '</td><td>' . $un->genre . '</td><td>' . @$pos->type . '</td><td>' . @$pos->store . '</td>';
                                if ( @$user->statut == '1') {
                                    echo '<td><span class="badge badge-primary" >Actif</span></td>';
                                }  else{                                   
                                    echo '<td><span class="badge badge-danger" >Suspendu</span></td>';
                                }
                                echo '<td>' . @$user->role . '</td>';
                                echo '<td>';

                                echo '<a href="javascript:void(0)" class="update_ut" id="' . @$un->personne_id . '"><i class="fa fa-edit"></i></a>';

                                echo '</td><td>';
                            
                                if (@$user->role_id !=1 and @$user->statut == '1') {
                                    echo '<a href="javascript:void(0)" class="active_pers" id="' . $user->user_id . '" data-id="0"><i class="fa fa-arrow-down"></i></a>';
                                } else if (@$user->role_id !=1 and @$user->statut == '0') {
                                    echo '<a href="javascript:void(0)" class="active_pers" id="' . $user->user_id . '" data-id="1"><i class="text-danger fa fa-arrow-up"></i></a>';
                                }else{
                                    
                                    echo '-';
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