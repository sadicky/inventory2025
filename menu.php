<?php
require_once('Models/Admin/stock.class.php');
require_once('Models/Admin/store.class.php');
$stock = new Stock();
$pos = new POS();
$st = $pos->getStoreId($_SESSION['pos']);
// $stores = $user->getStaffBranche($st->branche_id);
// var_dump($poss);
?>

<!-- Overlays -->
<div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
<div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>

<aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
  <!-- Logo -->
  <div class="ms-d-block-lg">
    <a class="pl-0 ml-0 text-center" href="<?= WEBROOT ?>dashboard">
      <img src="assets/img/costic/costic-logo-216x62.png" alt="logo">
    </a>

  </div>
  <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
    <!-- Dashboard -->
    <li class="menu-item">
      <a href="javascript:void(0)" id="dashboard"> <span><i class="fa fa-home"></i>Entreprise </span>
      </a>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0)" id="notes"> <span><i class="fa fa-edit"></i>Notes </span>
      </a>
    </li>
    <?php if ($_SESSION['role'] == 1): ?>
      <!-- restaurants -->
      <li class="menu-item">
        <a href="javascript:void(0)" id="getbranches"> <span><i class="fa fa-sitemap fs-16"></i>Branches</span>
        </a>
      </li>
    <?php endif ?>

    <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 5): ?>
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#stock" aria-expanded="false" aria-controls="stock"> <span><i class="fa fa-cubes fs-16"></i>Stock </span>
        </a>
        <ul id="stock" class="collapse" aria-labelledby="stock" data-parent="#side-nav-accordion">

          <li> <a href="javascript:void(0)" id="getproducts">Produits</a></li>
          <!-- <li> <a href="javascript:void(0)" id="getcommandes">Commande</a></li> -->
          <li> <a href="javascript:void(0)" id="getachat">Entrée Stock</a></li>
          <li> <a href="javascript:void(0)" id="out_stock">Sortie du Stock</a></li>
          <li> <a href="javascript:void(0)" id="change">Transfert</a></li>
          <li> <a href="javascript:void(0)" id="fournisseurs">Fournisseurs</a></li>
          <!-- <li> <a href="<?= WEBROOT ?>fournisseurs">Fournisseurs</a></li> -->
          <li> <a href="javascript:void(0)" id="periode">Inventaires</a></li>
          <li> <a href="javascript:void(0)" id="allstocks">Tous les Produits</a></li>
          <!-- <li> <a href="<?= WEBROOT ?>allstocks">Tous les Produits</a></li> -->
        </ul>
      <?php endif ?>
      </li>
      <!-- stock end -->
      <!-- caisse -->

      <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2  || $_SESSION['role'] == 4): ?>
        <li class="menu-item">
          <a href="#" class="has-chevron" data-toggle="collapse" data-target="#caisse" aria-expanded="false" aria-controls="caisse"> <span><i class="fas fa-file-invoice fs-16"></i>Caisse</span>
          </a>
          <ul id="caisse" class="collapse" aria-labelledby="caisse" data-parent="#side-nav-accordion">

            <?php if ($_SESSION['role'] == 1): ?>
              <li> <a href="javascript:void(0)" id="comptes">Comptes</a> </li>
            <?php endif ?>
            <li> <a href="javascript:void(0)" id="newcustomer">Clients</a> </li>
            <li> <a href="javascript:void(0)" id="depenses">Dépenses</a> </li>
            <!-- <li> <a href="javascript:void(0)" id="avances">Avance Dette</a> </li> -->
            <li> <a href="javascript:void(0)" id="all_cust_cred">Les Redevables</a> </li>
          </ul>
        </li>
      <?php endif ?>
      <!-- caisse end -->
      <!-- rapports-->
      <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 4 || $_SESSION['role'] == 5): ?>
        <li class="menu-item">
          <a href="#" class="has-chevron" data-toggle="collapse" data-target="#rapport" aria-expanded="false" aria-controls="rapport"> <span><i class="fas fa-bars fs-16"></i>Rapports </span>
          </a>
          <ul id="rapport" class="collapse" aria-labelledby="rapport" data-parent="#side-nav-accordion">
            <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 4): ?>
              <li> <a href="javascript:void(0)" id="rpt_sale">Rapport de Vente</a> </li>
              <li> <a href="javascript:void(0)" id="rpt_dette">Rapport de Dettes</a> </li>
              <li> <a href="javascript:void(0)" id="rpt_cash">Mouvement de Caisse</a> </li>
            <?php endif ?>
            <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 5): ?>
              <li> <a href="javascript:void(0)" id="rpt_stock">Rapport du Stock</a> </li>
            <?php endif ?>
            <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 4): ?>
              <!-- <li> <a href="javascript:void(0)" id="rstock">Rapport de Paiement</a> </li> -->
              <li> <a href="javascript:void(0)" id="rpt_endom">Rapport des Endomagés</a> </li>
            <?php endif ?>
            <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 5): ?>
              <li> <a href="javascript:void(0)" id="rpt_hist">Historiques Mouvmt</a> </li>
            <?php endif ?>
            <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2): ?>
              <!-- <li> <a href="javascript:void(0)" id="rstock">Rapport de Présences</a> </li> -->
              <li> <a href="javascript:void(0)" id="rpt_prof">Rapport de Proformat</a> </li>
              <!-- <li> <a href="javascript:void(0)" id="journaux">Journaux</a> </li> -->
            <?php endif ?>
          </ul>
        </li>
      <?php endif ?>
      <!-- rapports  end -->
      <!-- Basic UI Elements -->
      <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2): ?>
        <li class="menu-item">
          <a href="#" class="has-chevron" data-toggle="collapse" data-target="#rh" aria-expanded="false" aria-controls="rh"> <span><i class="fas fa-user-friends fs-16"></i>RH</span>
          </a>
          <ul id="rh" class="collapse" aria-labelledby="rh" data-parent="#side-nav-accordion">
            <li> <a href="javascript:void(0)" id="personnels">Personnels</a></li>
            <li> <a href="javascript:void(0)" id="salaires">Salaires</a></li>
            <li> <a href="javascript:void(0)" id="presences">Présences</a></li>
            <!-- <li> <a href="javascript:void(0)" id="getavances">Avance/Salaire</a></li> -->
          </ul>
        </li>
      <?php endif ?>
      <!-- /Basic UI Elements -->
      <!-- Basic UI Elements -->
      <?php if ($_SESSION['role'] == 1): ?>
        <li class="menu-item">
          <a href="#" class="has-chevron" data-toggle="collapse" data-target="#etats" aria-expanded="false" aria-controls="etats"> <span><i class="fa fa-list fs-16"></i>Etats Financiers</span>
          </a>
          <ul id="etats" class="collapse" aria-labelledby="etats" data-parent="#side-nav-accordion">
            <li> <a href="javascript:void(0)" id="valorisations">Valeurs Produits</a> </li>
            <li> <a href="javascript:void(0)" id="valorisations_vente">Valeurs Produits Vendu</a> </li>
            <li> <a href="javascript:void(0)" id="valorisations_dette">Valeurs Dettes</a> </li>
            <li> <a href="javascript:void(0)" id="salaires">Salaires</a> </li>
            <li> <a href="javascript:void(0)" id="depenses">Depenses</a> </li>
            <li> <a href="javascript:void(0)" id="rpt_sale">Ventes</a> </li>
          </ul>
        </li>
      <?php endif ?>
      <!-- /Basic UI Elements -->
      <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 5 || $_SESSION['role'] == 2): ?>
        <li class="menu-item">
          <a href="#" class="has-chevron" data-toggle="collapse" data-target="#alerts" aria-expanded="false" aria-controls="alerts"> <span><i class="fa fa-bullhorn fs-16"></i>Alertes</span>
          </a>
          <ul id="alerts" class="collapse" aria-labelledby="alerts" data-parent="#side-nav-accordion">

            <li> <a href="javascript:void(0)" class="rpt_under" data-id="1"> <i class="fa fa-battery-quarter text-warning"></i> Min
                <span class="badge badge-warning badge-pill"><?php echo $stock->select_nb_under_min($_SESSION['pos']); ?></span> </a></li>
            <li> <a href="javascript:void(0)" class="rupture" data-id="0"><i class="material-icons">battery_alert</i> En Rupture <span class="badge badge-danger badge-pill"><?php echo $stock->select_nb_zero($_SESSION['pos']); ?></span></a> </li>
          </ul>
        </li>

      <?php endif ?>

      <li class="menu-item">
        <a href="javascript:void(0)" id="profiles"> <span><i class="fa fa-user"></i>Profile </span>
        </a>
      </li>


      <?php if ($_SESSION['role'] == 2 || $_SESSION['role'] == 4): ?>
        <li class="menu-item">
          <a href="javascript:void(0)" data-id="<?= $st->branche_id ?>" id="reparations"> <span><i class="fa fa-spinner fs-16"></i>Réparations</span>
          </a>
        </li>
      <?php endif ?>

      <?php if ($_SESSION['role'] == 1): ?>
        <li class="menu-item">
          <a href="#" class="has-chevron" data-toggle="collapse" data-target="#parametres" aria-expanded="false" aria-controls="parametres"> <span><i class="fa fa-cogs fs-16"></i>Paramètres</span>
          </a>
          <ul id="parametres" class="collapse" aria-labelledby="parametres" data-parent="#side-nav-accordion">
            <!-- <li> <a href="javascript:void(0)" id="roles">Roles</a></li> -->
            <li> <a href="javascript:void(0)" id="devises">Devises</a></li>
            <li> <a href="javascript:void(0)" id="users">Utilisateurs</a></li>
            <li> <a href="javascript:void(0)" id="society">Sociétés</a></li>
            <!-- <li> <a href="javascript:void(0)" id="backup">Backup</a></li> -->
          </ul>
        </li>
      <?php endif ?>
  </ul>
</aside>