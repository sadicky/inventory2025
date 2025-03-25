 <?php

    require_once("../../Models/Admin/customer.class.php");
    require_once("../../Models/Admin/personne.class.php");
    $customers = new Customer();
    $personnes = new Personne();
    $title = "Tous les clients";
    $datas = $customers->select_all();

    ?>
 <div class="col-md-12">
     <nav aria-label="breadcrumb">
         <ol class="breadcrumb pl-0">
             <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
             <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
         </ol>
     </nav>

     <div class="ms-panel">

         <div class="ms-panel-header">
             <h3><?= $title ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><a href="javascript:void(0)" style="text-align:left;" id="newcustomer"><i class="fa fa-plus"></i> Nouveau Client</a></span></h3>

         </div>
         <div class="ms-panel-body">

             <table id="data-table" class="table table-bordered table-sm table-striped display">
                 <thead>
                     <tr>
                         <th>Nom Complet(Raison Sociale)</th>
                         <th>NIF(RCCM)</th>
                         <th>Tél</th>
                         <th>E-mail</th>
                         <th>Adresse</th>
                         <th>-</th>
                         <th>-</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        foreach ($datas as $un) {
                            echo '<tr><td><a href="javascript:void(0)" class="choose_cust2" id="' . $un->personne_id . '">' . $un->nom_complet . '</a></td><td>' . $un->customer_num . '</td><td>' . $un->contact . '</td><td>' . $un->email . '</td><td>' . $un->adresse . '</td>';
                            echo '<td>

                             <a href="javascript:void(0)" class="choose_cust2" id="' . $un->personne_id . '"><i class="fa fa-file"></i></a>';
                            echo '</td>';
                            echo '<td>';

                            if (!$personnes->exist_party($un->personne_id)) {
                                echo '<a href="javascript:void(0)" class="trash_sale" id="' . $un->personne_id . '" data-id="customer"><i class="fa fa-times"></i></a>';
                            } else {
                                echo '-';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    
                        ?>
                 </tbody>
             </table>

         </div>
         

     </div>
     <div style="padding-top: 20px;"></div>
 </div>

 <script src="assets/js/data-tables.js"></script>