<?php 
session_start();
include "init.php"; 
$pageTitle = 'Categories'; 

$tagName =  isset($_GET['name']) ? ($_GET['name']) : 0;

$getTags = getAll('*','items',"WHERE tags LIKE '%{$tagName}%' ",'AND Approve = 1','Item_Id');
	if(!empty($getTags)){
?>


<div class="container">
	<h1 class='text-center pad'><?php echo $tagName ;?></h1>
	<div class="row">
		
		<?php 
			foreach($getTags as $item) {
			
			
		?>
		<div class="col-md-3 mb-3">
			<div class="card" style="">
				<img src="default.svg" class="card-img-top" alt="Product">
			  <div class="card-body">
                  <h5 class="card-title"> <a href="item.php?id=<?php echo $item['Item_Id']?>"><?php echo $item['Name'] ?> </a></h5>
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


