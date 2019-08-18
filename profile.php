<?php
session_start();
$pageTitle = "Profile";
include "init.php";
if(isset($_SESSION['user'])) {
    
 $getUserInfo = $con->prepare("SELECT * FROM users WHERE Username = ?");
 $getUserInfo->execute(array($sessionUser));
 $info = $getUserInfo->fetch();
// To fetch The Items
 $getitems = getalldate('items','Member_ID',$info['UserId'] );
// To Fetch The Comments
$getComments = getalldate('comments','user_id', $info['UserId']);
?>

<div class="information block">
	<div class="container">
		<h1 class="text-center pad">Profile</h1>
		<!-- Start Card Info -->
			<div class="card k mt-5 mb-5">
			  <h5 class="card-header text-white bg-primary">My Information</h5>
			  <div class="card-body">
                  <p class="card-text"><b>Name </b>: <?php echo $info['Username'] ?></p>
					<p class="card-text"><b>Email</b> : <?php echo $info['Email'] ?></p>
					<p class="card-text"><b>FullName</b> : <?php echo $info['FullName'] ?></p>
					<p class="card-text"><b>Register Date</b> : <?php echo $info['date'] ?></p>
					<p class="card-text"><b>Favourite Category</b> : </p>
			
			  </div>
			</div>
		
		<!-- End Card Info -->	
		<!-- Start Card Info -->
			<div class="card  mt-5 mb-5">
			  <h5 class="card-header text-white bg-primary">Latest Ads</h5>
			  <div class="card-body">
                <div class="row">
						<?php 
            if(!empty($getitems)){
			foreach($getitems as $item) {
			
			
		?>
		<div class="col-md-3 mb-3">
			<div class="card" style="">
				<img src="default.svg" class="card-img-top" alt="Product">
			  <div class="card-body">
				<h5 class="card-title"><?php echo $item['Name'] ?></h5>
				<h6 class="card-subtitle mb-2 text-muted"><?php echo $item['Price'] ?></h6>
				<p class="card-text"><?php echo $item['Description'] ?></p>
				<a href="#" class="card-link">Card link</a>
				<a href="#" class="card-link">Another link</a>
			  </div>
			</div>
		</div>
		<?php }
            }else {
                echo "<p class='alert alert-warning'>Sorry You Don't Have Any Item's</p>";
            }
   ?>
		</div>
			  </div>
			</div>
		
		<!-- End Card Info -->	
		<!-- Start Card Info -->
			<div class="card  mt-5 mb-5">
			  <h5 class="card-header text-white bg-primary">Latest Comment</h5>
			  <div class="card-body">
               <?php   
                if(!empty($getComments)){
                    foreach($getComments as $comment) {
                    echo "<div class='alert alert-info'>";
                        echo "<p class='card-text'><b>Your Comment</b> : {$comment['comment']} </p>";
                        echo "<p class='card-text'><b>Commented At</b> : {$comment['comment_date']} </p>";
                        echo "<p class='card-text'><b>Commented In</b> : {$comment['item_id']} </p>";
                    echo "</div>";
                    }
                }else {
                   echo "<p class='alert alert-warning'>Sorry You Don't Have Any Comment in any Items</p>";  
                }
               ?>
					<p class="card-text"></p>
				
			  </div>
			</div>
		
		<!-- End Card Info -->
	
	</div>

</div>	




<?php 
}else {
    header('Location:login.php');
    exit();
}
include $tpl . 'footer_inc.php';
?>

