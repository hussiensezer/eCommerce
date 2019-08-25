<?php


?>
<div class='upper-bar'>
	<div class="container">
		
	<?php
		if(isset($_SESSION['user'])){
            $userStatus =  checkUserStatus($_SESSION['user']); 
            ?>
       
	   <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Welcome</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
  
     
      <ul class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="default_avatar.png" class="user_avatar">
          <?php echo $_SESSION['user'];?> 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="profile.php">Profile</a>
          <a class="dropdown-item" href="newad.php">Add Item</a>
          <a class="dropdown-item" href="profile.php#my-item">My Item's</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </ul>
    
    </ul>
  
  </div>
</nav>
  
			     
			
			
			 <?php
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
	$categories = 	getAll('*','categories', 'WHERE parent = 0', '','ID', 'ASC');
		
		foreach($categories as $cat) {
			
			echo '<li class="nav-item">';
				echo "<a class='nav-link' href='categories.php?catid={$cat['ID']} '>{$cat['Name']}</a>";
			echo '</li>';
		}
	?>
		

	 </ul>

  </div>
	</div>
</nav>