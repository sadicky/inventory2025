<?php
if(isset($_SESSION['op_cmd_id']))
{
?>
<div id="rapport">
  <table class="table table-bordered table-striped table-condensed display" cellspacing="0" width="100%" border="1">
    <thead>
      <tr>
        <th colspan="5">
          <?php include('../entete.php');?>
        </th>
      </tr>
      <tr>
        <th colspan="5">
          Bon de commande N° <?php echo $achat->getNumAchat(); ?><br/>
          Date : <?php echo $op->getCreateDate();?>
        </th>
      </tr>
      <tr>
        <th>Produit</th><th>Prix</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $datas2=$det->select_all($_SESSION['op_cmd_id']);
      $tot =0;
      foreach ($datas2 as $un) {
        $prod->select($un['prod_id']);
        echo '<tr><td >'.$prod->getProdName().'</td><td>'.number_format($un['quantity']).'</td></tr>';
      }
      ?>
    </tbody>
  </table>
</div>
<?php
}
?>