<?php
	include 'connection.php';

	//Routes
	
	$tpl = 'include/template/';  // Template Directory
	$lang = 'include/languages/'; //Languages Directory
	$func = 'include/functions/';//Functions Directory
	$css = 'layout/css/'; // CSS Directory
	$js = 'layout/js/'; //JS Directory


// Include The Important Files

	include $func . 'function.php';
	include $lang. "english.php"; // Languages File Are First 
	include $tpl . 'header_inc.php';


// Include Navbar On All Pages Expect The One With $noNavBar Vairable

	if(!isset($noNavbar)){
	include $tpl . 'navbar_inc.php';
	}