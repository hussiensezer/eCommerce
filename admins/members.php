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
			
		} elseif($do == 'Edit'){ //Edit Page 
			
		//Check If Get Request userId Is Numeric & Get The Integer Value Of It
		$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			
	
		// Select All Data Depend On This Id	
		$stmt = $con->prepare("SELECT * FROM users WHERE UserId = ?LIMIT 1");
		
		// Execute Query	
			
		$stmt->execute(array($userId));
			
		// Fetch The Data	
			
		$row = $stmt->fetch();
			
		// The Row Count
		$count = $stmt->rowCount();
			
			if($count > 0 && $userId == $_SESSION['Id']) {
		?>
		
			<!-- Start Form -->
	<div class="container edit-member">
		<h1 class="text-center mt-3">Edit Member </h1>
	
		<form class="contact-form" action="?action=Update" method="POST">
			<input type="hidden" name="userid" value="<?php echo $userId?>"/>
			<div class="form-group">
				<input type="text"
					   class="form-control username"
					   name="username"
					   placeholder="Type Your UserName"
					   autocomplete=off
					   value="<?php echo $row['Username']?>"
					   >
				<i class="fas fa-user fa-fw"></i>
			

			</div>
			<div class="form-group">
				<input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>">
				<input type="password"
					   class="form-control"
					   name="newpassword" 
					   placeholder="Enter Your Password"
					   autocomplete = "new-password">
				<i class="fas fa-lock fa-fw"></i>

			</div>
			
			<div class="form-group">
				<input type="email"
					   class="email form-control"
					   name="email"
					   placeholder="Please Type A Valid Email"
					   autocomplete=off
					   value="<?php echo $row['Email']?>">
				<i class="fas fa-envelope fa-fw"></i>
				
			</div>
			
			<div class="form-group">
			<input type="text"
					   class="email form-control"
					   name="fullname"
					   placeholder="Please Type Your Full Name"
				   	 autocomplete=off
				   value="<?php echo $row['FullName']?>">
				<i class="fas fa-signature fa-fw"></i>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-success " value="Update">
				<i class="fas fa-paper-plane fa-fw"></i>
			</div>
			
		</form>
	</div>
	<!-- End Form -->

<?php		//Else Show Error Message
			}else {
				echo "This Not A Valid Id For This Account";
				
			}	
		
		} elseif($do == 'Update') { //Update Page
			echo '<h1 class="text-center mt-3">Update Member </h1>' ;
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				//Get Variables From The Form
				
				$id = $_POST['userid'];
				$name = $_POST['username'];
				$email = $_POST['email'];
				$full = $_POST['fullname'];
			// Password Trick
				
			$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
				

				
				//Update The DataBase With This Info
				$stmt = $con->prepare("UPDATE users SET Username = ?, Password = ?, Email = ?, FullName = ? WHERE UserId = ?");
				$stmt->execute(array($name, $pass, $email, $full, $id));
				
				// Echo Success Message
				echo "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
				
			}else {
				echo "<div class='alert alert-danger'><b>Error </b>Sorry You Can't Browse This Page Direcly</div>";
			}
		}
		include $tpl . 'footer_inc.php';
	} else {
		header('location:index.php');
		
		exit();
	}
?>