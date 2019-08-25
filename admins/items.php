<?php

/*
=======================================================
== Items Page
=======================================================

*/
session_start();

$pageTitle = 'Items';

if(isset($_SESSION['Username'])) {
	
	include 'init.php';
	
	$do = isset($_GET['action']) ? $_GET['action'] : 'Manage';
	
	 // Start Management Part
	if($do == 'Manage') {
		
		
			$title = "Management";
			
		
			
			$stmt = $con->prepare("SELECT 
									items.*,
									categories.name
								AS 
									category_name,
									users.Username
								FROM
									items 
								INNER JOIN
									categories 
								ON
									categories.ID = items.Cat_ID 
								INNER JOIN 
									users 
								ON
									users.UserId = items.Member_ID
								ORDER BY
									Item_Id DESC");
			
			//Execute The Statement 
			$stmt->execute();
			
			//Assign To Variable
			$items = $stmt->fetchAll();
			if(!empty($items)){
		?>
	<div class="container member">
		<h1 class="text-center"> <?php echo $title ?> Items</h1>			
		<a href="items.php?action=Add" class="btn btn-primary mb-2"> <i class="fas fa-plus fa-fw mr-2 "></i> Add Item</a>
		<div class="table-responsive">
			<table class="table table-bordered text-center main-table">
				<thead class="thead-dark">
					<tr>
						<th>#ID</th>
						<th>Name</th>
						<th>Description</th>
						<th>Price</th>
						<th>Date</th>
						<th>Category</th>
						<th>Seller</th>
						<th>Control</th>
					</tr>
				</thead>
				<tbody class="members">
					<?php 
						foreach($items as $item){
							echo '<tr>';
								echo "<td>{$item['Item_Id']} </td>";
								echo "<td>{$item['Name']} </td>";
								echo "<td>{$item['Description']} </td>";
								echo "<td>{$item['Price']} </td>";
								echo "<td>{$item['Add_Date']} </td>";
								echo "<td>{$item['category_name']}</td>";
								echo "<td>{$item['Username']}</td>";
								echo "<td>
										<a href='items.php?action=Edit&id={$item['Item_Id']}' class='btn btn-success'> <i class='fas fa-edit fa-fw mr-1'></i>Edit </a>
										<a href='items.php?action=Delete&id={$item['Item_Id']}' class='btn btn-danger confirm'> <i class='fas fa-trash-alt fa-fw mr-1'></i>Delete </a>";
										if($item['Approve'] == 0) {
										echo"<a href='items.php?action=Approve&id={$item['Item_Id']}' class='btn btn-info  active'> <i class='fas fa-award fa-fw mr-1'></i>Apporved </a>";

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
				echo'<div class="nice-message">'. ' Theres No Item To Show'. '</div>';
				echo '<a href="items.php?action=Add" class="btn btn-primary mb-2"> <i class="fas fa-plus fa-fw mr-2 "></i> Add Item</a>';

			echo '</div>';
	}?>

<?php		
	 // Start Add Part
	} elseif($do == 'Add') {?>
		
<div class="container member">
		<h1 class="text-center mt-3">Add New Item </h1>
	
		<form class="contact-form" action="?action=Insert" method="POST">
			<!-- Start Of Name -->
			<div class="form-group">
				<input type="text"
					   class="form-control name"
					   name="name"
					   placeholder="Name Of The Item"
					   required="required">
				 <i class="fas fa-user fa-fw"></i>
			</div>
			<!-- End Of Name -->
			
			<!-- Start Of description -->
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="description" 
					   placeholder="Describe The Item"
					   required="required">
				
				<i class="fas fa-comment-alt fa-fw"></i>
			</div>
			<!-- End Of description -->		
			
			<!-- Start Of Prices -->
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="price" 
					   placeholder="Price The Item"
					   required="required">
				
				<i class="fas fa-dollar-sign fa-fw"></i>
			</div>
			<!-- End Of Prices -->	
			
			
			<!-- Start Of Prices -->
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="country" 
					   placeholder="Country  Of The Item">
				<i class="fas fa-flag"></i>	
			</div>
			<!-- End Of Prices -->
			
			<!-- Start Of Status -->
			<div class="form-group">
				
					  
					<select name="status"  class="form-control">
						<option value='0' disabled selected>Status</option>
						<option value='1'>New</option>
						<option value='2'>Like New</option>
						<option value='3'>Used</option>
						<option value='4'>Old</option>
					</select>
				
			</div>
			<!-- End Of Status -->
			<!-- Start Of Member -->
			<div class="form-group">
					<select name="member"  class="form-control">
						<option value='0' disabled selected>Who</option>
						<?php
                            $allUsers = getAll("*","users", "WHERE GroupId = 1","", "UserId");
							
							foreach($allUsers as $user) {
								
								echo "<option value='{$user['UserId']}'> {$user['Username']}</option>";
							}
						?>
					</select>
			</div>
			<!-- End Of Member -->
			<!-- Start Of Category -->
			<div class="form-group">
					<select name="category"  class="form-control">
						<option disabled selected>Category</option>
						<?php
                            $allcats = getAll("*","categories","WHERE parent = 0", '','ID'); 
							foreach($allcats as $cat) {
								echo "<option value='{$cat['ID']}'> {$cat['Name']}</option>";
                            $childCats = getAll("*","categories","WHERE parent = {$cat['ID']}", '','ID');
                                foreach($childCats as $child) {
								echo "<option value='{$child['ID']}' class='text-danger'> {$cat['Name']} -->{$child['Name']}</option>";
                                    
                                }
							}
						?>
					</select>
			</div>
            
        <!-- Start Of Tags -->
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="tags" 
					   placeholder="Separate Tags With Comma {,}">
				<i class="fas fa-tags"></i>	
			</div>
        <!-- End Of Tags -->
			<!-- End Of Category -->
			
			<div class="form-group">
				<input type="submit" class="btn btn-primary " value="Add Item">
				<i class="fas fa-paper-plane fa-fw"></i>
			</div>
			
		</form>
	</div>


		
<?php	 // End Add Part	
	  // Start Insert Part	
	} elseif($do == 'Insert' ) {
		
				
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
			
			
			echo "<div class='container member'>";
			echo '<h1 class="text-center mt-3">Add New Item </h1>' ;
				//Get Variables From The Form
				$name = $_POST['name'];
				$desc = $_POST['description'];
				$price = $_POST['price'];
				$country = $_POST['country'];
				$status = $_POST['status'];
				$time = date('Y-m-d h:i:s A'); // Change From DataBase To GET Full of Date
				$member = $_POST['member'];
				$cat = $_POST['category'];
				$tags = $_POST['tags'];
				
			
				// Validate The Form
				
				$formErrors = [];
				
				if(empty($name)){
					$formErrors[] = "Name Of Item's Can't Be <b>Empty</b>";
				}
				if(empty($desc)){
					$formErrors[] = "Description Of Item's Can't Be <b>Empty</b>";
				}
				if(empty($price)){
					$formErrors[] = "Price Can't Be <b>Empty</b>";
				}
				if(empty($status) && $status == 0){
					$formErrors[] = "Status  Can't Be <b>Empty</b>";
				}

				
				foreach($formErrors  as $error) {
					echo "<div class='alert alert-danger'>" . $error . "</div>";
				}
				
				//Check If There's No Errors In fomErrors Proceed The Insert Operation
				if(empty($formErrors)) {
				
					//Insert The info of user in data DataBase 
					$stmt = $con->prepare("INSERT INTO
										   items(Name, Description, Price, Country_Made, Status, Add_Date,Cat_ID, Member_ID,tags)	
											VALUES(:zname, :zdescription, :zprice, :zcountry,:zstatus,:ztime, :zcat,:zmember,:ztags ) ");
					$stmt->execute(array(
						'zname' 		=> $name,
						'zdescription'  => $desc,
						'zprice'    	=> $price,
						'zcountry' 		=> $country,
						'zstatus' 		=> $status,
						'ztime'			=> $time,
						'zcat'			=> $cat,
						'zmember'		=> $member,
						'ztags'   		=> $tags
					));
				
					
					// Echo Success Message
					$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
					redirectHome($theMsg);
					
				}
				echo "</div>";

				
	
				
			}else {
				echo "<div class='container member'>";
				
				$theMsg = "<div class='alert alert-danger'><b>Error </b>Sorry You Can't Browse This Page Direcly </div>";
				redirectHome($theMsg,'back');
				
				echo "</div>";
			}
		
	
	 // End Insert Part
		
		
	 // Start Edit Part	
	}elseif ($do == 'Edit') {
			
		//Check If Get Request ItemId Is Numeric & Get The Integer Value Of It
		$itemId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			
	
		// Select All Data Depend On This Id	
		$stmt = $con->prepare("SELECT * FROM items WHERE Item_Id = ? LIMIT 1");
		
		// Execute Query	
			
		$stmt->execute(array($itemId));
			
		// Fetch The Data	
			
		$item = $stmt->fetch();
			
		// The Row Count
		$count = $stmt->rowCount();
			
			if($count > 0) {
		?>
		
	<!-- Start Form -->
		<div class="container member">
		<h1 class="text-center mt-3">Edit Item </h1>
	
		<form class="contact-form" action="?action=Update" method="POST">
			<input type="hidden" name='itemid' value="<?php echo $itemId?>">
			<!-- Start Of Name -->
			<div class="form-group">
				<input type="text"
					   class="form-control name"
					   name="name"
					   placeholder="Name Of The Item"
					   required="required"
					   value='<?php echo $item['Name'];?>'>
				 <i class="fas fa-user fa-fw"></i>
			</div>
			<!-- End Of Name -->
			
			<!-- Start Of description -->
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="description" 
					   placeholder="Describe The Item"
					   required="required"
					  value=' <?php echo $item['Description'];?>'>
				
				<i class="fas fa-comment-alt fa-fw"></i>
			</div>
			<!-- End Of description -->		
			
			<!-- Start Of Prices -->
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="price" 
					   placeholder="Price The Item"
					   required="required"
					   value=' <?php echo $item['Price'];?>'>
				
				<i class="fas fa-dollar-sign fa-fw"></i>
			</div>
			<!-- End Of Prices -->	
			
			
			<!-- Start Of Prices -->
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="country" 
					   placeholder="Country  Of The Item"
					   value=' <?php echo $item['Country_Made'];?>'>
				<i class="fas fa-flag"></i>	
			</div>
			<!-- End Of Prices -->
			
			<!-- Start Of Status -->
			<div class="form-group">
				
					  
					<select name="status"  class="form-control">
						<option value='1' <?php if($item['Status'] == 1){echo 'selected';}?>>New</option>
						<option value='2' <?php if($item['Status'] == 2){echo 'selected';}?>>Like New</option>
						<option value='3' <?php if($item['Status'] == 3){echo 'selected';}?>>Used</option>
						<option value='4' <?php if($item['Status'] == 4){echo 'selected';}?>>Old</option>
					</select>
				
			</div>
			<!-- End Of Status -->
			<!-- Start Of Member -->
			<div class="form-group">
					<select name="member"  class="form-control">
						<?php
							$stmt = $con->prepare("SELECT * FROM users WHERE GroupId = 1");
							$stmt->execute();
							$users = $stmt->fetchAll();
							foreach($users as $user) {
								
								echo "<option value='{$user['UserId']}' ";
									if($item['Member_ID'] == $user['UserId']) {echo 'selected';}
								echo ">" . "{$user['Username']}</option>";
							}
						?>
					</select>
			</div>
			<!-- End Of Member -->
			<!-- Start Of Category -->
			<div class="form-group">
					<select name="category"  class="form-control">
						<?php
							$stmt = $con->prepare("SELECT * FROM categories");
							$stmt->execute();
							$cats = $stmt->fetchAll();
							foreach($cats as $cat) {
								
								echo "<option value='{$cat['ID']}'";
									if($item['Cat_ID'] == $cat['ID']){echo 'selected';}
								echo ">{$cat['Name']}</option>";
							}
						?>
					</select>
			</div>
			<!-- End Of Category -->
            <!-- Start Of Tags -->
            <div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="tags" 
					   placeholder="Separate Tags With Comma {,}"
                       value=' <?php echo $item['tags'];?>'>
				<i class="fas fa-tags"></i>	
			</div>
			<!-- End Of Tags -->
			<div class="form-group">
				<input type="submit" class="btn btn-primary " value="Save Item">
				<i class="fas fa-paper-plane fa-fw"></i>
			</div>
			
		</form>
		<?php	$stmt = $con->prepare("SELECT
										comments.*, users.Username
									FROM
										comments
									
									INNER JOIN
										users
									ON
										users.UserId = comments.user_id
									WHERE item_id = ? 
								");
			
			//Execute The Statement 
			$stmt->execute(array($itemId));
			
			//Assign To Variable
			$comments = $stmt->fetchAll();
			if(!empty($comments)){
		?>

		<h1 class="text-center mb-3"> Mangement [ <?php echo $item['Name']; ?> ] Comments</h1>			
		<div class="table-responsive">
			<table class="table table-bordered text-center main-table">
				<thead class="thead-dark">
					<tr>
						<th>Comment</th>
						<th>User Name</th>
						<th>Add Date</th>
						<th>Control</th>
					</tr>
				</thead>
				<tbody class="members">
					<?php 
						foreach($comments as $comment){
							echo '<tr>';
								echo "<td>{$comment['comment']} </td>";
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
		<?php }else {echo "<p class='alert alert-info w-25  alert-dismissible fade show role='alert'>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
								</button><b>No Comment's</b>
							</p>";}?>
	</div>
	<!-- End Form -->

<?php		//Else Show Error Message
			}else {
				
				$theMsg = "<div class='alert alert-danger'><b>Error </b>This Not A Valid Id  </div>";
				redirectHome($theMsg,'back');
				
			}	
		
		
	 // End Edit Part	
		
	
	 // Start Update Part
	}elseif($do == 'Update') {
		
		echo '<h1 class="text-center mt-3">Update Item </h1>' ;
			
			echo "<div class='container member'>";
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				//Get Variables From The Form
				
				$id			 = $_POST['itemid'];
				$name 		 = $_POST['name'];
				$desc		 = $_POST['description'];
				$price		 = $_POST['price'];
				$country 	 = $_POST['country'];
				$status 	 = $_POST['status'];
				$category 	 = $_POST['category'];
				$member 	 = $_POST['member'];
				$tags 	     = $_POST['tags'];
				
				// Validate The Form
				
				$formErrors = [];
				
						
				if(empty($name)){
					$formErrors[] = "Name Of Item's Can't Be <b>Empty</b>";
				}
				if(empty($desc)){
					$formErrors[] = "Description Of Item's Can't Be <b>Empty</b>";
				}
				if(empty($price)){
					$formErrors[] = "Price Can't Be <b>Empty</b>";
				}
				
				foreach($formErrors  as $error) {
					echo "<div class='alert alert-danger'>" . $error . "</div>";
				}
				
				//Check If There's No Errors In fomErrors Proceed The Update Operation
				if(empty($formErrors)) {
					//Update The DataBase With This Info
					
					$stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, Member_ID = ? , tags = ? WHERE Item_Id = ?");
					
					$stmt->execute(array($name, $desc, $price, $country, $status, $category,$member , $tags,$id));
					
					// Echo Success Message
					$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
					redirectHome($theMsg,'back');
				}
				
				echo "</div>";

				
	
				
			}else {

				$theMsg = "<div class='alert alert-danger'><b>Error </b>Sorry You Can't Browse This Page Direcly</div>";
				redirectHome($theMsg);
			}
		
	 // End Update Part
		
	 // Start Delete Part
	} elseif($do == 'Delete') {
		
		$itemId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
		
		// Check the id of item is true and num 
			echo '<h1 class="text-center mt-3">Delete Member </h1>' ;
			
			echo "<div class='container member'>";
	
		$check = checkItem('Item_Id', 'items', $itemId);
		
		if($check > 0) {
			
			$stmt = $con->prepare("DELETE FROM items WHERE Item_Id = :zitem_id");
			$stmt->bindParam(':zitem_id', $itemId);
			$stmt->execute();
			
			$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Item Are Deleted</div>';
			redirectHome($theMsg,'back');
			echo "</div>";
			}else {
				$theMsg = '<div class="alert alert-danger">This Id Is Not Exist </div>';
				redirectHome($theMsg);
			}
		
		
		// End Delete Part
		
		
		// Start Active Part
	}elseif($do == 'Approve') {
		
		//Check If Get Request ItemId Is Numeric & Get The Integer Value Of It
		$itemId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			echo '<h1 class="text-center mt-3">Active Member </h1>' ;
			
			echo "<div class='container member'>";
	
		// Function To Check If The ItemId Are Exist In Database Or Not To Insert The Member	
		
		$check = checkItem('Item_Id', 'items', $itemId);
		
			
			
			if($check > 0) {
				
				$stmt = $con->prepare("UPDATE  items SET  Approve = 1 WHERE Item_Id = ?");
				
			
				$stmt->execute(array($itemId));
				
				$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Item Are Aproved Now!</div>';
				redirectHome($theMsg, 'back');
				echo "</div>";
			}else {
				$theMsg = '<div class="alert alert-danger">This Id Is Not Exist </div>';
				redirectHome($theMsg);
			}
	}
	// End Active Part

	
	include $tpl . 'footer_inc.php';
}else {
	
	header('Location:index.php');
	exit();
	
}


?>