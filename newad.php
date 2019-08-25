<?php
session_start();
$pageTitle = "Profile";
include "init.php";
 
if(isset($_SESSION['user'])) {
 

if($_SERVER['REQUEST_METHOD'] == 'POST') {
$formErrors = [];
    
    $name = isset($_POST['name']) ?     filter_var($_POST['name'],FILTER_SANITIZE_STRING) : "";
    
    $des =isset($_POST['description']) ? filter_var($_POST['description'] ,FILTER_SANITIZE_STRING) : "";
    
    $price = isset($_POST['price']) ? filter_var($_POST['price'] ,FILTER_SANITIZE_NUMBER_INT) : "";
    
    $country = isset($_POST['country']) ? filter_var($_POST['country'] ,FILTER_SANITIZE_STRING) : "";
    
    $status =  isset($_POST['status']) ? filter_var($_POST['status'] ,FILTER_SANITIZE_NUMBER_INT) : "";
    
    $category =isset($_POST['category']) ? filter_var($_POST['category'] ,FILTER_SANITIZE_NUMBER_INT) : "";
    $tags = isset($_POST['tags']) ? filter_var($_POST['tags'],FILTER_SANITIZE_STRING) : "";
    if(strlen($name) < 4) {
        $formErrors[] = "Item Name Must be At Least 4 Characters";
    }
    if(strlen($des) < 10) {
        $formErrors[] = "Item Description Must be At Least 10 Characters";

    } 
    if(strlen($country) < 2) {
        $formErrors[] = "Item Country Must be At Least 2 Characters";

    }
    if(empty($price)) {
        $formErrors[] = "Item Price Must Be Not Empty";
    } 
    if(empty($status)) {
        $formErrors[] = "Item Status Must Be Not Empty";
    }  
    if(empty($category)) {
        $formErrors[] = "Item Category Must Be Not Empty";
    }
    
    if(empty($formErrors)) {
        $stmt =  $con->prepare( "INSERT INTO items (
                                    Name,
                                    Description,
                                    Price,
                                    Country_Made,
                                    Status,
                                    Cat_ID,
                                    Member_ID,
                                    Approve,
                                    Add_Date,
                                    tags
                                    )
                            VALUES
                                    (
                                    :zname,
                                    :zdesc,
                                    :zprice,
                                    :zcounty,
                                    :zstatus,
                                    :zcatid,
                                    :zmemberid,
                                    0,
                                    now(),
                                    :ztags
                                    )");
        $stmt->execute(array(
            'zname' => $name,
            'zdesc' => $des,
            'zprice' => $price,
            'zcounty' => $country,
            'zstatus' => $status,
            'zcatid' => $category,
            'zmemberid' => $_SESSION['id'],
            'ztags' => $tags
        ));
        if($stmt) {
               echo $theMsg =  "<div class='alert alert-success'> Congratulation Your Item In Reviwe Just wait the Approved </div>"; 
        }                        
    }
}

?>

<div class="newad block">
	<div class="container">
		<h1 class="text-center pad">Create New Ad</h1>
		<!-- Start Card Info -->
			<div class="card k mt-5 mb-5">
			  <h5 class="card-header text-white bg-primary">Create New Ad</h5>
			  <div class="card-body">
                <div class="row">
                <div class="col-md-9">
                    
                <form class="newad-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
			<!-- Start Of Name -->
			<div class="form-group">
				<input type="text"
					   class="form-control live-name"
					   name="name"
					   placeholder="Name Of The Item"
					   required="required">
				 <i class="fas fa-user fa-fw"></i>
			</div>
			<!-- End Of Name -->
			
			<!-- Start Of description -->
			<div class="form-group">
				<input type="text"
					   class=" form-control live-desc"
					   name="description" 
					   placeholder="Describe The Item "
					   required="required">
				
				<i class="fas fa-comment-alt fa-fw"></i>
			</div>
			<!-- End Of description -->		
			
			<!-- Start Of Prices -->
			<div class="form-group">
				<input type="text"
					   class=" form-control live-price"
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
					   placeholder="Country  Of The Item"
                         required="required">
				<i class="fas fa-flag"></i>	
			</div>
			<!-- End Of Prices -->
			
			<!-- Start Of Status -->
			<div class="form-group">
				
					  
					<select name="status"  class="form-control"   required="required">
						<option  disabled selected>Status</option>
						<option value='1'>New</option>
						<option value='2'>Like New</option>
						<option value='3'>Used</option>
						<option value='4'>Old</option>
					</select>
				
			</div>
			<!-- End Of Status -->
		
			<!-- Start Of Category -->
			<div class="form-group">
					<select name="category"  class="form-control catgory"   required="required">
						<option value='0' disabled selected >Category</option>
						<?php
                         $allCats =   getAll("*",'categories', 'WHERE parent = 0', '','ID');
				
							foreach($allCats as $cat) {
								
								echo "<option value='{$cat['ID']}'> {$cat['Name']}</option>";
                                $childCats = getAll("*","categories","WHERE parent = {$cat['ID']}", '','ID');
                                foreach($childCats as $child) {
								echo "<option value='{$child['ID']}' class='text-danger'> {$cat['Name']} -->{$child['Name']}</option>";
                                    
                                }
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
					   placeholder="Separate Tags With Comma {,}">
				<i class="fas fa-tags"></i>	
			</div>
        <!-- End Of Tags -->
			
			<div class="form-group">
				<input type="submit" class="btn btn-primary " value="Add Item">
				<i class="fas fa-paper-plane fa-fw"></i>
			</div>
			
		</form>
                    </div> 
                    <div class="col-md-3">
                        <div class="">
                            <div class="card" class="">
                                <img src="default.svg" class="card-img-top" alt="Product">
                              <div class="card-body live-preview">
                                <h5 class="card-title name">Test</h5>
                                <h6 class="card-subtitle mb-2 text-muted category">Test</h6>
                                <p class="card-text price">test</p>
                                <p class="card-text desc">test</p>
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                              </div>
                        </div>
		              </div>
                    </div>
                </div> 
			
			  </div>
			</div>
		  <?php 
            if(!empty($formErrors)) {
                 foreach($formErrors as $error) {
                     echo "<div class='alert alert-danger'> {$error} </div>";
                 }
            }
    
        ?>



<?php 
}else {
    header('Location:login.php');
    exit();
}
include $tpl . 'footer_inc.php';
?>

