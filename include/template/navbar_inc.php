<div class='upper-bar'>
	UpperBar
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
   		<ul class="navbar-nav ml-auto">
	  	      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          
        </a>
        <div class="dropdown-menu  " aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="members.php?action=Edit&id="><?php echo lang('EDIT');?></a>
          <a class="dropdown-item" href="#"><?php echo lang('SETTING');?></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php"><?php echo lang('OUT');?></a>
        </div>
      </li>
	  	
	  </ul>
  </div>
	</div>
</nav>