<?php
@session_start();
require_once '../../Models/Admin/personnne.class.php';
$perso= new Personne();

if(empty($_POST['keyword']))
{
$keyword='-*';
}
else
{
$keyword=$_POST['keyword'];
}

$list=$perso->select_all_role_srch('client',$keyword);


foreach ($list as $rs) {

  $name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['nom_complet']);
   echo '<li class="choose_cli"  data-id="'.$rs['personne_id'].'" onclick="set_item_cli(\''.$rs['nom_complet'].'\')">'.$name.'</li>';
}
?>
