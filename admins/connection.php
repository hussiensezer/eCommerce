<?php
$dsn = 'mysql:host=localhost;dbname=shop';
$user = 'root';
$pass = '';
$options = array(
PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
);

try{
	
	$con = new PDO($dsn,$user,$pass,$options);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	/*$q = "INSERT INTO users (Username) VALUES ('حسين')";
	$db->exec($q);*/
	
}
catch(PDOException $e){
	echo 'Faild' . $e->getMessage();
}

?>