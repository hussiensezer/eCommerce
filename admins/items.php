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
			
		
			
			$stmt = $con->prepare("SELECT * FROM items");
			
			//Execute The Statement 
			$stmt->execute();
			
			//Assign To Variable
			$items = $stmt->fetchAll();
		?>
	<div class="container member">
		<h1 class="text-center"> <?php echo $title ?> Items</h1>			
		<a href="items.php?action=Add" class="btn btn-primary mb-2"> <i class="fas fa-plus fa-fw mr-2 "></i> New Member</a>
		<div class="table-responsive">
			<table class="table table-bordered text-center main-table">
				<thead class="thead-dark">
					<tr>
						<th>#ID</th>
						<th>Name</th>
						<th>Description</th>
						<th>Price</th>
						<th>Date</th>
						<th>Made In</th>
						<th>Status</th>
						<th>Cat_ID</th>
						<th>Member_ID</th>
					</tr>
				</thead>
				<tbody class="members">
					<?php 
						foreach($items as $item){
							echo '<tr>';
								echo "<td>{$item['Item_Id']} </td>";
								echo "<td>{$item['Description']} </td>";
								echo "<td>{$item['Price']} </td>";
								echo "<td>{$item['Add_Date']} </td>";
								echo "<td>{$item['Country_Made']}</td>";
								echo "<td>{$item['Status']}</td>";
								echo "<td>{$item['Cat_ID']}</td>";
								echo "<td>{$item['Member_ID']}</td>";
								echo "<td>
										<a href='items.php?action=Edit&id={$item['Item_Id']}' class='btn btn-success'> <i class='fas fa-edit fa-fw mr-1'></i>Edit </a>
										<a href='items.php?action=Delete&id={$item['Item_Id']}' class='btn btn-danger confirm'> <i class='fas fa-trash-alt fa-fw mr-1'></i>Delete </a>";
										
		
							
								echo "</td>";
							echo '</tr>';
						}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
		
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
							$stmt = $con->prepare("SELECT * FROM users WHERE GroupId = 1");
							$stmt->execute();
							$users = $stmt->fetchAll();
							foreach($users as $user) {
								
								echo "<option value='{$user['UserId']}'> {$user['Username']}</option>";
							}
						?>
					</select>
			</div>
			<!-- End Of Member -->
			<!-- Start Of Category -->
			<div class="form-group">
					<select name="category"  class="form-control">
						<option value='0' disabled selected>Category</option>
						<?php
							$stmt = $con->prepare("SELECT * FROM categories");
							$stmt->execute();
							$cats = $stmt->fetchAll();
							foreach($cats as $cat) {
								
								echo "<option value='{$cat['ID']}'> {$cat['Name']}</option>";
							}
						?>
					</select>
			</div>
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
										   items(Name, Description, Price, Country_Made, Status, Add_Date,Cat_ID, Member_ID)	
											VALUES(:zname, :zdescription, :zprice, :zcountry,:zstatus,:ztime, :zcat,:zmember ) ");
					$stmt->execute(array(
						'zname' 		=> $name,
						'zdescription'  => $desc,
						'zprice'    	=> $price,
						'zcountry' 		=> $country,
						'zstatus' 		=> $status,
						'ztime'			=> $time,
						'zcat'			=> $cat,
						'zmember'		=> $member
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
		echo 'Welcome To Edit';
		
		
	 // End Edit Part	
		
	
	 // Start Update Part
	}elseif($do == 'Update') {
		
		echo 'Welcome To Update';
		
	 // End Update Part
		
	 // Start Delete Part
	} elseif($do == 'Delete') {
		
		echo 'Welcome To Delete';
		// End Delete Part
		
		
		// Start Active Part
	}elseif($do == 'Approve') {
		
		echo 'welcome to Approve';
	}
	// End Active Part

	
	include $tpl . 'footer_inc.php';
}else {
	
	header('Location:index.php');
	exit();
	
}


?>