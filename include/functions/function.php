<?php

/*
** Get Categories Function 1.0 
** Function To Get Categories From Datebase 
*/
function getCat() {
	global $con;
	$getcat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
	$getcat->execute();
	$cat = $getcat->fetchAll();

	return	$cat;
}





/*
** Get  Items Function 1.0 
** Function To Get Categories From Datebase 
*/
function getItems($catId) {
	global $con;
	$getItems = $con->prepare("SELECT * FROM items WHERE Cat_ID = ? AND Approve = 1 ORDER BY Item_Id DESC");
	$getItems->execute(array($catId));
	$items = $getItems->fetchAll();

	return	$items;
}
































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


/*
** Count Number Of Items Function v1.0
** Function To Count Number Of Items Rows
** $item = The Item To Count
** $table = The Table To Choose From
*/

function countItems($item, $table){
	global $con;
	$stmt2 = $con->prepare("SELECT COUNT({$item}) FROM {$table}");
	 $stmt2->execute();
	
	return $stmt2->fetchColumn();
}


/*
**
**
**
*/
/*function getLatest($select,$from,$orderBy,$type,$limit) {
	global $con;
	$return =  '';
	$stmt3 = $con->prepare("SELECT {$select} FROM {$from} ORDER BY {$orderBy} {$type} LIMIT {$limit} ");
	$stmt3->execute();
	$get = $stmt3->fetchAll();
	foreach($get as $value) {
		
		$return .= "<li class='latest-li alert alert-info'> {$value[$select]} </li>";
	};
	
	return	$return;
}*/






/*
** Get Latest Records Function V2.0 {We Add Where Condition}
** Function To Get Latest Item From Datebase [user,Item, Comments]
** $select = Field To Select
** $table  = The Table To Choose From
** $orderby = What the Field i'll order by it [ ORDER by UserId, Order By Name ]
** $limit = Number of Latest i ned to get
** $WHERE = if u have a condition like GroupId != 0 if u dont have a coniditon leave it empty it's will take a default value 1
*/
function getLatest($select, $table, $orderBy, $limit = 5 , $WHERE = 1 ) {
	global $con;
	$return =  '';
	$stmt3 = $con->prepare("SELECT {$select} FROM {$table}  WHERE {$WHERE} ORDER BY {$orderBy} DESC   LIMIT {$limit} ");
	$stmt3->execute();
	$get = $stmt3->fetchAll();

	return	$get;
}