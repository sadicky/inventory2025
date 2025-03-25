<?php
$title = 'Login';
include('Public/includes/header.php');
?>

<body class="ms-body">

  <!-- Preloader -->
  <?php include('Public/includes/loader.php'); ?>
  <!-- Overlays -->
  <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
  <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>

  <!-- <div class="ms-lock-screen-weather">
    <p>38&deg;</p>
    <p>San Francisco, CA</p>
  </div> -->
  <!-- Main Content -->
  <main class="body-content ms-lock-screen">

    <div class="ms-content-wrapper">
      <img class="ms-user-img ms-lock-screen-user" src="assets/img/costic/logo.png" alt="people">
      <!-- <h3>Se Connecter</h3> -->
      <form method="post" autocomplete="off" class="needs-validation" novalidate="">
        <div class="ms-form-group my-0 mb-0 has-icon fs-14">
          <input type="text" class="ms-form-input" name="username" id="validationCustom08" placeholder="Nom d'utilisateur" required="">
          <i class="material-icons">people</i>
        </div><br>
        <div class="ms-form-group my-0 mb-0 has-icon fs-14">
          <input type="password" class="ms-form-input" name="pwd" id="validationCustom09" placeholder="Mot de passe" required>
          <i class="material-icons">password</i>
        </div>
        <button name="login" class="btn bg-gradient-primary w-100">Se connecter</button>
        <p><?php echo $msg; ?></p>

      </form>

    </div>

  </main>

  <div class="ms-lock-screen-time">
    <p><?= date('H:i') ?></p>
    <p><?= date('l, M d') ?></p>
  </div>
</body>

<?php include('Public/includes/footer_.php'); ?>