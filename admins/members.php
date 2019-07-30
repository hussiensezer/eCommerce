<?php

	/*
	=================================================
	== Manage Members Page
	== You Can Add | Edit | Delete Member From Here
	=================================================
	*/

session_start();

	if(isset($_SESSION['Username'])){
		$pageTitle = "Members";

		include 'init.php';
		
		$do = isset($_GET['action'])? $_GET['action'] : 'Manage';
		
		// Start Manage Page
		if($do == 'Manage'){
			

			//Select All Users Excpet Admin
			
			$stmt = $con->prepare("SELECT * FROM users WHERE GroupId != 1");
			
			//Execute The Statement 
			$stmt->execute();
			
			//Assign To Variable
			$rows = $stmt->fetchAll();
		?>
	<div class="container member">
		<h1 class="text-center"> Management Members</h1>			
		<a href="members.php?action=Add" class="btn btn-primary mb-2"> <i class="fas fa-plus fa-fw mr-2 "></i> New Member</a>
		<div class="table-responsive">
			<table class="table table-bordered text-center main-table">
				<thead class="thead-dark">
					<tr>
						<th>#ID</th>
						<th>Username</th>
						<th>Email</th>
						<th>Fullname</th>
						<th>Registerd Date</th>
						<th>Control</th>
					</tr>
				</thead>
				<tbody class="members">
					<?php 
						foreach($rows as $row){
							echo '<tr>';
								echo "<td>{$row['UserId']} </td>";
								echo "<td>{$row['Username']} </td>";
								echo "<td>{$row['Email']} </td>";
								echo "<td>{$row['FullName']} </td>";
								echo "<td>3/8/2019</td>";
								echo "<td>
										<a href='members.php?action=Edit&id={$row['UserId']}' class='btn btn-success'> <i class='fas fa-edit fa-fw mr-1'></i>Edit </a>
										<a href='members.php?action=Delete&id={$row['UserId']}' class='btn btn-danger confirm'> <i class='fas fa-trash-alt fa-fw mr-1'></i>Delete </a>
										
									</td>";
							echo '</tr>';
						}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		}elseif($do == 'Add') { //Add Member Page ?>
			
		<!-- Start Add New Member Form -->

	<div class="container member">
		<h1 class="text-center mt-3">Add Member </h1>
	
		<form class="contact-form" action="?action=Insert" method="POST">
	
			<div class="form-group">
				<input type="text"
					   class="form-control username"
					   name="username"
					   placeholder="Type Member UserName"
					   autocomplete=off
					   required="required"
					   >
				<i class="fas fa-user fa-fw"></i>
			

			</div>
			<div class="form-group">
				
				<input type="password"
					   class="password form-control"
					   name="password" 
					   placeholder="Type Member Password"
					   autocomplete = "new-password"
					   required="required"
					    >
				<i class="fas fa-eye fa-fw showpass"></i>
				<i class="fas fa-lock fa-fw"></i>

			</div>
			
			<div class="form-group">
				<input type="email"
					   class="email form-control"
					   name="email"
					   placeholder="Please Type A Valid Email Of Member"
					   autocomplete="off"
					   required="required"
					   >
				<i class="fas fa-envelope fa-fw"></i>
				
			</div>
			
			<div class="form-group">
			<input type="text"
					   class="email form-control"
					   name="fullname"
					   placeholder="Please Type Member Full Name"
					   autocomplete="off"
					   required="required" >
				<i class="fas fa-signature fa-fw"></i>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary " value="Add Member">
				<i class="fas fa-paper-plane fa-fw"></i>
			</div>
			
		</form>
	</div>





		<!-- End Add New Member Form -->
			
		<?php
		} elseif($do == 'Insert'){
	
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
			
			
			echo "<div class='container'>";
			echo '<h1 class="text-center mt-3">Add New Member </h1>' ;
				//Get Variables From The Form
				$name = $_POST['username'];
				$pass = $_POST['password'];
				$email = $_POST['email'];
				$full = $_POST['fullname'];
				$hashPass = sha1($pass);
				
				// Password Trick
				
				// Validate The Form
				
				$formErrors = [];
				
				if(empty($name)){
					$formErrors[] = "Username Can't Be <b>Empty</b>";
				}
				if(empty($pass)){
					$formErrors[] = "Password Can't Be <b>Empty</b>";
				}
				if(empty($email)){
					$formErrors[] = "Email Can't Be <b>Empty</b>";
				}
				if(empty($full)){
					$formErrors[] = "Full Name Can't Be <b>Empty</b>";
				}

				
				foreach($formErrors  as $error) {
					echo "<div class='alert alert-danger'>" . $error . "</div>";
				}
				
				//Check If There's No Errors In fomErrors Proceed The Insert Operation
				if(empty($formErrors)) {
					// Check If User Are Exist
					
					$check = checkItem('Username', 'users', $name);
					
					if($check == 0) {
					//Insert The info of user in data DataBase 
					$stmt = $con->prepare("INSERT INTO
										   users(Username, Password, Email, FullName)	
											VALUES(:zuser, :zpass, :zemail, :zname) ");
					$stmt->execute(array(
						'zuser' => $name,
						'zpass' => $hashPass,
						'zemail'=> $email,
						'zname' => $full
					));
				
					
					// Echo Success Message
					$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
					redirectHome($theMsg,'members.php');
					} else {
						$theMsg = "<div class='alert alert-danger'> This Name Are Exist</div>";
						redirectHome($theMsg,'back');


					}
				}
				echo "</div>";

				
	
				
			}else {
				echo "<div class='container mt-3'>";
				
				$theMsg = "<div class='alert alert-danger'><b>Error </b>Sorry You Can't Browse This Page Direcly </div>";
				redirectHome($theMsg,'back');
				
				echo "</div>";
			}
		
		// Edit Page
			
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
			
			if($count > 0) {
		?>
		
			<!-- Start Form -->
	<div class="container member">
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
					   required='required'>
				<i class="fas fa-user fa-fw"></i>
			

			</div>
			<div class="form-group">
				<input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>">
				<input type="password"
					   class="form-control"
					   name="newpassword" 
					   placeholder="Leave It Blank If You Won't Change Your Password"
					   autocomplete = "new-password">
				<i class="fas fa-lock fa-fw"></i>

			</div>
			
			<div class="form-group">
				<input type="email"
					   class="email form-control"
					   name="email"
					   placeholder="Please Type A Valid Email"
					   autocomplete=off
					   value="<?php echo $row['Email']?>"
					   required='required'>
				<i class="fas fa-envelope fa-fw"></i>
				
			</div>
			
			<div class="form-group">
			<input type="text"
					   class="email form-control"
					   name="fullname"
					   placeholder="Please Type Your Full Name"
				   	 autocomplete=off
				   value="<?php echo $row['FullName']?>"
				   required='required'>
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
				
				$theMsg = "<div class='alert alert-danger'><b>Error </b>This Not A Valid Id  </div>";
				redirectHome($theMsg,'back');
				
			}	
		
			// Update Page
		} elseif($do == 'Update') { //Update Page
			echo '<h1 class="text-center mt-3">Update Member </h1>' ;
			
			echo "<div class='container'>";
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				//Get Variables From The Form
				
				$id = $_POST['userid'];
				$name = $_POST['username'];
				$email = $_POST['email'];
				$full = $_POST['fullname'];
				
				// Password Trick
				$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
				
				// Validate The Form
				
				$formErrors = [];
				
				if(empty($name)){
					$formErrors[] = "Username Can't Be <b>Empty</b>";
				}
				if(empty($email)){
					$formErrors[] = "Email Can't Be <b>Empty</b>";
				}
				if(empty($full)){
					$formErrors[] = "Full Name Can't Be <b>Empty</b>";
				}

				
				foreach($formErrors  as $error) {
					echo "<div class='alert alert-danger'>" . $error . "</div>";
				}
				
				//Check If There's No Errors In fomErrors Proceed The Update Operation
				if(empty($formErrors)) {
					//Update The DataBase With This Info
					
					$stmt = $con->prepare("UPDATE users SET Username = ?, Password = ?, Email = ?, FullName = ? WHERE UserId = ?");
					
					$stmt->execute(array($name, $pass, $email, $full, $id));
					
					// Echo Success Message
					$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
					redirectHome($theMsg,'back');
				}
				
				echo "</div>";

				
	
				
			}else {

				$theMsg = "<div class='alert alert-danger'><b>Error </b>Sorry You Can't Browse This Page Direcly</div>";
				redirectHome($theMsg);
			}
			
		}elseif($do == 'Delete'){ //Delete Page
					
		//Check If Get Request userId Is Numeric & Get The Integer Value Of It
		$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			echo '<h1 class="text-center mt-3">Delete Member </h1>' ;
			
			echo "<div class='container'>";
	
		// Select All Data Depend On This Id	
		$stmt = $con->prepare("SELECT * FROM users WHERE UserId = ?LIMIT 1");
		
		// Execute Query	
			
		$stmt->execute(array($userId));
			
		// Fetch The Data	
			

			
		// The Row Count
		$count = $stmt->rowCount();
			
			if($count > 0) {
				
				$stmt = $con->prepare("DELETE FROM users WHERE UserId = :userid");
				
				// Other Way To Execute The Statment
				$stmt->bindParam(':userid' , $userId);
				$stmt->execute();
				
				$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Member Are Deleted</div>';
				redirectHome($theMsg);
				echo "</div>";
			}else {
				$theMsg = '<div class="alert alert-danger">This Id Is Not Exist </div>';
				redirectHome($theMsg);
			}
		}//End Elseif Delete Method
		include $tpl . 'footer_inc.php';
	} else {
		header('location:index.php');
		
		exit();
	}
?>