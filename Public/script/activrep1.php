<?php
require_once('../../Models/Admin/autresfrais.class.php');
$cat = new AutreFrais();
$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($id) {
	$active = $cat->activRep1($id);
	if ($active) echo "avec succes";
	else echo "non ajoute";
}
