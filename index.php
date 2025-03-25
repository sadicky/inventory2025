<script>
// if ('serviceWorker' in navigator) {
//   window.addEventListener('load', () => {
//     navigator.serviceWorker.register('sw.js')
//       .then(registration => {
//         console.log('Service Worker enregistré avec succès :', registration.scope);
//       })
//       .catch(error => {
//         console.error('Échec de l’enregistrement du Service Worker :', error);
//       });
//   });
// }

</script>


<?php
session_start();
define('WEBROOT', str_replace('index.php', "", $_SERVER['SCRIPT_NAME']));
date_default_timezone_set('Africa/Bujumbura');


include 'Ctrl/Admin.php';
// var_dump($lang);die();
if (isset($_GET['p'])) {
	$params = explode('/', $_GET['p']);
	//die(print_r($params));
	$_SESSION['action'] = '';
	$action = $params[0];
	$d = preg_split("#[-]+#", $action);
	// var_dump($d);die();
	$n = count($d);
	if ($n > 1) {
		$action = $d[0];
	}

	if ($_GET['p'] == 'login') {
		Login();
	}

	//url pour le dashboard
	else if ($_GET['p'] == 'logout') {
		Logout();
	} //url pour le dashboard
	else if ($_GET['p'] == 'dashboard') {
		Dashboard();
	}else if ($_GET['p'] == 'ProductTarif') {
		ProductTarif();
	}else if ($_GET['p'] == 'ProductMod') {
		ProductModify();
	}else if ($_GET['p'] == 'fournisseurs') {
		Supplier();
	}else if ($_GET['p'] == 'newsupplier') {
		newSupplier();
	}else if ($_GET['p'] == 'DetailSupplier') {
		DetailSupplier();
	}else if ($_GET['p'] == 'commandes') {
		Commandes();
	}else if ($_GET['p'] == 'pos') {
		MyPOS();
	}else if ($_GET['p'] == 'market') {
		Market();
	}else if ($_GET['p'] == 'products') {
		Products();
	}
	//pour la page non trouvee 
	else {
		error404();
	}
} else {
	Login();
}
