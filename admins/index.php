<?php
session_start();
$noNavbar = "";
$pageTitle = "Login";
if(isset($_SESSION['Username'])){
	header('location: dashboard.php');
}
include "init.php";


	// Check If User Coming Form HTTP POST Request
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$hashedPass = sha1($pass); // For Incrept the Password
		
	// Check If The User Exist In DataBase

		$stmt = $con->prepare("SELECT
									UserId, Username, Password
								FROM 
									users
								WHERE
									Username = ?
								AND 
									Password = ?
								And
									GroupId = 1
								LIMIT 1");
		
		$stmt->execute(array($user,$hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
			//If Count >0 This Mean The DataBase Contain Record About This Username
		if($count > 0) {
			$_SESSION['Username'] = $user; // Register Session Name
			$_SESSION['Id'] = $row['UserId']; // Register Session ID
			header('location: dashboard.php');// Redirect To DashBoard Page
			exit();
		}
	}
?>


<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
	<h4 class="text-center mb-3">Admin Login</h4>
	<div class="form-group">
		<input type="text" class="form-control" name="user" placeholder="Username" autocomplete="off">
		<i class="fas fa-user fa-fw"></i>
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="pass" placeholder="Password" autocomplete="off">
		<i class="fas fa-lock fa-fw"></i>
	</div>
	
		<input type="submit" class="btn btn-primary btn-block" value="Login">


</form>




<?php include $tpl . 'footer_inc.php';?>


