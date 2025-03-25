<?php
@session_start();
?>
<div class="card" style="margin: 30px;">
<div class="card-header text-center">
<h3>Rapport du stock</h3>
<div class="dropdown text-center" >
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    --- Choisir ---
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="javascript:void(0)" id="rap_situ_stk_gen">Stock Général</a>
    <a class="dropdown-item" href="javascript:void(0)" id="syn_per">Mouvement Périodique</a>
    <a class="dropdown-item" href="javascript:void(0)" id="rap_fiche_stk">Fiche du stock</a>
    <a class="dropdown-item" href="javascript:void(0)" id="rap_inv">Rapport d'inventaire</a>
  </div>
</div>
</div>
<div class="card-body card-block" id="second-content"> 

</div>
</div>
