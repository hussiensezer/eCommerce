<?php

	/*
	=================================================
	== Manage Comment Page
	== You Can  | Edit | Delete | Approve comments From Here
	=================================================
	*/

session_start();

	if(isset($_SESSION['Username'])){
		$pageTitle = "Comments";

		include 'init.php';
		
		$do = isset($_GET['action'])? $_GET['action'] : 'Manage';
		
		// Start Manage Page
		if($do == 'Manage'){
			
			$title = "Management";
			
		
		
			//Select All Users Excpet Admin
				// AS Hna fe al QUERY 3LSHN a8yar asm al items.name 3lshn mesh mfhoma nam eh
			$stmt = $con->prepare("SELECT
										comments.*, items.name AS Item_Name, users.Username
									FROM
										comments
									INNER JOIN
										items
									ON
										items.Item_Id = comments.item_id
									INNER JOIN
										users
									ON
										users.UserId = comments.user_id
								");
			
			//Execute The Statement 
			$stmt->execute();
			
			//Assign To Variable
			$comments = $stmt->fetchAll();
		?>
	<div class="container member">
		<h1 class="text-center mb-3"> <?php echo $title ?> Comments</h1>			
		<div class="table-responsive">
			<table class="table table-bordered text-center main-table">
				<thead class="thead-dark">
					<tr>
						<th>#ID</th>
						<th>Comment</th>
						<th>Item Name</th>
						<th>User Name</th>
						<th>Add Date</th>
						<th>Control</th>
					</tr>
				</thead>
				<tbody class="members">
					<?php 
						foreach($comments as $comment){
							echo '<tr>';
								echo "<td>{$comment['c_id']} </td>";
								echo "<td>{$comment['comment']} </td>";
								echo "<td>{$comment['Item_Name']} </td>";
								echo "<td>{$comment['Username']} </td>";
								echo "<td>{$comment['comment_date']}</td>";
								echo "<td>
										<a href='comments.php?action=Edit&id={$comment['c_id']}' class='btn btn-success'> <i class='fas fa-edit fa-fw mr-1'></i>Edit </a>
										<a href='comments.php?action=Delete&id={$comment['c_id']}' class='btn btn-danger confirm'> <i class='fas fa-trash-alt fa-fw mr-1'></i>Delete </a>";
										
									if($comment['status'] == 0) {
										echo"<a href='comments.php?action=approve&id={$comment['c_id']}' class='btn btn-info  active'> <i class='fas fa-award fa-fw mr-1'></i>Approve </a>";

										}
							
								echo "</td>";
							echo '</tr>';
						}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
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
			
			echo "<div class='container member'>";
			
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
			
			echo "<div class='container member'>";
	
		// Function To Check If The Username Are Exist In Database Or Not To Insert The Member	
		
		$check = checkItem('UserId', 'users', $userId);
		
			
			
			if($check > 0) {
				
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
		//End Elseif Delete Method
		} elseif($do == 'approve') {
		//Check If Get Request userId Is Numeric & Get The Integer Value Of It
		$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			echo '<h1 class="text-center mt-3">Active Member </h1>' ;
			
			echo "<div class='container member'>";
	
		// Function To Check If The Username Are Exist In Database Or Not To Insert The Member	
		
		$check = checkItem('UserId', 'users', $userId);
		
			
			
			if($check > 0) {
				
				$stmt = $con->prepare("UPDATE  users SET  RegStatus = 1 WHERE UserId = ?");
				
			
				$stmt->execute(array($userId));
				
				$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Member Are Active Now!</div>';
				redirectHome($theMsg);
				echo "</div>";
			}else {
				$theMsg = '<div class="alert alert-danger">This Id Is Not Exist </div>';
				redirectHome($theMsg);
			}
		}
		include $tpl . 'footer_inc.php';
	} else {
		header('location:index.php');
		
		exit();
	}
?>