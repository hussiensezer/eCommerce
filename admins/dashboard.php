<?php
session_start();
if(isset($_SESSION['Username'])){
$pageTitle = "Dashboard";
include 'init.php';
/*Start Dashboard Page */
$latestUser = 5;	
$latests = getLatest('*','users','UserId',$latestUser, 'GroupId != 1');	
$latestsItems = getLatest('*','items','Item_Id',$latestUser);	
$latestscomments = getLatest('*','comments','c_id',$latestUser);
	
	
$stmt = $con->prepare("SELECT
						comments.*, users.Username
					FROM
						comments

					INNER JOIN
						users
					ON
						users.UserId = comments.user_id
					ORDER BY
						c_id DESC
				");
			
	//Execute The Statement 
	$stmt->execute(array());

	//Assign To Variable
	$comments = $stmt->fetchAll();
?>
	
	
	
<!-- Start Home Stats-->	
<div class="home-stats">
	<div class="container  text-center">
		<h1 class='text-center member'>Dashboard</h1>
		<div class="row mt-5">
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat st-members">
					<i class="fas fa-users fa-fw"></i>
					<div class="info">
						Total Members
						<span><a href="members.php"><?php echo countItems('UserId', 'users')?></a></span>
					</div>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat st-pending">
					<i class="fas fa-user-plus fa-fw"></i>
					<div class="info">
					Pending Members
					<span><a href="members.php?action=Manage&status=pending"><?php echo checkItem('RegStatus', 'users', 0)?></a></span>
					</div>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
		
				<div class="stat st-items">
					<i class="fas fa-tags fa-fw"></i>
					<div class="info">
					Total Items
					<span><a href="items.php"><?php echo countItems('Item_Id', 'items')?></a></span>
					</div>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat st-comments">
					<div class="info">
					<i class="fas fa-comments fa-fw"></i>
					Total Comments
					<span><a href="comments.php"><?php echo countItems('c_id', 'comments')?></a></span>
					</div>
				</div>
			</div>
			<!-- End Stat -->
		</div>
	</div>
</div>
<!-- End Home Stats-->

<!-- Start Latest-->
<div class="latest">
	<div class="container latest mt-5 ">
		<div class="row">
			<!-- Start Card-Latest -->
			<div class="col-sm-6">
				<div class="card text-white  mb-3">
				  <div class="card-header">
					  <i class="fas fa-user mr-2"></i>Latest Registerd Users
					  <span class="toggel-info float-right">
					  	<i class="fas fa-minus fa-lg"></i>
					  </span>
					</div>
				  <div class="card-body">
					   <?php if(!empty($latests)){?>

					<h5 class="card-title">Last  Member</h5>
					  <ul class="latest-ul">
						<?php 
					  	foreach($latests as $user) {
							
						echo "<li class='card-text'>{$user['Username']}";
							echo"<a href='members.php?action=Edit&id={$user['UserId']}'>";
								echo"<span class='btn btn-success float-right'>";
								echo"<i class='fas fa-edit fa-fw'> </i> Edit";
									
									echo"</span>";
								echo"</a>";
							if($user['RegStatus'] == 0) {
										echo"<a href='members.php?action=active&id={$user['UserId']}' class='btn btn-info float-right mr-2 active'> <i class='fas fa-award fa-fw mr-1'></i>Activate </a>";

										}
							echo "</li>";
						}
						}else {
							echo "No Member's";
						}	
					  	?>
					 </ul>
				  </div>
				</div>
			</div>
		<!-- End Card-Latest -->
		<!-- Start Card-Latest -->
			<div class="col-sm-6">
				<div class="card text-white  mb-3">
				  <div class="card-header">
					  <i class="fas fa-box mr-2"></i>Latest Items
						  <span class="toggel-info float-right">
							  	<i class="fas fa-minus fa-lg"></i>
						  </span>
					</div>
				  <div class="card-body">
					   <?php if(!empty($latestsItems)){?>
					<h5 class="card-title">Last Five Items</h5>
		  		<ul class="latest-ul">
						<?php 
					  	foreach($latestsItems as $item) {
							
						echo "<li class='card-text'>{$item['Name']}";
							echo"<a href='items.php?action=Edit&id={$item['Item_Id']}'>";
								echo"<span class='btn btn-success float-right'>";
								echo"<i class='fas fa-edit fa-fw'> </i> Edit";
									
									echo"</span>";
								echo"</a>";
							
							if($item['Approve'] == 0) {
								echo"<a href='items.php?action=Approve&id={$item['Item_Id']}' class='btn btn-info  float-right mr-2 active'> ";
								echo "<i class='fas fa-award fa-fw mr-1'></i>Apporved </a>";
							}
					
						}
						} else {
							echo "No Item's";
						}
					  	?>
					 </ul>
				  </div>
				</div>
			</div>
		<!-- End Card-Latest -->
		<!-- Start Card-Latest -->
			<div class="col-sm-6">
				<div class="card text-white  mb-3">
				  <div class="card-header">
					  <i class="fas fa-box mr-2"></i>Latest Comment
						  <span class="toggel-info float-right">
							  	<i class="fas fa-minus fa-lg"></i>
						  </span>
					</div>
				  <div class="card-body">
					 <?php if(!empty($comments)){?>
					<h5 class="card-title">Last Comments</h5>
		  	
						<?php 
						
					  	foreach($comments as $comment) {
							echo"<div class='comment-box row'>";
								echo "<span class='card-text member-n col-md-3 '>{$comment['Username']} </span>";
								echo "<p class='member-c col-md-9 '>{$comment['comment']} </p>";
							echo"</div>";
							
						}
						}else {
							echo "No Comment's";
						}	
					  	?>
					
				  </div>
				</div>
			</div>	
			
		</div>
	</div>
</div>	
<!-- End Latest-->
	
	
	
	
	
	
	
<?php	
/*End Dashboard Page */
include $tpl . 'footer_inc.php';
}else {
	header('location:index.php');
	exit();
}
?>