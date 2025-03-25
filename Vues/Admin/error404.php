<?php 
$title = 'Page Not Found';
include('Public/includes/header.php');?>
<!-- Main Content -->
<main class="body-content ms-error-404">

    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <i class="flaticon-computer"></i>
        <h1>Error 404</h1>
        <h3>Page non trouvée</h3>
        <a href="<?= WEBROOT ?>" class="btn btn-white"> <i class="material-icons">arrow_back</i>Se connecter</a>

    </div>

</main>
<?php include('Public/includes/footer.php');?>