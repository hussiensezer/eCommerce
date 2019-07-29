<?php
session_start();
if(isset($_SESSION['Username'])){
$pageTitle = "Dashboard";
include 'init.php';
	echo "Welcome " . $_SESSION['Username'] . ' Your ID IS :- ' . $_SESSION['Id'];
include $tpl . 'footer_inc.php';
}else {
	header('location:index.php');
	exit();
}
?>