<?php
require_once('Models/Admin/user.class.php');
require_once('Models/Admin/store.class.php');
require_once('Models/Admin/devise.class.php');
$tiers = new Devise();
$pos = new POS();
$user = new User();

$role = $user->getRoleId($_SESSION['role']);
// var_dump($_SESSION['pos']);
$getDevise2 = $tiers->getDevises2();
$getDevise3 = $tiers->getDevises3();

?>
<nav class="navbar ms-navbar">
  <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft"> <span class="ms-toggler-bar bg-primary"></span>
    <span class="ms-toggler-bar bg-primary"></span>
    <span class="ms-toggler-bar bg-primary"></span>
    <span class="ms-toggler-bar bg-primary"></span>
  </div>
  <div class="logo-sn logo-sm ms-d-block-sm">
    <a class="pl-0 ml-0 text-center navbar-brand mr-0" href="<?= WEBROOT ?>"><img src="assets/img/costic/costic-logo-216x62.png" alt="logo"> </a>
  </div>
  <!-- <div style="float: left;text-align:right;">
    <label>Taux du Jour: <span class="badge badge-primary"><?= $getDevise2->taux ?><?= $getDevise2->short ?> = <?= $getDevise3->taux ?> <?= $getDevise3->short ?> </span></label>
  </div> -->
  <div style="float: left;text-align:right;">
    <?php if ($_SESSION['role'] == 2): ?>
      <strong><a href="javascript:void(0)" id="change_pos" data-id="<?php echo $_SESSION['pos']; ?>"><?php $poss = $pos->getPOS($_SESSION['pos']);
                                                                                                      echo 'POS: ' . $poss->store . ' - ' . $poss->type;  ?> <i class="text-danger fa fa-share-square"></i></a></strong>
    <?php elseif ($_SESSION['role'] == 1): ?>
    <?php else: ?>
      <strong><a href="javascript:void(0)"><?php $poss = $pos->getPOS($_SESSION['pos']);
                                            echo 'POS: ' . $poss->store . ' - ' . $poss->type;  ?></a></strong>
    <?php endif ?>
  </div>
  <div style="float: left;text-align:right;">
    <strong><a href="javascript:void(0)"><?= $role->role; ?> : <?= $_SESSION['noms']; ?> </a></strong>
  </div>
  <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">

    <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2): ?>
      <li class="ms-nav-item"> <a href="javascript:void(0)" id="validations"> Stock <span class="badge badge-danger count"></span></a> </li>
    <?php endif ?>
    <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 2): ?>
      <li class="ms-nav-item"> <a href="javascript:void(0)" id="validations_vente"> Vente <span class="badge badge-danger count_vente"></span></a> </li>
    <?php endif ?>
    <li class="ms-nav-item">
      <a class="media fs-14 p-2" href="<?= WEBROOT ?>logout"> <span><i class="flaticon-shut-down mr-2"></i> Déconnexion</span>
      </a>
    </li>

  </ul>
  <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options"> <span class="ms-toggler-bar bg-primary"></span>
    <span class="ms-toggler-bar bg-primary"></span>
    <span class="ms-toggler-bar bg-primary"></span>
    <span class="ms-toggler-bar bg-primary"></span>
  </div>
</nav>
<div id="toast" class="toast"></div>