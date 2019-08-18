<?php include "init.php"; 
$pageTitle = 'Categories'; 
$catname =  isset($_GET['name'])? $_GET['name']: "";
$catid =  isset($_GET['catid'])? $_GET['catid']: "";
$items = getItems('Cat_ID',$catid);
	if(!empty($items)){
?>


<div class="container">
	<h1 class='text-center pad'><?php echo  str_replace(['-','_'], [' ', '&'], $catname);?></h1>
	<div class="row">
		
		<?php 
			foreach($items as $item) {
			
			
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
		<?php }?>
	<?php }else{
			echo '<div class="container">';
				echo'<div class="nice-message">'. ' Theres No Items To Show'. '</div>';	
			echo '</div>';
				 }?>
	</div>
</div>




<?php include $tpl . 'footer_inc.php';?>


