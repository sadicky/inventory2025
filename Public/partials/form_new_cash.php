<div id="message"></div>
<div class="ms-panel" style="margin: 10px 50px 10px 50px;">
  <div class="ms-panel-body">
    <div class="container-fluid bootstrap snippet">
      <h3 style="font-style: 14px; font-weight: bold;">Informations Générales des Caisses/Banques</h3>
      <hr>
      <div class="row">
        <div class="col-sm-3"><!--left col-->
          <form method="post" autocomplete="off">
            <input placeholder="Recherche" type="text" id="autocomplete" name="content_lib_bq" class="form-control" value="<?php if (!empty($_GET['id'])) //echo $pers->getNomComplet();
                                                                                                                            ?>" autocomplete="off" required>
            <span style="display: none;"><input type="text" name="bq_id" id="tiers_id" value="<?php if (!empty($_GET['id'])) //echo $pers->getPersonneId();
                                                                                              ?>" required /></span>
          </form>
          <hr>
          <ul class="list-group">
            <?php if (!empty($_GET['id'])) { ?>
              <li class="list-group-item text-right"><span class="pull-left"><button class="btn btn-primary btn-sm" id="new_cash"><i class="fa fa-plus"></i> Nouveau</button></span></li>
            <?php } ?>
          </ul>
        </div><!--/col-3-->
        <div class="col-sm-9">

          <ul class="nav nav-tabs tabs-bordered d-flex nav-justified mb-4">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#home">Général</a>
            </li>
            <?php if (!empty($_GET['id'])) { ?>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#disp_trans" id="show_trans">Transactions</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#disp_alim" id="tiers_alim">Versement</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#disp_dep" id="tiers_dep">Dépenses</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#disp_transf" id="tiers_transf">Transfert</a>
              </li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <div class="tab-pane  active active show fade in" id="home">
              <hr>
              <?php include('../../Public/partials/form_caisse.php'); ?>
              <hr>
            </div>
            <div class="tab-pane" id="disp_trans">
            </div>
            <div class="tab-pane" id="disp_alim">
            </div>
            <div class="tab-pane" id="disp_dep">
            </div>
            <div class="tab-pane" id="disp_transf">
            </div>
          </div>
        </div><!--/tab-content-->

      </div><!--/col-9-->
    </div><!--/row-->
  </div>
</div>

<div style="padding-top: 20px;"></div>
</div>