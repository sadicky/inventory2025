<?php
require_once '../../Models/Admin/connexion.php';
//    var_dump($_POST['depot']);die();
$db = getConnection();

$data = $db->prepare("SELECT sum(quantity) as QTE FROM tbl_stocks where product_id = ? and pos_id=?");
$data->execute(array($_POST['prod_id'],$_POST['pos_id']));

$rc = $data->fetchObject();
if (empty($rc->QTE)){
    echo "(<span style='color:red'>Dispo: 0</span>)";
    echo "<input value='0' type='hidden' name='qqte' id='qqte'>";
} 
else {
    echo "(<span style='color:blue'>Dispo:". number_format($rc->QTE)."</span>)";
// var_dump($rc);
// die();

echo "<input value='$rc->QTE' type='hidden' name='qqte' id='qqte'>";
}
// echo "<span  id='qqt' style='color:red'>$rc->QTE</span>";
