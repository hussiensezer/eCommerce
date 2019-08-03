<?php

session_start();

$pageTitle = '';

if(isset($_SESSION['Username'])) {
	
	include 'init.php';
	
	$do = isset($_GET['action']) ? $_GET['action'] : 'Manage';
	
	 // Start Management Part
	if($do == 'Manage') {
		
		echo 'Welcome To Mangement ';
		
	 // End Management Part
		
		
	 // Start Add Part
	} elseif($do == 'Add') {
		
		echo 'Welcome To Add';
	 // End Add Part	
		
	 // Start Insert Part	
	} elseif($do == 'Insert' ) {
		
		echo 'Welcome To Insert';
	
	 // End Insert Part
		
		
	 // Start Edit Part	
	}elseif ($do == 'Edit') {
		echo 'Welcome To Edit';
		
		
	 // End Edit Part	
		
	
	 // Start Update Part
	}elseif($do == 'Update') {
		
		echo 'Welcome To Update';
		
	 // End Update Part
		
	 // Start Delete Part
	} elseif($do == 'Delete') {
		
		echo 'Welcome To Delete';
		// End Delete Part
		
		
		// Start Active Part
	}elseif($do == 'active') {
		
		echo 'welcome to active';
	}
	// End Active Part

	
	include $tpl . 'footer_inc.php';
}else {
	
	header('Location:index.php');
	exit();
	
}


?>