<?php

function lang($phrase) {
	static $lang = array(
		//Title Pages 
		
		'DASHBOARD' 	 => 'DashBoard',
		//NavBar Lists
		'LOGO' 			 => 'Admin Board',
		'CATEGOTIES'	 => 'Categoties',
		'HOME' 			 => "Home",
		'ITEMS'			 => "Items",
		'MEMBERS'		 => 'Members',
		'STATISTIC'		 => 'Statistics',
		'LOGS'			 => 'Logs',
		'EDIT'			 => 'Edit Profile',
		'SETTING'		 => 'Setting',
		'OUT'			 => 'LogOut'
	);
	
	return $lang[$phrase];
}
?>