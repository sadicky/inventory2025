<?php

include('Public/includes/header.php');

require_once("Ctrl/session.php");
require_once('Models/Admin/stock.class.php');
require_once('Models/Admin/account.class.php');
require_once('Models/Admin/journal.class.php');
require_once('Models/Admin/operation.class.php');
require_once('Models/Admin/periode.class.php');
require_once('Models/Admin/store.class.php');
require_once('Models/Admin/user.class.php');
require_once('Models/Admin/transaction.class.php');
require_once('Models/Admin/paiement.class.php');
require_once('Models/Admin/config.class.php');
require_once('Models/Admin/personne.class.php');

$users = new User();
$personnes = new Personne();
$op = new Operation();
$stock = new Stock();
$acc = new Account();
$trans = new Transactions();
$society = new Config();

//$check=new BeanCheckExp();
$journal = new Journal();
$paie = new Paiement();
$periodes = new Periode();
$pos = new Pos();
// var_dump($_SESSION['jour']);
$per = $periodes->select_crt('1');
$_SESSION['periode'] = @$per->periode_id;

$user_id = $_SESSION['id'];
$auth_user = $users->select_3($user_id);
$personne = $personnes->select($auth_user->personne_id);

$_SESSION['nom'] = $personne->nom_complet;
$_SESSION['photo'] = $personne->photo;
$_SESSION['perso_id'] = $personne->personne_id;

$soc = $society->getSociety();
if (!isset($_SESSION['pos'])) {
    $pos_user = $personnes->select($auth_user->pos_id);
    $_SESSION['pos'] = $pos_user->pos_id;
} else {
    $pos_user = $personnes->select($_SESSION['pos']);
}

if (!isset($_SESSION['jour'])) {
    @$jour = $journal->select_by_state($_SESSION['perso_id']);
    @$_SESSION['jour'] = $jour->jour_id;
} else {
    @$jour = $journal->select($_SESSION['jour']);
}
if (isset($_SESSION['op_vente_id'])) {
    // $etat = $_SESSION['etat'];
}

?>

<body class="ms-body">

    <div class="container-fluid">
        <div class="row" style="background-color: gainsboro;">
            <div class="col-md-4">
                <h4 id="sess_name">Utilisateur : <?php echo $personne->nom_complet; ?></h4>
            </div>
            <div class="col-md-4" style="text-align: center;margin-bottom:5px;">

                <?php //if (isset($_SESSION['op_vente_id'])) {
                ?>
                <a href="javascript:void(0)" id="1" class="btn btn-info btn-sm market">CASH</a>
                <a href="javascript:void(0)" id="0" class="btn btn-danger btn-sm market">DETTE</a>
                <a href="javascript:void(0)" id="2" class="btn btn-warning btn-sm market">PROFORMAT</a>
                <?php //} 
                ?>
            </div>
            <div class="col-md-4">
                <h4 align="right" style="align-item: center;">POS : <?php $pos = $pos->getPOS($_SESSION['pos']);
                                                                    echo $pos->store; ?></h4>
            </div>
        </div>
        <input type="hidden" name="current_jour" id="current_jour" value="<?php if (isset($_SESSION['jour'])) {
                                                                                echo $_SESSION['jour'];
                                                                            } ?>">

        <div class="container-fluid" style="margin-top:0px;">

            <?php if (isset($_SESSION['last_jour']) and !isset($_SESSION['jour'])) { ?>
                <div class="col-md-12 mt-2" id="page-content-sale_end" style="font-size: 13px;"> </div>
            <?php } ?>
            <?php if (isset($_SESSION['jour'])) {  ?>
                <hr style="margin-top: 10px;">
                <div id="page-content-resultat" style="font-size: 13px;"> </div>
            <?php } ?>

        </div>

        <div class="jumbotron bg-light" style="margin-bottom:0;">
            <div class="row">
                <div class="col-md-3 text-center">
                    <a class="navbar-brand" href="<?= WEBROOT ?>logout" style="font-size:50px; color:red" class="text-danger"><i class="fa fa-power-off"></i></a><br>
                </div>
                <div class="col-md-5" align="center">
                    <!-- <h2 style="font-size: 18px;">Opening Day : <?php echo @$jour->start_date; ?></h2>
                    <form class="form-inline" id="form_open_day">
                        <?php
                        if (!isset($_SESSION['jour'])) { ?>
                            <input type="text" name="open_bal" value="0" placeholder="Balance d'Ouverture" class="form-control-sm number-separator" required>
                            <input class="form-control-sm" type="date" name="open_date" id="open_date" value="<?php if (!empty($jour->start_date)) echo date("Y-m-d", strtotime("+1 days", strtotime($jour->start_date)));
                                                                                                                else echo date('Y-m-d');  ?>">
                            <button type="submit" class="ms-btn-icon btn-primary"><i class="fa fa-folder-open"></i></button>
                        <?php } else {
                        ?>
                            <label class="control-label">Bal de Fermeture</label> <input type="text" name="closing_cash" value="0" placeholder="Balance de fermeture" class="form-control-sm number-separator" required>
                            <button type="submit" class="ms-btn-icon btn-primary"><i class="fa fa-folder"></i></button>
                        <?php
                        }
                        ?>

                    </form> -->
                </div>
                <div class="col-md-3" align="right"> <a href="javascript:void(0)" id="non_valide_fact" class="btn btn-sm btn-danger">Les Factures Encours</a></div>

            </div>
        </div>
        <?php include('Public/includes/footer_.php'); ?>
    </div>
</body>