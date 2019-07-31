<?php
session_start();
if(isset($_SESSION['Username'])){
$pageTitle = "Dashboard";
include 'init.php';
/*Start Dashboard Page */
	
	
	
?>
	
	
	
<!-- Start Home Stats-->	
<div class="home-stats">
	<div class="container  text-center">
		<h1 class='text-center member'>Dashboard</h1>
		<div class="row mt-5">
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat">
					Total Members
					<span><?php echo countItems('UserId', 'users')?></span>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat">
					Pending Members
					<span>25</span>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat">
					Total Items
					<span>1500</span>
				</div>
			</div>
			<!-- End Stat -->
			<!-- Start Stat -->
			<div class="col-md-3">
				<div class="stat">
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
				<div class="card text-white bg-primary mb-3">
				  <div class="card-header"><i class="fas fa-user mr-2"></i>Latest Registerd Users</div>
				  <div class="card-body">
					<h5 class="card-title">Last Five Member</h5>
					<p class="card-text">Hussien</p>
					<p class="card-text">Karam</p>
					<p class="card-text">Rehan</p>
					<p class="card-text">Mohamed</p>
					<p class="card-text">Attia</p>
				  </div>
				</div>
			</div>
		<!-- End Card-Latest -->
		<!-- Start Card-Latest -->
			<div class="col-sm-6">
				<div class="card text-white bg-primary mb-3">
				  <div class="card-header"><i class="fas fa-box mr-2"></i>Latest Items</div>
				  <div class="card-body">
					<h5 class="card-title">Last Five Items</h5>
					<p class="card-text">Tv Samsung Smart</p>
					<p class="card-text">Laptop Dell</p>
					<p class="card-text">Mobile Redmi Not 7</p>
					<p class="card-text">Shoes Black</p>
					<p class="card-text">Swim Suit</p>
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