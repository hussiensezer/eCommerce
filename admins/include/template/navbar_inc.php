
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
	<div class="container">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang('LOGO');?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="app-nav">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item">
        <a class="nav-link" href="category.php"><?php echo lang('CATEGORIES');?></a>
      </li>   
	  <li class="nav-item">
        <a class="nav-link" href="items.php"><?php echo lang('ITEMS');?></a>
      </li>	
	 <li class="nav-item">
        <a class="nav-link" href="members.php"><?php echo lang('MEMBERS');?></a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#"><?php echo lang('STATISTIC');?></a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#"><?php echo lang('LOGS');?></a>
      </li>


	 </ul>
   		<ul class="navbar-nav ml-auto">
	  	      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['Username']; ?>
        </a>
        <div class="dropdown-menu  " aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="members.php?action=Edit&id=<?php echo $_SESSION['Id']?>"><?php echo lang('EDIT');?></a>
          <a class="dropdown-item" href="#"><?php echo lang('SETTING');?></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php"><?php echo lang('OUT');?></a>
        </div>
      </li>
	  	
	  </ul>
  </div>
	</div>
</nav>