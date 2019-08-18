<?php


?>
<div class='upper-bar'>
	<div class="container">
		
	<?php
		if(isset($_SESSION['user'])){
				echo '<a href="logout.php" class="float-right" >
					<span >LogOut</span>
				</a>';
				$userStatus =  checkUserStatus($_SESSION['user']);
				echo "<a href='profile.php'>My Profile</a>";
			
			
			
			
				if($userStatus == 1) {
				//echo "Your MemberShip Need To Actived By Admin";
				}else {
				//	echo "You Are Actived You Can Shop Your needed";
				}

			}else {
			echo '<a href="login.php" class="ml-auto" >
					<span >Login/Signup</span>
				</a>';
			}
				
	
	?>
	
</div>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
	<div class="container">
  <a class="navbar-brand" href="index.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="app-nav">
    <ul class="navbar-nav mr-auto">

       
	<?php 
		
		$categories = getCat();

		foreach($categories as $cat) {
			
			echo '<li class="nav-item">';
				echo "<a class='nav-link' href='categories.php?catid={$cat['ID']}&name=" . str_replace([' ','&'], ['-', '_'], $cat['Name']) . "'>{$cat['Name']}</a>";
			echo '</li>';
		}
	?>
		

	 </ul>

  </div>
	</div>
</nav>