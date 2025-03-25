<?php
// $title =  ucwords(str_replace('_', ' ', $title));
include('Public/includes/header.php');
?>


<body class="ms-body ms-aside-left-open ms-primary-theme ms-has-quickbar">
  <!-- Preloader -->
  <?php include('Public/includes/loader.php'); ?>
  <!-- Overlays -->
 
    <!-- Navigation -->
   <?php include('Public/includes/menu.php');?>
   
  <!-- Main Content -->
  <main class="body-content">

    <!-- Navigation Bar -->
    <?php include('Public/includes/toph.php');?>

    <div id="page-content"></div>
    
    <div class="ms-content-wrapper afficher">
      <div class="row">

        <?php echo $contents; ?>
         
      </div>
    </div>
  </main>
 

</body>

<?php include('Public/includes/footer.php'); ?>