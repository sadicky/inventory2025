<?php
function getConnection()
{

	try{
	    
	$db=new PDO('mysql:host=web58.lws-hosting.com;dbname=c2533323c_marcopharma','c2533323c_marcopharma','2bMmFf6gy9vBA3F');
	
    // Définir le mode d'erreur de PDO pour les exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
	return $db;
	
	}catch(PDOException $e){
	     echo "Erreur de connexion à la base de données : " . $e->getMessage();
	}
}
