<?php
@session_start();
require_once('../../Models/Admin/achat.class.php');
require_once('../../Models/Admin/branches.class.php');
$trans=new Transactions();
$pers=new Personne();
?>
<div class="card">
    <div class="card-header">
      <?php
      
        echo '<h5>'.$_GET['caisse'].'/ Rapport de la trésorerie / Période du '.$_GET['from_d'].' au '.$_GET['to_d'].'</h5>';
      $from_d=$_GET['from_d'];
      $to_d=$_GET['to_d'];
      
      $caisse=$_GET['caisse'];
      ?>
    </div>
<div class="card-body">

<table class="table table-bordered table-striped table-sm" id="example23">
  <thead>
    <tr><th>Date</th><th>Libellé</th><th>Entrée</th><th>Sortie</th><th>Solde</th></tr>
  </thead>
  <tbody>
    <?php
    $solde=0;
    $ant=$trans->select_op_an_date_type($from_d,$caisse);
    $solde +=$ant;
     echo '<tr><td>'.$from_d.'</td><td>Solde Antérieur</td><td>'.$ant.'</td><td>-</td><td>'.$solde.'</td></tr>';
    while (strtotime($from_d) <= strtotime($to_d)) {
        $datas=$trans->select_op_by_date_type($from_d,$caisse);
        foreach ($datas as $key => $value) {
          if($value['status']=='IN'){
            $solde +=$value['mont'];
          echo '<tr><td>'.$value['create_date'].'</td><td>'.$value['descript'].'</td><td>'.$pers->nb_format($value['mont']).'</td><td>-</td><td>'.$pers->nb_format($solde).'</td></tr>';
                }
                else
                  {
                    $solde -=$value['mont'];
                     echo '<tr><td>'.$value['create_date'].'</td><td>'.$value['descript'].'</td><td>-</td><td>'.$pers->nb_format($value['mont']).'</td><td>'.$pers->nb_format($solde).'</td></tr>';
                  }
        }
        $from_d = date ("Y-m-d", strtotime("+1 day", strtotime($from_d)));
    }
    ?>
  </tbody>
</table>
</div>
</div>
    </div>
        <div class="card-footer">

        </div>
        </div>
