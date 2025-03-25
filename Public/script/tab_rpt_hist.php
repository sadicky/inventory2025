<?php
@session_start();
?>
<div class="ms-panel" style="margin:30px;">
  <div class="ms-panel-header text-center">
    <h3>Historique des opérations du stock</h3>
    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        --- Choisir ---
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="javascript:void(0)" id="hist_sale">Historique de ventes</a>
        <a class="dropdown-item" href="javascript:void(0)" id="hist_dette">Historique de Dettes</a>
        <a class="dropdown-item" href="javascript:void(0)" id="hist_achat">Historique d'Approvisionnement</a>
        <a class="dropdown-item" href="javascript:void(0)" id="hist_repa">Historique des Réparations</a>
        <a class="dropdown-item" href="javascript:void(0)" id="hist_change">Historique de transferts</a>
        <a class="dropdown-item" href="javascript:void(0)" id="hist_sort">Historique de sorties</a>
      </div>
    </div>
  </div>
  <div class="ms-panel-body card-block" id="second-content">

  </div>
</div>