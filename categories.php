<?php 
session_start();
include "init.php"; 
$pageTitle = 'Categories'; 

$catid =  isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']): 0;

$getItems = getAll('*','items',"WHERE Cat_ID ={$catid}",'AND Approve = 1','Item_Id');
	if(!empty($getItems)){
?>


<div class="container">
	<h1 class='text-center pad'>Show Categories</h1>
	<div class="row">
		
		<?php 
			foreach($getItems as $item) {
			
			
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


