<?php
// $title =  ucwords(str_replace('_', ' ', $title));
include('Public/includes/header_.php');
?>


<body class="ms-body ms-aside-left-open ms-primary-theme ms-has-quickbar">
  <!-- Preloader -->
  <?php include('Public/includes/loader.php'); ?>
  <!-- Overlays -->
   
  <!-- <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
  <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>
  Sidebar Navigation Left -->
 
    <!-- Navigation -->
   <?php include('Public/includes/menu.php');?>
   
  <!-- Main Content -->
  <main class="body-content">

    <!-- Navigation Bar -->
    <?php include('Public/includes/toph.php');?>

    <div class="ms-content-wrapper">
      <div class="row">
               

      <div id="page-content"></div>       
        
         
      </div>
    </div>
  </main>
 

</body>

<?php include('Public/includes/footer.php'); ?>