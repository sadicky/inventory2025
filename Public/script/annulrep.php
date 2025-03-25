<?php

require_once('../../Models/Admin/autresfrais.class.php');
$cat = new AutreFrais();
$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($id) {
	$active = $cat->annulRep($id);
	if ($active) echo "avec succes";
	else echo "non ajoute";
}
