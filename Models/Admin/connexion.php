<?php
function getConnection()
{
	$db = new PDO("mysql:host=localhost;dbname=db_my_store", "root", "");

	// $db=new PDO('mysql:host=web58.lws-hosting.com;dbname=c2533323c_marcopharma','c2533323c_marcopharma','2bMmFf6gy9vBA3F');
	return $db;
}
