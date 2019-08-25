<?php
session_start();
$pageTitle = "Show Items";
include "init.php";

	//Check If Get Request ItemId Is Numeric & Get The Integer Value Of It
		$itemId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : 0;
			
        $user = isset($_SESSION['id']) ? $_SESSION['id'] : '';
		// Select All Data Depend On This Id	
		$stmt = $con->prepare("SELECT 	
                                items.*,
									categories.name
								AS 
									category_name,
									users.Username
								FROM
									items 
								INNER JOIN
									categories 
								ON
									categories.ID = items.Cat_ID 
								INNER JOIN 
									users 
								ON
									users.UserId = items.Member_ID
                                WHERE 
                                    Item_Id = ?
                                AND Approve = 1
                                    LIMIT 1");
		
		// Execute Query	
			
		$stmt->execute(array($itemId));
			
        $count = $stmt->rowCount();
    if($count > 0) {
		// Fetch The Data	
		$item = $stmt->fetch();       
           
?>

<div class="information block">
	<div class="container">
		<h1 class="text-center pad"> <?php echo $item['Name'] ?></h1>
	      <div class="card">
              <div class="card-header">
               
                <?php echo $item['Name'] ?>
              </div>
              <div class="card-body">
                  <blockquote class="blockquote mb-0">
                <p>
                  <b>Description : -</b>
                  <?php echo $item['Description'] ?>
                </p>
                <p>
                    <b>Price : - </b>
                    <?php echo $item['Price'] ?>
                </p>
                      
                <p>
                  <b>Made In  : -</b> 
                  <?php echo $item['Country_Made'] ?>
                </p>
                      
              <p>
                  <b>Category : - </b>
                  <a href='categories.php?catid=<?php echo $item['Cat_ID']?>'>
                  <?php echo $item['category_name'] ?>
                  </a>
              </p>
              <p>
                  <b>Saller : - </b>
                  <a href='publicprofile.php?id=<?php echo $item['Member_ID']?>'>
                     <?php echo $item['Username'] ?>
                  </a>
              </p> 
                <p>
                  <b>Tags : - </b>
                    <?php
                        $tags = $item['tags'];
                        $explode = explode(',' , $tags);
                        if(!empty($tags)){
                        foreach($explode as $tag){
                            
                            
                            echo "<a href='tags.php?name={$tag}' class='badge badge-primary mr-2'>";
                                echo $tag;
                            echo "</a>";
                        }
                    }else {
                            echo "<p class='alert alert-warning'> There's No Tags</p>";
                        }
                    ?>
              </p>
                      
              <footer class="blockquote-footer"><b> Add In : -</b><?php echo $item['Add_Date'] ?> 
                      
                    </footer>
                </blockquote>
                <?php 
            
               
                if($item['Member_ID'] == $user) {
                    echo "<a href='#' class='btn btn-success mr-2'> Edit </a>";
                    echo "<a href='#' class='btn btn-danger'> Delete </a>";
                }
          // echo $_SERVER['PHP_SELF'] ."?id=" ."{$item['Item_Id']}"; 
    
                ?>
              </div>
        </div> 
        <hr>
            <?php
         
        if($user) {?>
        <div class="row">
            <div class="offset-md-1">
                <h3>Add Your Comment</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] ."?id=" ."{$item['Item_Id']}"?>" method="POST">
                    <div class="form-group">
                        <textarea class="form-control" name="comment" required></textarea>
                    </div>
                    <input type="submit" value="Comment" class="btn btn-success">
                </form>
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                    
                    if (!empty($comment)){
                    $stmt = $con->prepare("INSERT INTO
                                                comments  (
                                                           comment,
                                                           status,
                                                           comment_date,
                                                           item_id,
                                                           user_id
                                                          )
                                                    VALUES (
                                                            :xcomment,
                                                            0,
                                                            now(),
                                                            :xitemid,
                                                            :xuserid
                                                           )     
                                                         ");
                
                    $stmt->execute(array(
                    'xcomment' => $comment,
                    'xuserid' => $_SESSION['id'],
                    'xitemid' => $item['Item_Id']

                    ));
                if($stmt) {
                        echo "<div class='alert alert-success'>Comment Add </div>";
                        }
                        
             }else {
                        echo "<div class='alert alert-danger'>Comment Field Can't Be Empty </div>";
                        
                    }
                 
                }
                   
             
            ?>
            </div>
        </div>
        
      
        
        
        
        
        
        
        
<?php
        }else {
            echo "<p class='alert alert-warning'>";
                echo "Sorry You can't comment you have to <a href='login.php'>Login</a> First" ;
            echo"</p>";
        }
        
    ?>
  <div class="row">
      <?php
        $stmt = $con->prepare("SELECT * FROM comments WHERE item_id = ? AND status = 1 ORDER BY c_id DESC");
        $stmt->execute(array($itemId));
        $comments =  $stmt->fetchAll();
  
        foreach($comments as $com) {
      ?>
    
      <div class="comments col-md-12 row">
            <div class="col-md-2">
                <div class="avatar">
                    <img src="default_avatar.png">
                </div>
            </div>
            <div class="col-md-10">
               <div class="box">
                 <?php echo $com['comment'] ;?>
                    <p class='float-right'><?php echo $com['comment_date'] ;?></p>    
                </div>
            </div>
        
       </div>
    <?php       
        }
      
      ?>
    </div>
        
	</div>

</div>	




<?php 
}else {
        echo "<div class='container'>";
            echo "<div class='alert alert-danger mt-5'> There's No Such Id Or Under Review From GM Try To Enter Later  </div>";
        echo "</div>";
    }
include $tpl . 'footer_inc.php';
?>

