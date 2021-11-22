<!---- Header starts --->
<?php include('includes/header_index.php'); ?>

<!---- Content starts ---->
  <?php if(!isset($_GET['action'])){ ?>

    <div id="content_area">

	<div class="heading_index">

	  <h1 class="title">Welcome to your local online grocery stores!</h1><br>
	  <h2 class="sub_heading"> Go ahead and explore your local product offers...</h2>

	</div>

	<div id="products_box">	    

	    <?php 
		$get_pro = " select * from FYP_Products where product_offer='on' order by RAND() LIMIT 0,5";
	  	$run_pro = mysqli_query($con, $get_pro);
					
		while($row_pro = mysqli_fetch_array($run_pro)) {
		  $pro_id = $row_pro['product_id'];
		  $pro_cat = $row_pro['product_category'];
		  $pro_brand = $row_pro['product_brand'];

		  // Display brand labels
		  $brand_query = mysqli_query($con, "select * from FYP_Brands where brand_id='$pro_brand'");
		  $fetch_brand = mysqli_fetch_array($brand_query);
		  $brand_title = $fetch_brand['brand_title'];

		  $pro_title = $row_pro['product_title'];
		  $pro_price = number_format($row_pro['product_price'], 2);
		  $off_price = number_format($row_pro['offer_price'], 2);
		  $pro_image = $row_pro['product_image'];

			  echo "
				<div id='single_product'>						
				  <img src='admin_area/product_images/$pro_image'/>
				  <h3> $pro_title </h3>
				  <p class='brand_title'>$brand_title</p>
				  <p class='offer_price'><b> Offer Price: &pound; $off_price </b></p>
				  <p class='price'><b> Original Price: &pound; $pro_price </b></p>
				</div>
			  ";
			}



	    ?>		
		
	  </div><!-- /#products_box -->

	  <img class="visual_intro" src="images/vg_index.png" alt="Set location, purchase cart order, and receive delivery." />
	  
	  <div class="ad1">
	    <img src="images/ad1.png" alt="Register for Exclusive Shopping Experience"/>
	  </div>

	  <div class="ad2">
	    <img src="images/ad2.png" alt="New Local Brands"/>
	  </div>

    </div><!-- /#content_area -->
	
    <?php } else { ?>
	
    <?php 

	include('login.php'); 

	} 
    ?>

<!---- Content ends ---->
  
<!---- Footer starts ---->

<?php include('includes/footer.php'); ?>

<!----Footer ends ----> 
  
