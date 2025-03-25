<?php
require_once("../../Models/Admin/customer.class.php");
require_once("../../Models/Admin/account.class.php");
require_once("../../Models/Admin/personne.class.php");
$customers = new Customer();
$personnes = new Personne();
$accounts = new Account();
// $branches = $branches->getBranches();
@$cust = $customers->select($_GET['id']);
@$pers = $personnes->select($_GET['id']);
@$acc = $accounts->select($_GET['id']);

$title = "Informations Générales du Client";
?>
<div class="col-md-12" style="margin:25px; margin-bottom:50px;">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb pl-0">
      <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
      <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
    </ol>
  </nav>

  <div id="message"></div>

  <div class="ms-panel">
    <div class="ms-panel-header">
      <h1 style="font-style: 14px; font-weight: bold;">Informations Générales du Client</h1>
    </div>
    <div class="ms-panel-body">
      <div class="row">
        <div class="col-sm-3"><!--left col-->
          <form action="javascript:void(0)" method="post" autocomplete="off">
            <input type="text" id="autocomplete" name="content_lib_cust" class="form-control" value="<?php if (!empty($_GET['id'])) echo @$pers->nom_complet; ?>" placeholder="Recherche du client" autocomplete="off" required>
            <span style="display: none;"><input type="text" name="cust_id" id="tiers_id" value="<?php if (!empty($_GET['id'])) echo @$pers->personne_id; ?>" required /></span>
          </form>
          <hr>
          <ul class="list-group">
            <li class="list-group-item text-right"><span class="pull-left"><button class="btn btn-primary btn-sm" id="all_cust">Tous les clients</button></span></li>
            <li class="list-group-item text-right"><span class="pull-left"><button class="btn btn-info btn-sm" id="all_cust_cred">Les Clients Redevables</button></span></li>
          </ul>

        </div><!--/col-3-->
        <div class="col-sm-9">

          <ul class="nav nav-tabs tabs-bordered d-flex nav-justified mb-4">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#home">Général</a>
            </li>
            <?php if (!empty($_GET['id'])) { ?>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#cust_history" id="cust_sale">Historique</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#disp_pay" id="tiers_pay">Paiement</a>
              </li>
            <?php } ?>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="home">
              <hr>
              <?php include('../../Public/partials/form_customer.php'); ?>
              <hr>

            </div><!--/tab-pane-->
            <div class="tab-pane" id="cust_history"> </div>
            <div class="tab-pane" id="disp_pay"> </div>

          </div><!--/tab-pane-->
        </div><!--/tab-content-->

      </div><!--/col-9-->
    </div><!--/row-->
  </div>

  <div style="padding-top: 20px;"></div>
</div>
<script src="assets/js/data-tables.js"></script>