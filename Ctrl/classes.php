<?php

require_once('Models/Admin/achat.class.php');
require_once('Models/Admin/branches.class.php');
require_once('Models/Admin/caisse.class.php');
require_once('Models/Admin/category.class.php');
require_once('Models/Admin/commande.class.php');
require_once('Models/Admin/detOperation.class.php');
require_once('Models/Admin/journal.class.php');
require_once('Models/Admin/operation.class.php');
require_once('Models/Admin/product.class.php');
require_once('Models/Admin/periode.class.php');
require_once('Models/Admin/store.class.php');
require_once('Models/Admin/supplier.class.php');
require_once('Models/Admin/user.class.php');
require_once('Models/Admin/autresfrais.class.php');
require_once('Models/Admin/transaction.class.php');
require_once('Models/Admin/tarif.class.php');
require_once('Models/Admin/sortie.class.php');
require_once('Models/Admin/personne.class.php');

$achats = new Achat();
$branches = new Branches();
$caisses = new Caisse();
$categories = new Category();
$commandes = new Commande();
$details = new detOperation();
$journals = new Journal();
$operations = new Operation();      
$products = new Product();  
$periodes = new Periode();
// $stores = new POS();
$suppliers = new Supplier();       
$users = new User(); 
$autres = new AutreFrais(); 
$transactions = new Transactions(); 
$tarifs = new Tarif();
$sorties = new Sortie();
$personnes = new Personne();

?>