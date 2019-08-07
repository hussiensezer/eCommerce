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
									ORDER BY
										c_id DESC
								");
			
			//Execute The Statement 
			$stmt->execute();
			
			//Assign To Variable
			$comments = $stmt->fetchAll();
			if(!empty($comments)){
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
			}else{
				echo '<div class="container">';
					echo'<div class="nice-message">'. ' Theres No Comment To Show'. '</div>';;
								
					
				echo '</div>';
			}?>
	
	<?php
		} elseif($do == 'Edit'){ //Edit Page 
			
		//Check If Get Request userId Is Numeric & Get The Integer Value Of It
		$commentId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			
	
		// Select All Data Depend On This Id	
		$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? LIMIT 1");
		
		// Execute Query	
			
		$stmt->execute(array($commentId));
			
		// Fetch The Data	
			
		$row = $stmt->fetch();
			
		// The Row Count
		$count = $stmt->rowCount();
			
			if($count > 0) {
		?>
		
			<!-- Start Form -->
	<div class="container member">
		<h1 class="text-center mt-3">Edit Comment </h1>
	
		<form class="contact-form" action="?action=Update" method="POST">
			<input type="hidden" name="commentid" value="<?php echo $commentId?>"/>
			<div class="form-group">
				<textarea class="form-control username"name="comment" placeholder=" Write Your Comment" autocomplete="off" required='required'><?php echo $row['comment']?></textarea>
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
				
				$id = $_POST['commentid'];
				$comment = $_POST['comment'];

				
				
				// Validate The Form
				
				$formErrors = [];
				
				if(empty($comment)){
					$formErrors[] = "Comment Can't Be <b>Empty</b>";
				}
			

				
				foreach($formErrors  as $error) {
					echo "<div class='alert alert-danger'>" . $error . "</div>";
				}
				
				//Check If There's No Errors In fomErrors Proceed The Update Operation
				if(empty($formErrors)) {
					//Update The DataBase With This Info
					
					$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
					
					$stmt->execute(array($comment,$id));
					
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
		$commetid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			echo '<h1 class="text-center mt-3">Delete Member </h1>' ;
			
			echo "<div class='container member'>";
	
		// Function To Check If The Username Are Exist In Database Or Not To Insert The Member	
		
		$check = checkItem('c_id', 'comments', $commetid);
		
			
			
			if($check > 0) {
				
				$stmt = $con->prepare("DELETE FROM comments WHERE c_id = :id");
				
				// Other Way To Execute The Statment
				$stmt->bindParam(':id' , $commetid);
				$stmt->execute();
				
				$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Comment Are Deleted</div>';
				redirectHome($theMsg, 'back');
				echo "</div>";
			}else {
				$theMsg = '<div class="alert alert-danger">This Id Is Not Exist </div>';
				redirectHome($theMsg);
			}
		//End Elseif Delete Method
		} elseif($do == 'approve') {
		//Check If Get Request userId Is Numeric & Get The Integer Value Of It
		$commentId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			echo '<h1 class="text-center mt-3">Active Member </h1>' ;
			
			echo "<div class='container member'>";
	
		// Function To Check If The Username Are Exist In Database Or Not To Insert The Member	
		
		$check = checkItem('c_id', 'comments', $commentId);
		
			
			
			if($check > 0) {
				
				$stmt = $con->prepare("UPDATE  comments SET  status = 1 WHERE c_id = ?");
				
			
				$stmt->execute(array($commentId));
				
				$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Member Are Approveds Now!</div>';
				redirectHome($theMsg, 'back');
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