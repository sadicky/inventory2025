<?php

function Login()
{
	include('Models/Admin/auth.php');
	include('Vues/Admin/login.php');
}

function forgot()
{
	require_once('Models/Admin/forgot.php');
	include('Vues/forgot-password.php');
}

//Fonction Login
function error404()
{
	// include('Vues/Admin/error404.php');
	if (@$_SESSION['logged']) {
		$title = 'Error 404';
		include('Vues/Admin/error404.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}

//Fonction de la page non trouvée
function error500()
{
	if (@$_SESSION['logged']) {
		include('Vues/Admin/error500.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}
function Logout()
{
	require_once("Models/Admin/user.class.php");
	$user_logout = new User();
	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect(WEBROOT);
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect(WEBROOT);
	}

}

//Fonction du tableua de Board
function Dashboard()
{
	if (@$_SESSION['logged']) {
		
	$title = "Dashboard";
		ob_start();

		include('Vues/Admin/home.php');
		$contents = ob_get_contents();
		ob_get_clean();

		include('Vues/Admin/template.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}

function MyPOS(){
	if (@$_SESSION['logged']) {
	$title = "Point de Vente";
	
		include('Vues/Admin/pos.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}

function Market(){
	if (@$_SESSION['logged']) {
	$title = "Point de Vente";
	
		include('Vues/Admin/market.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}

function ProductTarif()
{
	if (@$_SESSION['logged']) {
		require_once("classes.php");

		$title = "Tarif";
		$id = $_GET['product_id'];

		ob_start();
		$branches = $branches->getBranches();
		$data = $products->getProductId($id);
		$priceData = $products->selectProductPrice2($id);

		include('Vues/Admin/tarif.php');
		$contents = ob_get_contents();
		ob_get_clean();

		include('Vues/Admin/template.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}
function ProductModify()
{
	if (@$_SESSION['logged']) {
		require_once("classes.php");

		$title = "Modification";
		$id = $_GET['product_id'];

		ob_start();
		$categories = $categories->getCategories();
		$branches = $branches->getBranches();
		$data = $products->getProductId($id);
		$priceData = $products->selectProductPrices($id);

		include('Vues/Admin/product_modify.php');
		$contents = ob_get_contents();
		ob_get_clean();

		include('Vues/Admin/template.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}
function Supplier()
{
	if (@$_SESSION['logged']) {
		require_once("classes.php");

		$title = "Fournisseurs";

		ob_start();
		$suppliers = $suppliers->getSuppliers();

		include('Vues/Admin/supplier.php');
		$contents = ob_get_contents();
		ob_get_clean();

		include('Vues/Admin/template.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}

function newSupplier()
{
	if (@$_SESSION['logged']) {
		require_once("classes.php");

		$title = "Fournisseurs";

		ob_start();
		$suppliers = $suppliers->getSuppliers();

		include('Vues/Admin/new_supplier.php');
		$contents = ob_get_contents();
		ob_get_clean();

		include('Vues/Admin/template.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}

function DetailSupplier()
{
	if (@$_SESSION['logged']) {
		require_once("classes.php");

		$title = "Detail du Fournisseur";
		$id = $_GET['id'];

		ob_start();
		$view = $suppliers->getSupplier($id);

		include('Vues/Admin/detail_supplier.php');
		$contents = ob_get_contents();
		ob_get_clean();

		include('Vues/Admin/template.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}

function Commandes()
{
	if (@$_SESSION['logged']) {
		require_once("classes.php");

		$title = "Gestion des commandes";
		ob_start();

		include('Vues/Admin/commandes.php');
		$contents = ob_get_contents();
		ob_get_clean();

		include('Vues/Admin/template.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}




function Products()
{
	if (@$_SESSION['logged']) {
		require_once("classes.php");

		$title = "Tous les produits";
		
		ob_start();
		$cats = $categories->getCategories();
		$datas = $products->getProducts();

		include('Vues/Admin/products.php');
		$contents = ob_get_contents();
		ob_get_clean();

		include('Vues/Admin/template.php');
	} else {
		include('Vues/Admin/error500.php');
	}
}
