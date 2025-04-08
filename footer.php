<?php
require_once("Models/Admin/connexion.php");
require_once('Models/Admin/user.class.php');
require_once('Models/Admin/periode.class.php');
require_once('Models/Admin/journal.class.php');
require_once('Models/Admin/store.class.php');
$users = new User();
$periodes = new Periode();
$jour = new Journal();
$pos = new POS();

$db = getConnection();
if (!isset($_SESSION['pos'])) {
  $posId = $pos->getPOS(@$_SESSION['pos']);
  @$_SESSION['pos'] = $posId->store_id;
} else {
  $pos_id = $pos->getPOS(@$_SESSION['pos']);
}


if (!isset($_SESSION['jour'])) {
  if (!empty($jour_id))
    $_SESSION['jour'] = $jour_id;
  else {
    $_SESSION['jour'] = $jour->insert_2(@$_SESSION['id'], $_SESSION['pos'], date('Y-m-d'));
  }
} else {
  $jour_id =  $jour->getJournal($_SESSION['jour']);
}


$jours = $jour->select($_SESSION['jour']);
@$_SESSION['start_date'] = $jours->start_date;


?>


<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-4" style="margin-top: 20px;">
    <form class="form-inline" id="form_open_day">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <i for="ouverture">Jour d'Ouverture : <b class="text-danger"><?php echo @$_SESSION['start_date'];  ?></b></i>
            <input type="hidden" name="open_bal" value="0" placeholder="Balance d'Ouverture" class="form-control-sm">
            <input class="custom-select" type="date" name="open_date" id="open_date" value="<?php if (!empty(@$_SESSION['start_date'])) echo  date("Y-m-d", strtotime("+1 days", strtotime(@$_SESSION['start_date'])));
                                                                                            else echo date('Y-m-d'); ?>">
          </div>
          <div class="col-md-6">
            <button type="submit" class="ms-btn-icon btn-primary"><i class="fa fa-folder-open"></i></button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-6"></div>
</div>
<!-- SCRIPTS -->
<!-- Global Required Scripts Start -->

<script src="assets/js/jquery-3.5.0.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/perfect-scrollbar.js"></script>
<!-- Global Required Scripts End -->


<script src="assets/js/slick.min.js"> </script>
<script src="assets/js/moment.js"> </script>
<script src="assets/js/jquery.webticker.min.js"> </script>
<script src="assets/js/Chart.bundle.min.js"></script>
<script src="assets/js/widgets.js"></script>
<script src="assets/js/Chart.Financial.js"></script>
<script src="assets/js/d3.v3.min.js"></script>
<script src="assets/js/topojson.v1.min.js"></script>
<script src="assets/js/datatables.min.js"></script>
<script src="assets/js/data-tables.js"></script>
<script src="assets/js/toast.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/codebar.js"></script>
<!-- Costic core JavaScript -->
<script src="assets/js/framework.js"></script>
<!-- Settings -->
<script src="assets/js/settings.js"></script>

<!-- Script ajax -->
<script type="text/javascript" src="Public/ajax/user.js"></script>
<script type="text/javascript" src="Public/ajax/branche.js"></script>
<script type="text/javascript" src="Public/ajax/category.js"></script>
<script type="text/javascript" src="Public/ajax/product.js"></script>
<script type="text/javascript" src="Public/ajax/supplier.js"></script>
<script type="text/javascript" src="Public/ajax/treso.js"></script>
<script type="text/javascript" src="Public/ajax/commande.js"></script>
<script type="text/javascript" src="Public/ajax/caisse.js"></script>
<script type="text/javascript" src="Public/ajax/achat.js"></script>
<script type="text/javascript" src="Public/ajax/stock.js"></script>
<script type="text/javascript" src="Public/ajax/vente.js"></script>
<script type="text/javascript" src="Public/ajax/depense.js"></script>
<script type="text/javascript" src="Public/ajax/join.js"></script>
<script type="text/javascript" src="Public/ajax/customer.js"></script>
<script type="text/javascript" src="Public/ajax/join.js"></script>
<!-- <script type="text/javascript" src="Public/ajax/sync_db.js"></script> -->


<script>
  $(document).ready(function() {
    function load_notif(view = '') {
      $.ajax({
        url: 'Public/script/valid.php',
        method: "POST",
        data: {
          view: view
        },
        dataType: 'json',
        success: function(data) {
          if (data.unseen >= 0) {
            $('.count').html(data.unseen)
          }
        }
      });
    }

    function load_vente(view_vente = '') {
      $.ajax({
        url: 'Public/script/valid_vente.php',
        method: "POST",
        data: {
          view_vente: view_vente
        },
        dataType: 'json',
        success: function(data) {
          if (data.unseen >= 0) {
            $('.count_vente').html(data.unseen)
          }
        }
      });
    }
    load_vente();
    load_notif();
  });
</script>
</body>

</html>