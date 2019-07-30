<?php

	/* 
	**getTitle v.1
	** Title Function That Echo The Page Title In Case The Page
	** Has The Variable $PageTitle And Echo Defult Title For Other Page
	*/

function getTitle() {
	global $pageTitle;
	
	if(isset($pageTitle)){
		echo $pageTitle;
	}else {
		echo 'Default';
	}
}

	/*
	** Home Redirect Function v.2
	** This Function Accept Parameters
	** $errorMsg = Echo The Error Message
	** $seconds  = Seconds Before Redirecting
	** $path 	 = The Path This will Redirecting To
	*/
function redirectHome($theMsg, $path = null, $seconds = 3){
	
	
	
	
	if($path === null){
		
		$path = 'dashboard.php';
		$link = "Home Page";
	} else{
		
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
			$path = $_SERVER['HTTP_REFERER'];
			$link = 'Previous Page';
		}else {
			$path = 'dashboard.php';
			$link = "Home Page";
		}
	} 
	echo $theMsg;
	echo "<div class='alert alert-info'> You Will be Redirected To<b> {$link} </b> After<b> {$seconds} Seconds </b></div>";

	header("refresh:$seconds; url=$path");
	
	exit();
}

	/*
	**Check Items Function V1.0
	** Function To Check Item In Database [function accept Parameters]
	** $select = The Item To Select [Example: User, Item, Category]
	** $from = The Table To Select From [Example: Users, Items ,Categories]
	** $value = The Value Of Select [Example: Hassan, Box, Electronics]
	*/

function checkItem($select, $from, $value) {
	
	global $con;
	$statement = $con->prepare("SELECT {$select} FROM {$from} WHERE {$select} = ?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	
	return $count;
}