<?php

/*
	Categories => [Mange | Edit | Upade | Add | Insert | Delete| Stats]
*/

$do = isset($_GET['action'])? $_GET['action'] : 'Manage';


if($do == 'Manage') {
	
	echo 'Welcome You Are in Manage Categories';
	
	echo '<a href="?action=Insert"> Add New Category </a> ';
	
	echo '<a href="?action=Delete"> Remove a Category </a> ';
	
}else if($do == 'Insert') {
	
	echo "Welcome You Will Insert A New Category";
	
}else if ($do = 'Delete') {
	
	echo " Hello You Need To Delete A Category";
}