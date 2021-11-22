<head>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>

  <?php include('includes/header.php'); ?>			
	
  <!-- Content -->
  <div class="content_wrapper">
				
    <!-- Content Area -->

	<?php if(isset($_GET['location'])) {
	  $location = $_GET['location']; ?> 
	<a class="return" href="all_products.php?location=<?php echo $location; ?>"><i class="fa fa-arrow-left"></i> Go back to all products</a>

	<?php } else { 
	  echo "<script>alert('Set location to view product');</script>";
	  echo "<script>window.location.replace('index.php');</script>";
	 } ?>
	<br>
		  				
	  <?php 
	    global $con;
	    if(isset($_GET['pro_id'])) {

		$product_id = $_GET['pro_id'];			
		$get_pro = " select * from FYP_Products where product_id='$product_id'";
		$run_pro = mysqli_query($con, $get_pro);
					
		while($row_pro = mysqli_fetch_array($run_pro)) {
    		  $brand_name = mysqli_query($con, "select * from FYP_Brands where brand_id='$row_pro[product_brand]'");
    		  $brand_fetch = mysqli_fetch_array($brand_name);

		  $pro_id = $row_pro['product_id'];
		  $pro_cat = $row_pro['product_category'];
		  $pro_brand = $row_pro['product_brand'];
		  $pro_title = $row_pro['product_title'];
		  $pro_price = number_format($row_pro['product_price'], 2);
		  $pro_image = $row_pro['product_image'];
		  $brand_img = '';

		
		  // Retrieve recommended products
		  $get_recom = mysqli_query($con, "select * from FYP_Products where product_category='$pro_cat' limit 5");

		?>
		    <div class='product_container'><br>

		    <?php if($row_pro['product_offer'] == 'on') { ?>

		    <div style="text-align:center;">
		      <p class="offer_alert">This product is currently On Offer! Don't miss out..</p>
		    </div>

		    <?php } ?>

		      <h2 class="pro_title"> <?php echo $pro_title; ?> </h2><br>
		      <div class='brand_element_style'>
		        <h3>Sold by: <?php echo $brand_fetch['brand_title']; ?> </h3>
		      </div><br>

		      <div class='element1'>
			<?php 
			  if($row_pro['other_product_details'] != '') {
			    echo $row_pro['other_product_details']; 
			  } else {
			    echo "No Product Information Provided.";
			  }
			?>
		      </div>
		
		      <div class='element2'><?php echo $row_pro['product_diet']; ?></div>

		      <div class='element3'>
			<?php 
			  if($row_pro['product_desc'] != '') {
			    echo $row_pro['product_desc']; 
			  } else {
			    echo "No Information Provided.";
			  }
			?>
		      </div>

		      <div class='product_element1'>	
			<img src='admin_area/product_images/<?php echo $pro_image; ?>' width='300' /><br><br>
			<a href="all_products.php?location=<?php echo $location; ?>&add_cart=<?php echo $product_id;?>">
			  <img class='cart_img' src='images/cart.png' alt='Add To Trolley'/>Add to Trolley 
 			</a>
		      </div>

		      <div class='product_element2'>	
			<?php if($row_pro['product_offer'] == 'on'){ ?>
			  <a class="offer_price" style="font-size:23px; color:red;"><b>Offer Price: <?php echo number_format($row_pro['offer_price'], 2); ?></b></a><br> 
			  <a class="orig_price" style="font-size:18px;">Original Price: &pound; <?php echo $pro_price; ?> </a>
			<?php } else { ?>
			  <h2><b> Price: &pound; <?php echo $pro_price; ?> </b></h2>
			<?php } ?>
			
			<!-- Commentary Section -->
			<div id='commentsCom' class='commentary_container'>

			  <?php 
			    //Display all comments of this particular product
			    $select_product_comments = mysqli_query($con, "select * from FYP_Commentary where product_id='$_GET[pro_id]' order by comment_timestamp desc");
			    $check_comment_exist = mysqli_num_rows($select_product_comments);

			    if($check_comment_exist > 0) {
			    	while($comment_row = mysqli_fetch_array($select_product_comments)) {
				  $star = "";

				  if($comment_row['rating'] == 1) {
				    $star = "images/star_one.png";
				  } elseif($comment_row['rating'] == 2) {
				    $star = "images/star_two.png";
				  } elseif($comment_row['rating'] == 3) {
				    $star = "images/star_three.png";
				  } elseif($comment_row['rating'] == 4) { 
				    $star = "images/star_four.png";
				  } else {
				    $star = "images/star_five.png";
				  }
				
				  if($comment_row['status'] == 'Approved') { ?>

				   <div class="comment_box">
					    <h3 style="color:lightblue;"><?php echo $comment_row['title'];?></h3><br>
					    <img width='120' src='<?php echo $star; ?>'/><br><br>
					    <p> <?php echo $comment_row['comment']; ?></p><br>
					    <p style='font-size:14px;'><b>Created on: </b><?php echo $comment_row['comment_timestamp']; ?></p><br>

					  <?php if($comment_row['user_id'] == $_SESSION['user_id']) { ?>
					    <form method="post" action=""><input type="submit" name="remove_comment" value="Remove Comment" /></form>
					  <?php } ?>
					  
					  <?php if(isset($_POST['remove_comment'])) {
					    $remove_com = mysqli_query($con, "delete from FYP_Commentary where product_id='$_GET[pro_id]' and user_id='$_SESSION[user_id]'");
					    
					    if($remove_com) {
					    	echo "<script>alert('Your comment was removed!')</script>";
	    					echo "<script>window.open(window.location.href,'_self')</script>";
					    } else {
						echo mysqli_error($con);
					    }
					  } ?>

					  </div><hr>				  

				 <?php } else {
				    echo "<div class='comment_box'>
				  	    <h4>Comment under moderation.</h4>
					    <p><b>Created on: </b> $comment_row[comment_timestamp]</p>
					  </div>";
				  }
			    	}
			    } else {
				echo "<h4>No comments yet created for this product.</h4>";
			    }
			  ?>

			</div>

			<?php 
			  if(isset($_SESSION['user_id'])) { 
			?>

			<button class="button_form" id="myBtnCom">Write your comment</button>

			<!-- The Modal -->
  			  <div id="myModalCom" class="comment-formCom">

			<!--- Comment Form --->
			    <?php
			    	if(isset($_POST['comment_submit'])) {
				  
				  $user_id = $_SESSION['user_id'];
				  $id_pro = $_GET['pro_id'];
				
				  //Checking if user has already written a comment for a particular product
				  $check_exist = mysqli_query($con, "select * from FYP_Commentary where product_id='$id_pro' and user_id='$user_id'");
				  $comment_count = mysqli_num_rows($check_exist);

				  if($comment_count >= 1) {
					echo "<script>
					alert('You have already commented for this product, please choose a different product.');</script>";
				  } else {

				  if(isset($_POST['rating'])) {

					$rating = $_POST['rating'];
					$title = $_POST['comment_title'];
					$comment_content = $_POST['comment_content'];

					//Store the comment into the database
					$store_comment = mysqli_query($con, "insert into FYP_Commentary(product_id, user_id, title, comment, rating) values ('$id_pro','$user_id','$title','$comment_content','$rating') ");
					
					if($store_comment) {
				    	  echo "<script>var modalCom = document.getElementById('myModalCom');
				      	    var commentsCom = document.getElementById('commentsCom');
				      	    modalCom.style.display = 'none'; 
				      	    commentsCom.style.display = 'block';
					    window.location.href = 'details.php?pro_id=$id_pro&location=$_GET[location]';
					    alert('Comment was succesful. It will be visible after admin moderation.');
					    </script>";
					} else {
					  echo "<p style='padding:5px; color:white; background:red;' >There was an error, please try again later.</p><br>";
					}
					  
				  } else {
					echo "<script>alert('Comment was unsuccessful, please rate the product.');</script>";
				  }
				}}
			    ?>

    			    <span class="close-btnCom">&times;</span>
    			    <h4>If you want to leave some feedback or a recommendation note about this product, please don't hesitate to write a comment..</h4>
			    <br>
			 
			    <form method="post" action="">
				<label for="comment_title">Comment Title: </label>
				<input type="text" name="comment_title" placeholder="Provide a title" required /><br><br>
				<label for="comment_content">Your Comment: </label><br>
				<textarea rows="5" cols="60" name="comment_content" placeholder="Provide a comment" required></textarea><br><br>
				<label for="rating">Your rating (up to five points): </label>
				1<input type="radio" value="1" name="rating" />
				2<input type="radio" value="2" name="rating" />
				3<input type="radio" value="3" name="rating" />
				4<input type="radio" value="4" name="rating" />
				5<input type="radio" value="5" name="rating" /><br><br>
				<input class="confirm_comment" style="font-size:14px; cursor:pointer; padding:8px; width:100%;" type="submit" name="comment_submit" value="Submit Comment"/>
			    </form>

  			  </div>
			
			<!--- Comment Button Functionality --->
			<script>
			  // Get the modal
			  var modalCom = document.getElementById("myModalCom");

			  // Get the button that opens the modal
			  var btnCom = document.getElementById("myBtnCom");

			  var commentsCom = document.getElementById("commentsCom");

			  // Get the <span> element that closes the modal
			  var spanCom = document.getElementsByClassName("close-btnCom")[0];

			  // When the user clicks on the button, open the modal
			  btnCom.onclick = function() {
  			    modalCom.style.display = "block";
  			    commentsCom.style.display = "none";
			    btnCom.style.display = "none";
			  }

			  // When the user clicks on <span> (x), close the modal
			  spanCom.onclick = function() {
  			    modalCom.style.display = "none";
  			    commentsCom.style.display = "block";
			    btnCom.style.display = "block";
			  }

			</script>
			<!--- End of Modal --->
			<?php } ?>
		      </div>

		      <div class='additional_container'>
			<h3 style="text-decoration:underline;">Recommended Products</h3><br>
		        <div class='additional1'>
			  <?php 
			    while($fetch_rec = mysqli_fetch_array($get_recom)) {
			    	$rec_img = $fetch_rec['product_image'];
				$rec_id = $fetch_rec['product_id'];
				$rec_price = number_format($fetch_rec['product_price'],2);
				$rec_title = $fetch_rec['product_title'];
				
				if($rec_id != $pro_id) {
				echo "
				  <a href='details.php?pro_id=$rec_id&location=$location'>
				    <div class='rec1'><img src='admin_area/product_images/$rec_img' width='100'/></div>
				    <div class='rec2'>
					<p>$rec_title</p> ";
				  if($fetch_rec['product_offer'] == 'on') {
					$off_price = $fetch_rec['offer_price'];
					echo "<a style='color:red;'>Offer Price: &#163;$off_price</a> |<a> Original Price: &#163;$rec_price</a>";
					//echo "<p></p>";
				  } else {
					echo "<p>&#163;$rec_price</p>";

				  } ?>
				    </div>
				  </a>
				  <br>
				  <?php
				}
			    }
			  ?>

		      </div>
			<div class="alert_message">
    			  <p>This product and the corresponding information is for project demonstration only. 
			    This content is not of public use, and only used for educational purposes. 
			    All information is under copyright of the company.</p>
  			</div>


		    </div>

             <?php
		}
	  }
	?>
			

  </div> <!---- Content (Closing) ---->
  
 	
</body>

<?php include('includes/footer.php'); ?>			