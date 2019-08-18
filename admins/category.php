<?php

session_start();

$pageTitle = 'Category';

if(isset($_SESSION['Username'])) {
	
	include 'init.php';
	
	$do = isset($_GET['action']) ? $_GET['action'] : 'Manage';
	
	 // Start Management Part
	if($do == 'Manage') {
		$sort = 'ASC';
		$sort_Array = ['ASC', 'DESC'];
		
		if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_Array) ){
			$sort = $_GET['sort'];
		}
		
		$stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering {$sort}");
		$stmt->execute();
		
		$cats = $stmt->fetchAll();
		if(!empty($cats)){

 ?>
		<div class="container categories">
			<h1 class='text-center member mb-5'>Welcome To Categories</h1>	
			<a href="category.php?action=Add" class="btn btn-primary mb-2"> <i class="fas fa-plus fa-fw mr-2 "></i> New Category</a>
			<div class="card">
			  <div class="card-header">
				 <b>Manage Categories</b>
				  <div class="ordering float-right">
				  	Ordering:
					 <a class="<?php if($sort == 'DESC'){echo 'active';}?>" href="?sort=DESC">Desc </a>|
					 <a class="<?php if($sort == 'ASC'){echo 'active';}?>" href="?sort=ASC">Asc</a>
				  
				  </div>
				</div>
			  <div class="card-body ">
				<?php
					foreach($cats as $cat) {
						echo "<div class='cat'>";
							echo"<div class='hidden-button'>";
								echo "<a href='category.php?action=Edit&catid={$cat['ID']}' class='btn btn-primary mr-1'> 
									<i class='fas fa-edit fa-fw'></i>	Edit
									</a>";
								echo "<a href='category.php?action=Delete&catid={$cat['ID']}' class='btn btn-danger mr-1 confirm'> 
									<i class='fas fa-trash fa-fw mr-1'></i></i>Delete 
									</a>";
							echo"</div>";
							echo "<h5 class='card-title'> {$cat['Name']} </h5>";
							echo "<p class='card-text'>";
								if($cat['Description'] == '') {
									echo 'This Category Has no Description';
								} else {
									echo $cat['Description'];
								} 
							echo "</p>";
							
							if($cat['Visibility'] == '1') {
								echo '<a href="#" class="badge badge-danger">Hidden
								<i class="fas fa-eye-slash"></i></a>';

							} else {
								echo '<a href="#" class="badge badge-success">Visible <i class="fas fa-eye"></i></a>';
							}	
						
						
						
							if($cat['Allow_Comment'] == '1') {
								echo '<a href="#" class="badge badge-danger">No Comment
								<i class="fas fa-comment-slash"></i></a>';

							} else {
								echo '<a href="#" class="badge badge-success">Comment <i class="fas fa-comment"></i></a>';
							}
						if($cat['Allow_Ads'] == '1') {
								echo '<a href="#" class="badge badge-danger">No Ads
								<i class="far fa-lightbulb"></i></a>';

							} else {
								echo '<a href="#" class="badge badge-success">Ads 
								<i class="fas fa-lightbulb"></i></a>';
							}
						
					
						
						
						
						echo "</div>";
						echo "<hr>";
					}
				?>
			  </div>
			</div>
		</div>
		
	<?php 
	}else{
		echo '<div class="container">';
			echo'<div class="nice-message">'. ' Theres No Category To Show'. '</div>';
			echo '<a href="category.php?action=Add" class="btn btn-primary mb-2"> <i class="fas fa-plus fa-fw mr-2 "></i> Add Category</a>';

		echo '</div>';
	}?>	
	 
		
	<?php
	// End Management Part	
	
	 // Start Add Part
	} elseif($do == 'Add') { ?>
		<!-- Start Add New Member Form -->

	<div class="container member">
		<h1 class="text-center mt-3">Add New Category </h1>
	
		<form class="contact-form" action="?action=Insert" method="POST">
	
			<div class="form-group">
				<input type="text"
					   class="form-control name"
					   name="name"
					   placeholder="Name Of The Category"
					   autocomplete=off
					   required="required">
				<i class="fas fa-user fa-fw"></i>
			

			</div>
			<div class="form-group">
				
				<input type="text"
					   class=" form-control"
					   name="description" 
					   placeholder="Describe The Category"
					   required="required">
				
				<i class="fas fa-comment-alt fa-fw"></i>

			</div>
			
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="ordering"
					   placeholder="Number To Arrange The Categories" >
				<i class="fas fa-list-ol fa-fw"></i>
				
			</div>
			
			<div class="form-group">
				<label class='control-label'> <b>Visible</b> </label>
				<div class="col-sm-10 col-md-6 ">
					<div class="custom-control custom-radio ml-2 active">
					  <input type="radio" id="vis-yes" class="custom-control-input " name='visibility' value='0' checked>
					  <label class="custom-control-label" for="vis-yes">Yes</label>
					</div>

					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="vis-no"  class="custom-control-input" name='visibility' value='1'>
					  <label class="custom-control-label" for="vis-no">No</label>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class=' control-label'><b>Allow Comments</b></label>
				<div class="col-sm-10 col-md-6">
					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="com-yes" class="custom-control-input" name='comment' value='0' checked>
					  <label class="custom-control-label" for="com-yes">Yes</label>
					</div>

					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="com-no"  class="custom-control-input" name='comment' value='1'>
					  <label class="custom-control-label" for="com-no">No</label>
					</div>

				</div>
			</div>	
			<div class="form-group">
				<label class=' control-label'><b>Allow Ads</b></label>
				<div class="col-sm-10 col-md-6">
					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="ads-yes" class="custom-control-input" name='ads' value='0' checked>
					  <label class="custom-control-label" for="ads-yes">Yes</label>
					</div>

					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="ads-no"  class="custom-control-input" name='ads' value='1'>
					  <label class="custom-control-label" for="ads-no">No</label>
					</div>

				</div>
			</div>
			
			<div class="form-group">
				<input type="submit" class="btn btn-primary " value="Add Category">
				<i class="fas fa-paper-plane fa-fw"></i>
			</div>
			
		</form>
	</div>




	<?php	
	 // End Add Part	
		
	 // Start Insert Part	
	} elseif($do == 'Insert' ) {
		
		
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
			
			
			echo "<div class='container member'>";
			echo '<h1 class="text-center mt-3">Add New Category </h1>' ;
				//Get Variables From The Form
				$name = $_POST['name'];
				$desc = $_POST['description'];
				$order = $_POST['ordering'];
				$visb = $_POST['visibility'];
				$comment = $_POST['comment'];
				$ads = $_POST['ads'];
			
				
				
				
				// Validate The Form
				
				$formErrors = [];
				
				if(empty($name)){
					$formErrors[] = "Category Name Can't Be <b>Empty</b>";
				}
				if(empty($desc)){
					$formErrors[] = "Description Of Category Can't Be <b>Empty</b>";
				}


				
				foreach($formErrors  as $error) {
					$theMsg =  "<div class='alert alert-danger'>" . $error . "</div>";
					redirectHome($theMsg,'back');
				}
				
				//Check If There's No Errors In fomErrors Proceed The Insert Operation
				if(empty($formErrors)) {
					// Check If Category Are Exist
					
					$check = checkItem('name', 'categories', $name);
					
					if($check == 0) {
					//Insert The info of Category in data DataBase 
					$stmt = $con->prepare("INSERT INTO
										   categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)	
											VALUES(:zname, :zdescription, :zordering, :zvisibility,:zComment,:zAds)");
					$stmt->execute(array(
						'zname' => $name,
						'zdescription' => $desc,
						'zordering'=> $order,
						'zvisibility' => $visb,
						'zComment' => $comment,
						'zAds' => $ads
					));
				
					
					// Echo Success Message
					$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
					redirectHome($theMsg,'back');
					} else {
						$theMsg = "<div class='alert alert-danger'> This Name Of Category Are Exist In DataBase</div>";
						redirectHome($theMsg,'back');


					}
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
	//Check If Get Request CategoryId Is Numeric & Get The Integer Value Of It
		$catid= isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid'])  : 0;
			
	
		// Select All Data Depend On This Id	
		$stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?LIMIT 1");
		
		// Execute Query	
			
		$stmt->execute(array($catid));
			
		// Fetch The Data	
			
		$cat = $stmt->fetch();
			
		// The Row Count
		$count = $stmt->rowCount();
			
			if($count > 0) {
		?>
		
			<!-- Start Form -->
	<div class="container member">
		<h1 class="text-center mt-3">Edit Category </h1>
		<form class="contact-form" action="?action=Update" method="POST">
		<input type="hidden" name="catid" value="<?php echo $catid?>"/>

			<div class="form-group">
				<input type="text"
					   class="form-control name"
					   name="name"
					   placeholder="Name Of The Category"
					   autocomplete=off
					   required="required"
					   value="<?php echo $cat['Name'] ?>">
				<i class="fas fa-user fa-fw"></i>
			

			</div>
			<div class="form-group">
				
				<input type="text"
					   class=" form-control"
					   name="description" 
					   placeholder="Describe The Category"
				
					   value="<?php echo $cat['Description'] ?>">
				
				<i class="fas fa-comment-alt fa-fw"></i>

			</div>
			
			<div class="form-group">
				<input type="text"
					   class=" form-control"
					   name="ordering"
					   placeholder="Number To Arrange The Categories" 
					   value="<?php echo $cat['Ordering'] ?>">
				<i class="fas fa-list-ol fa-fw"></i>
				
			</div>
			
			<div class="form-group">
				<label class='control-label'> <b>Visible</b> </label>
				<div class="col-sm-10 col-md-6 ">
					<div class="custom-control custom-radio ml-2 active">
					  <input type="radio" id="vis-yes" class="custom-control-input " name='visibility' value='0' <?php if($cat['Visibility'] == '0'){echo 'checked';} ?>>
					  <label class="custom-control-label" for="vis-yes">Yes</label>
					</div>

					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="vis-no"  class="custom-control-input" name='visibility' value='1' <?php if($cat['Visibility'] == '1'){echo 'checked';} ?>>
					  <label class="custom-control-label" for="vis-no">No</label>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class=' control-label'><b>Allow Comments</b></label>
				<div class="col-sm-10 col-md-6">
					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="com-yes" class="custom-control-input" name='comment' value='0' <?php if($cat['Allow_Comment'] == '0'){echo 'checked';} ?> >
					  <label class="custom-control-label" for="com-yes">Yes</label>
					</div>

					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="com-no"  class="custom-control-input" name='comment' value='1' <?php if($cat['Allow_Comment'] == '1'){echo 'checked';} ?>>
					  <label class="custom-control-label" for="com-no">No</label>
					</div>

				</div>
			</div>	
			<div class="form-group">
				<label class=' control-label'><b>Allow Ads</b></label>
				<div class="col-sm-10 col-md-6">
					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="ads-yes" class="custom-control-input" name='ads' value='0' <?php if($cat['Allow_Ads'] == '0'){echo 'checked';} ?> >
					  <label class="custom-control-label" for="ads-yes">Yes</label>
					</div>

					<div class="custom-control custom-radio ml-2">
					  <input type="radio" id="ads-no"  class="custom-control-input" name='ads' value='1' <?php if($cat['Allow_Ads'] == '1'){echo 'checked';} ?>>
					  <label class="custom-control-label" for="ads-no">No</label>
					</div>

				</div>
			</div>
			
			<div class="form-group">
				<input type="submit" class="btn btn-primary " value="Update Category">
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
		
		
	 // End Edit Part	
		
	
	 // Start Update Part
	}elseif($do == 'Update') {
		
		echo '<h1 class="text-center mt-3 ">Update Category </h1>' ;
			
			echo "<div class='container member'>";
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				//Get Variables From The Form
				
				$catid = $_POST['catid'];
				$name = $_POST['name'];
				$desc = $_POST['description'];
				$ordering = $_POST['ordering'];
				$visible = $_POST['visibility'];
				$commenting = $_POST['comment'];
				$ads = $_POST['ads'];
				
				// Password Trick
				
				
				// Validate The Form
				
				$formErrors = [];
				
				if(empty($name)){
					$formErrors[] = "Username Can't Be <b>Empty</b>";
				}
			
				if(empty($ordering)){
					$formErrors[] = "Ordering Can't Be <b>Empty</b>";
				}

				
				foreach($formErrors  as $error) {
					echo "<div class='alert alert-danger'>" . $error . "</div>";
				}
				
				//Check If There's No Errors In fomErrors Proceed The Update Operation
				if(empty($formErrors)) {
					//Update The DataBase With This Info
					
					$stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ?, Visibility = ?, Allow_Comment = ?, Allow_Ads = ? WHERE ID = ?");
					
					$stmt->execute(array($name, $desc, $ordering, $visible, $commenting, $ads, $catid));
					
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
	//Check If Get Request CategoryId Is Numeric & Get The Integer Value Of It
		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0;
			echo '<h1 class="text-center mt-3">Delete Category </h1>' ;
			
			echo "<div class='container member'>";
		
		
		
	// Function To Check If The Category Are Exist In Database Or Not To Insert The Member	
		$check =  checkItem('ID', 'categories', $catid);
		
		if($check > 0) {
			$stmt = $con->prepare("DELETE FROM categories WHERE ID = :catid");
			$stmt->bindParam(':catid',$catid );
			$stmt->execute();
			$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Category Are Deleted</div>';
				redirectHome($theMsg,'back');
				echo "</div>";
			}else {
				$theMsg = '<div class="alert alert-danger">This Id Is Not Exist </div>';
				redirectHome($theMsg,'back');
			}
		// End Delete Part
		
		
	}

	
	include $tpl . 'footer_inc.php';
}else {
	
	header('refresh: 5,Location:index.php');
	exit();
	
}


?>