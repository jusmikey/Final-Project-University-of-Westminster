
<!---- Header starts ---->
<?php include('includes/header.php'); ?>
<!---- Header ends ----->

  <?php if(!isset($_GET['location']) || empty($_GET['location'])) {
	echo "<script>alert('Please select your location.')</script>";
	echo "<script>window.location.replace('index.php');</script>";
  } ?>

<!---- Content wrapper starts ---->
  <div class="content_wrapper">
  
  <?php if(!isset($_GET['action'])){ 

    $location = $_GET['location'];

    if($location == '') {
    	echo "<p style='background:red; cursor:pointer; color:white;'>No products available, please choose a location.</p>";
    } else { ?>

  
    <div id="sidebar" class="sidebar_desktop">
    
    <div class="sidebar_box">

	<div class="side_offers_link"><a style="font-size:23px; text-decoration:none; color:#B266FF;" href="all_products.php?location=<?php echo $location; ?>&offers"> Live Offers </a></div>

	<div class="side_offers_link"><a style="font-size:20px; text-decoration:none; color:#FFD966;" href="all_products.php?location=<?php echo $location; ?>"> All Products </a></div>
	
	<!---- For Mobile / Tablet Devices ---->
	<div id="sidebar_title_mob"> Categories </div>
	<div id="sidebar_title_mob"> Local Markets </div>
	<div id="sidebar_title_mob"> Dietary Range </div>

	<div id="sidebar_title"> Categories </div>
	  <ul id="cats"><?php getCats(); ?></ul>

	<div id="sidebar_title"> Local Markets </div>
	  <ul id="cats"><?php getBrands(); ?></ul>

	<div id="sidebar_title"> Dietary Range </div>
	  <ul id="cats"><?php getDiet(); ?>

    </div><!--- /.sidebar_box --->
    
    </div><!--- /#sidebar --->
	
    <!--- Products Content --->
	<div id="products_content_area">
	
	<?php 
	  cart();
	  include('functions/filter.php');
	?>
	
	  <div id="products_box">	    
  <?php

  $display_pro = mysqli_query($con, "select * from FYP_Products where LOWER(product_city) like LOWER('%$location%') and status='Approved' order by product_title asc");

    // Functions to display specific products under the category filter 

    get_pro_by_cat_id(); 
    get_pro_by_brand_id(); 
    get_pro_by_diet_id(); 
    get_pro_by_offer();
    get_pro_by_filter();

  //Display specific products of specific location
  while($fetch_pro = mysqli_fetch_array($display_pro)) {
    $brand_name = mysqli_query($con, "select * from FYP_Brands where brand_id='$fetch_pro[product_brand]'");
    $brand_fetch = mysqli_fetch_array($brand_name);

    $product_id = $fetch_pro['product_id'];
    $pro_image = $fetch_pro['product_image'];
    $pro_title = $fetch_pro['product_title'];
    $pro_price = number_format($fetch_pro['product_price'], 2);
    $pro_brand = $fetch_pro['product_brand'];
    $offer_price = number_format($fetch_pro['offer_price'], 2);

    if($location == 'high_wycombe') {
	//If category is not set
	if(!isset($_GET['offers'])) {
	if(!isset($_GET['cat'])) {
	  if(!isset($_GET['brand'])) {
	    if(!isset($_GET['diet'])) {
	      if(!isset($_GET['search']) == 'Search') {
	        if(!isset($_GET['pro'])) {

		if($fetch_pro['product_offer'] == 'on') {
		  echo "
		    <div id='single_product'>						
		    	<a href='details.php?pro_id=$product_id&location=$location'> 
		  	  <img src='admin_area/product_images/$pro_image' />
			</a>
			<h3> $pro_title </h3>
			<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
			<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
			<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
			<a href='all_products.php?location=$location&add_cart=$product_id'>
	  	  	  <button style='background:red;'> Add to Cart </button>
 			</a>
	    	    </div>
	  	  ";

		} else {
	    	  echo " 
	  	    <div id='single_product'>						
	    	  	<a href='details.php?pro_id=$product_id&location=$location'> 
		    	  <img src='admin_area/product_images/$pro_image'/>
	    	  	</a>

	    	  	<h3> $pro_title </h3>
	    	  	<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
	    	  	<p><b> Price: &pound; $pro_price </b></p>
						
	    	  	<a href='all_products.php?location=$location&add_cart=$product_id'>
		    	  <button> Add to Cart </button>
 	    	  	</a>
	  	    </div>
	  	  ";

		}}
	}}}}} 
    
    } elseif($location == 'london') {

	//If category is not set
	if(!isset($_GET['offers'])) {
	if(!isset($_GET['cat'])) {
	  if(!isset($_GET['brand'])) {
	    if(!isset($_GET['diet'])) {
	      if(!isset($_GET['search']) == 'Search') {
	        if(!isset($_GET['pro'])) {

		if($fetch_pro['product_offer'] == 'on') {
		  echo "
		    <div id='single_product'>						
		    	<a href='details.php?pro_id=$product_id&location=$location'> 
		  	  <img src='admin_area/product_images/$pro_image' />
			</a>
			<h3> $pro_title </h3>
			<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
			<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
			<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
			<a href='all_products.php?location=$location&add_cart=$product_id'>
	  	  	  <button style='background:red;'> Add to Cart </button>
 			</a>
	    	    </div>
	  	  ";

		} else {
	    	  echo " 
	  	    <div id='single_product'>						
	    	  	<a href='details.php?pro_id=$product_id&location=$location'> 
		    	  <img src='admin_area/product_images/$pro_image' />
	    	  	</a>

	    	  	<h3> $pro_title </h3>
	    	  	<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
	    	  	<p><b> Price: &pound; $pro_price </b></p>
						
	    	  	<a href='all_products.php?location=$location&add_cart=$product_id'>
		    	  <button> Add to Cart </button>
 	    	  	</a>
	  	    </div>
	  	  ";

		}}
	}}}}} 

    } elseif($location == 'guildford') {
	//If category is not set
	if(!isset($_GET['offers'])) {
	if(!isset($_GET['cat'])) {
	  if(!isset($_GET['brand'])) {
	    if(!isset($_GET['diet'])) {
	      if(!isset($_GET['search']) == 'Search') {
	        if(!isset($_GET['pro'])) {

		if($fetch_pro['product_offer'] == 'on') {
		  echo "
		    <div id='single_product'>						
		    	<a href='details.php?pro_id=$product_id&location=$location'> 
		  	  <img src='admin_area/product_images/$pro_image'/>
			</a>
			<h3> $pro_title </h3>
			<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
			<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
			<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
			<a href='all_products.php?location=$location&add_cart=$product_id'>
	  	  	  <button style='background:red;'> Add to Cart </button>
 			</a>
	    	    </div>
	  	  ";

		} else {
	    	  echo " 
	  	    <div id='single_product'>						
	    	  	<a href='details.php?pro_id=$product_id&location=$location'> 
		    	  <img src='admin_area/product_images/$pro_image'/>
	    	  	</a>

	    	  	<h3> $pro_title </h3>
	    	  	<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
	    	  	<p><b> Price: &pound; $pro_price </b></p>
						
	    	  	<a href='all_products.php?location=$location&add_cart=$product_id'>
		    	  <button> Add to Cart </button>
 	    	  	</a>
	  	    </div>
	  	  ";

		}}
	}}}}}
	
    } elseif($location == 'windsor') {
	//If category is not set
	if(!isset($_GET['offers'])) {
	if(!isset($_GET['cat'])) {
	  if(!isset($_GET['brand'])) {
	    if(!isset($_GET['diet'])) {
	      if(!isset($_GET['search']) == 'Search') {
	        if(!isset($_GET['pro'])) {

		if($fetch_pro['product_offer'] == 'on') {
		  echo "
		    <div id='single_product'>						
		    	<a href='details.php?pro_id=$product_id&location=$location'> 
		  	  <img src='admin_area/product_images/$pro_image'/>
			</a>
			<h3> $pro_title </h3>
			<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
			<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
			<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
			<a href='all_products.php?location=$location&add_cart=$product_id'>
	  	  	  <button style='background:red;'> Add to Cart </button>
 			</a>
	    	    </div>
	  	  ";

		} else {
	    	  echo " 
	  	    <div id='single_product'>						
	    	  	<a href='details.php?pro_id=$product_id&location=$location'> 
		    	  <img src='admin_area/product_images/$pro_image'/>
	    	  	</a>

	    	  	<h3> $pro_title </h3>
	    	  	<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
	    	  	<p><b> Price: &pound; $pro_price </b></p>
						
	    	  	<a href='all_products.php?location=$location&add_cart=$product_id'>
		    	  <button> Add to Cart </button>
 	    	  	</a>
	  	    </div>
	  	  ";

		}}
	}}}}} 
    }


  } //end while 

    //User Product Search functionality
    
    if(isset($_GET['search']) == 'Search') {

	$search_query = trim(mysqli_real_escape_string($con, $_GET['user_query']));
	$run_query = mysqli_query($con, "SELECT * FROM FYP_Products WHERE status='Approved' and match(product_title) against('$search_query' IN BOOLEAN MODE) LIMIT 1,10");
	$queryResult = mysqli_num_rows($run_query);
	
		if($queryResult > 0) {
		  while($fetch_row = mysqli_fetch_array($run_query)) {
    		    $brand_name = mysqli_query($con, "select * from FYP_Brands where brand_id='$fetch_row[product_brand]'");
    		    $brand_fetch = mysqli_fetch_array($brand_name);

			$pro_id = $fetch_row['product_id'];
			$pro_cat = $fetch_row['product_category'];
			$pro_brand = $fetch_row['product_brand'];
			$pro_title = $fetch_row['product_title'];
			$pro_price = number_format($fetch_row['product_price'],2);
			$offer_price = number_format($fetch_row['offer_price'],2);
			$pro_image = $fetch_row['product_image'];

			if($fetch_row['product_offer'] == 'on') {
		  	  echo "
		    	    <div id='single_product'>						
		    		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  	  	  <img src='admin_area/product_images/$pro_image'/>
				</a>
				<h3> $pro_title </h3>
				<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
				<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
				<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
				<a href='all_products.php?location=$location&add_cart=$pro_id'>
	  	  	  	  <button style='background:red;'> Add to Cart </button>
 				</a>
	    	    	    </div>
	  	  	  ";
			} else {
			  echo "
			    <div id='single_product'>						
			    	<a href='details.php?pro_id=$pro_id&location=$location'> 
			  	  <img src='admin_area/product_images/$pro_image'/>
			    	</a>
			    	<h3> $pro_title </h3>
			    	<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
			    	<p><b> Price: &pound; $pro_price</b></p>
			    	<a href='all_products.php?location=$location&add_cart=$pro_id'>
				  <button> Add to Cart </button>
 			    	</a>
			    </div>
			  " ;
			}
		  } //End while loop

		} else {
		  echo "<h4>No Search Results for " . $search_query . "</h4>";
		} 

    } // end if statement of search

?>		
  	</div><!-- /#products_box -->
	  
    </div><!-- /#content_area -->

  <?php 
 	} // End if 'location'

    // If user chooses 'Login'
    } else {  
	include('login.php'); 
    } 
  ?>
		
  </div><!-- /.content_wrapper-->
  <!------------ Content wrapper ends -------------->
  
  <?php include ('includes/footer.php'); ?>
  
  
