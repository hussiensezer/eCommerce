<?php
session_start();
$noNavbar = "";
$pageTitle = "Login";

if(isset($_SESSION['user'])){
	header('location: index.php');
}
include 'init.php';

	// Check If User Coming Form HTTP POST Request
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashedPass = sha1($password); // For Incrept the Password
		
	// Check If The User Exist In DataBase

		$stmt = $con->prepare("SELECT
									 Username, Password
								FROM 
									users
								WHERE
									Username = ?
								AND 
									Password = ?");
		
		$stmt->execute(array($username,$hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
			//If Count >0 This Mean The DataBase Contain Record About This Username
		if($count > 0) {
			$_SESSION['user'] = $username; // Register Session Name
			$_SESSION['id'] = $row['UserId']; // Register Session ID
			header('location: index.php');// Redirect To home Page
			exit();
		  }    // If i Come From SignUp Form
        }elseif(isset($_POST['signup'])) {  
            
            $formErrors = [];
            
            // Validate For Name
            if(isset($_POST['name'])){
                
                $filterUser = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
                
                if(strlen($filterUser) < 2) {
                        $formErrors[] = "Username Field Must Be More Then 2 Characters";
                }
            }
           // Validate For Password
            if(isset($_POST['password']) && isset($_POST['password2'])) {
                if(empty($_POST['password'])){
                    $formErrors[] = "The Password Field Can't Be Empty";
                }
                
                $pass1 = sha1($_POST['password']);
                $pass2 = sha1($_POST['password2']);
                
                if($pass1 !== $pass2) {
                    
                    $formErrors[] = "The Password Field Not Matched With Other Type It Again";
                }
            }
           // Validate For Email
            if(isset($_POST['email'])) {
                $filterEmail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true){
                    $formErrors[] = "This Not A Valid Email";
                }
    
            }
            
        }else {
            echo 'You Trying To Do Somthing Bad Take Care';
        }
	}
?>


<div class="form" >
	<div class="container  pad">
		<h1 class="text-center">
			<span class="active" data-class="login">Login </span>|
			<span data-class="signup">Signup</span>
		</h1>
		<form class="login form-container" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
			<div class="form-group">
				<input type="text"  name="username" class="form-control" Placeholder="Enter Your name" required>
			</div>
		
			<div class="form-group">
				<input type="password"  name="password" class="form-control" Placeholder="Enter Your Password" required>
			</div>
			<input type="submit" class="btn btn-primary"  name="login" value="Login">
		</form>	
		
		
		
		
			
		<form class="signup form-container" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
			<div class="form-group">
				<input type="text"  name="name" class="form-control" Placeholder="Enter Your name" pattern=".{4,}" title="Username Must Be 4Chars At Less" required>
			</div>
		
			<div class="form-group">
				<input type="password"  name="password" class="form-control" Placeholder="Enter Your Password" minlength="4" required >
			</div>
			<div class="form-group">
				<input type="password"  name="password2" class="form-control" Placeholder="Enter Your Password"  minlength="4" required>
			</div>
			<div class="form-group">
				<input type="email"  name="email" class="form-control" Placeholder="Enter Your email" required >
			</div>
			<input type="submit" class="btn btn-success" value="Signup" name="signup">
		</form>
		
	</div>
</div>
<div class="text-center form-errors">
    <div class='container'>
<?php
    if(!empty($formErrors)) {
        
        foreach($formErrors as $error) {
            echo "<div class='alert alert-danger errors '> {$error} </div>";
        }
    }  
?>
    </div>
</div>
<?php include $tpl . 'footer_inc.php';?>