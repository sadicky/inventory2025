<?php
@session_start();
require_once '../../Models/Admin/category.class.php';
$cat= new Category();
$keyword=$_POST['search'];

$list=$cat->select_all_srch_cat($keyword);

foreach ($list as $row) {
	$response[] = array("value"=>$row['category_id'],"label"=>$row['category_name']);
}
echo json_encode($response);
?>
