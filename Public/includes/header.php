<!DOCTYPE html>
<html lang="fr" class="js">

<head>
  <meta charset="utf-8">
  <meta name="author" content="Sadicky Dave">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Marco Pharma">
  <!-- Fav Icon  -->
  <title><?= $title ?></title>

  <!-- Iconic Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="assets/vendors/iconic-fonts/flat-icons/flaticon.css">
  <link rel="stylesheet" href="assets/vendors/iconic-fonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="assets/vendors/iconic-fonts/cryptocoins/cryptocoins.css">
  <link rel="stylesheet" href="assets/vendors/iconic-fonts/cryptocoins/cryptocoins-colors.css">
  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery UI -->
  <link href="assets/css/jquery-ui.css" rel="stylesheet">
  <!-- Page Specific CSS (Slick Slider.css) -->
  <link href="assets/css/slick.css" rel="stylesheet">
  <link href="assets/css/fontawesome.css" rel="stylesheet">
  <link href="assets/css/datatables.min.css" rel="stylesheet">
  <!-- Costic styles -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/select2.css" rel="stylesheet">
  <link href="assets/css/toastr.min.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon.ico">

  <style type="text/css">
    input,
    select,
    button,
    a,
    label,
    td,
    th {
      font-size: 16px;
      font-weight: bold;
      color: black;
    }

    h1,
    h2,
    h3,
    h4,
    h5 {
      font-size: 20px;
      font-weight: bold;
    }

    #page-contentx {
      /* background-image: url("assets/img/costic/costic-logo.png"); */
    }

    .toast {
      visibility: hidden;
      min-width: 250px;
      background-color: #d9534f;
      color: white;
      text-align: center;
      border-radius: 5px;
      padding: 16px;
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 1000;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
      font-size: 14px;
    }

    .toast.show {
      visibility: visible;
      animation: fadein 0.5s, fadeout 0.5s 3s;
    }

    @keyframes fadein {
      from {
        opacity: 0;
        bottom: 20px;
      }

      to {
        opacity: 1;
        bottom: 30px;
      }
    }

    @keyframes fadeout {
      from {
        opacity: 1;
        bottom: 30px;
      }

      to {
        opacity: 0;
        bottom: 20px;
      }
    }
  </style>
</head>