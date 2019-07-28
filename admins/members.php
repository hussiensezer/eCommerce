<?php

	/*
	=================================================
	== Manage Members Page
	== You Can Add | Edit | Delete Member From Here
	=================================================
	*/

session_start();

	if(isset($_SESSION['Username'])){
		$pageTitle = "Member";

		include 'init.php';
		
		$do = isset($_GET['action'])? $_GET['action'] : 'Manage';
		
		// Start Manage Page
		if($do == 'Manage'){
				
			// Manage Page
			
		} elseif($do == 'Edit') {
			//Edit Page
			echo 'Welcome To Edit Page';
		}
		include $tpl . 'footer_inc.php';
	} else {
		header('location:index.php');
		
		exit();
	}
?>