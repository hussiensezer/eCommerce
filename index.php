<?php
session_start();
$pageTitle = "HomePage";
include "init.php";

$items = getAll('*','items','WHERE Approve = 1','','Item_Id');
?>
      <div class="container mt-5">
            <div class="row">
            <?php foreach($items  as $item){?>
                <div class="col-md-3 mb-3" id="my-item">
                    <div class="card item-profile" style="">
                        <img src="default.svg" class="card-img-top" alt="Product">
                      <div class="card-body">
                      <?php if($item['Approve'] == 0) {echo "<span class='alert alert-warning'>Under Check</span>";} ?>
                        <h5 class="card-title"><a href="item.php?id=<?php echo $item['Item_Id']?>"><?php echo $item['Name'] ?></a></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $item['Price'] ?></h6>
                        <p class="card-text"><?php echo $item['Description'] ?></p>
                        <p class="card-text"><?php echo $item['Add_Date'] ?></p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                      </div>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
		
	




<?php include $tpl . 'footer_inc.php';?>


