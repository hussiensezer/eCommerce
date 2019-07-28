<?php
session_start();
if(isset($_SESSION['Username'])){
$pageTitle = "Dashboard";
include 'init.php';
	echo "Welcome";
include $tpl . 'footer_inc.php';
}else {
	header('location:index.php');
	exit();
}
?>