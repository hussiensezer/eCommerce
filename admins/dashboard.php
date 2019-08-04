<?php
session_start();
if(isset($_SESSION['Username'])){
$pageTitle = "Dashboard";
include 'init.php';
/*Start Dashboard Page */
$latestUser = 5;	
$latests = getLatest('*','users','UserId',$latestUser);	
$latestsItems = getLatest('*','items','Item_Id',$latestUser);	
?>
	
	
	
<!-- Start Home Stats-->	
<div class="home-stats">
	<div class="container  text-center">
		<h1 class='text-center member'>Dashboard</h1>
		<div class="row mt-5">
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat st-members">
					Total Members
					<span><a href="members.php"><?php echo countItems('UserId', 'users')?></a></span>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat st-pending">
					Pending Members
					<span><a href="members.php?action=Manage&status=pending"><?php echo checkItem('RegStatus', 'users', 0)?></a></span>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat st-items">
					Total Items
					<span><a href="items.php"><?php echo countItems('Item_Id', 'items')?></a></span>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat st-comments">
					Total Comments
					<span>2000</span>
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
				  <div class="card-header"><i class="fas fa-user mr-2"></i>Latest <b><?php echo $latestUser ?></b> Registerd Users</div>
				  <div class="card-body">
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

					  	?>
					 </ul>
				  </div>
				</div>
			</div>
		<!-- End Card-Latest -->
		<!-- Start Card-Latest -->
			<div class="col-sm-6">
				<div class="card text-white  mb-3">
				  <div class="card-header"><i class="fas fa-box mr-2"></i>Latest Items</div>
				  <div class="card-body">
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
					
						}

					  	?>
					 </ul>
				  </div>
				</div>
			</div>
		<!-- End Card-Latest -->
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