<?php

  function get_ip(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function cart(){
  global $con;
  if(isset($_GET['add_cart'])) {
	$product_id = $_GET['add_cart'];
	$location = $_GET['location'];

	$ip = get_ip();

	$fetch_pro = mysqli_query($con, "select * from FYP_Products where product_id='$product_id' and status='Approved'");
	$fetch_pro = mysqli_fetch_array($fetch_pro);
	$pro_title = $fetch_pro['product_title'];
	$pro_loc = $fetch_pro['product_city'];
	$pro_country = $fetch_pro['product_country'];

	if($fetch_pro['product_offer'] == 'on') {
	  $sql = "INSERT INTO FYP_Cart (product_id, product_price, product_title, product_location, product_country, ip_address) 
		VALUES ('$product_id',$fetch_pro[offer_price],'$pro_title','$pro_loc', '$pro_country','$ip') ";
	  if ($con->query($sql) === TRUE) {
		if(!isset($_GET['cat']) && !isset($_GET['brand']) && !isset($_GET['diet'])) {
		  echo "<script> window.open('all_products.php?location=$location','_self') </script>";
		} else {
		  if(isset($_GET['cat'])) {
		    $cat = $_GET['cat'];
		    echo "<script> window.open('all_products.php?location=$location&cat=$cat','_self') </script>";
		  } elseif(isset($_GET['brand'])) {
		    $brand = $_GET['brand'];
		    echo "<script> window.open('all_products.php?location=$location&brand=$brand','_self') </script>";
		  } elseif(isset($_GET['diet'])) {
		    $diet = $_GET['diet'];
		    echo "<script> window.open('all_products.php?location=$location&diet=$diet','_self') </script>";
		  } elseif(isset($_GET['offers'])) {
		    echo "<script> window.open('all_products.php?location=$location&offers','_self') </script>";
		  }
		}
	  } else {
  		echo "<p style='padding:5px; color:white; background:red;'>" . $pro_title . " is already in your cart!</p><br>";
	  }
        } else {

	  $sql = "INSERT INTO FYP_Cart (product_id, product_price, product_title, product_location, product_country, ip_address) 
		VALUES ('$product_id',$fetch_pro[product_price],'$pro_title','$pro_loc','$pro_country','$ip') ";
	  if ($con->query($sql) === TRUE) {
		if(!isset($_GET['cat']) && !isset($_GET['brand']) && !isset($_GET['diet'])) {
		  echo "<script> window.open('all_products.php?location=$location','_self') </script>";
		} else {
		  if(isset($_GET['cat'])) {
		    $cat = $_GET['cat'];
		    echo "<script> window.open('all_products.php?location=$location&cat=$cat','_self') </script>";
		  } elseif(isset($_GET['brand'])) {
		    $brand = $_GET['brand'];
		    echo "<script> window.open('all_products.php?location=$location&brand=$brand','_self') </script>";
		  } elseif(isset($_GET['diet'])) {
		    $diet = $_GET['diet'];
		    echo "<script> window.open('all_products.php?location=$location&diet=$diet','_self') </script>";
		  } elseif(isset($_GET['offers'])) {
		    echo "<script> window.open('all_products.php?location=$location&offers','_self') </script>";
		  }
		}
	  } else {
  		echo "<p style='padding:5px; color:white; background:red;'>" . $pro_title . " is already in your cart!</p><br>";
	  }
	}
  }		
}

/* Display Total Price of Cart */
function total_price() {

	global $con;
	
	$total = 0;
	$ip = get_ip();
	$run_cart = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip'");

	while($fetch_cart = mysqli_fetch_array($run_cart)) {
	  $product_id = $fetch_cart['product_id'];
	  $qty = $fetch_cart['quantity'];
	  $product_price = array($fetch_cart['product_price']);

	  //Calculating total price inside of the cart
	  $values = array_sum($product_price);
	  $values_qty = $values * $qty;
	  $total += $values_qty;
	}

	echo "&pound;".number_format($total,2);;
}

/* Display Total Items in Cart */
function total_items() {
  global $con;
  $ip = get_ip();
  $run_items = mysqli_query($con,"select * from FYP_Cart where ip_address='$ip'");
  $fetch_item = mysqli_fetch_array($run_items);
  $count_items = mysqli_num_rows($run_items);
							    
  if($count_items == 0) {
    echo "0";
  } else {
    echo $count_items = mysqli_num_rows($run_items);							    
  }  
}


  /* Display Categories */
  function getCats() {
    global $con;
    $location = $_GET['location'];

    $get_cats ="select * from FYP_Categories";
    $run_cats = mysqli_query($con, $get_cats);
		
    while($row_cats=mysqli_fetch_array($run_cats)) {
      $cat_id = $row_cats['cat_id'];

      $cat_title = $row_cats['cat_title'];

      echo "<li><a href='all_products.php?location=$location&cat=$cat_id'> $cat_title </a></li>";	
    }
  } 

  /* Display Brands */
  function getBrands() {
    global $con;
    $location = $_GET['location'];    

    $get_brands = "select * from FYP_Brands";
    $run_brands = mysqli_query($con, $get_brands);
							
    while($row_brands = mysqli_fetch_array($run_brands)) {
      $brand_id = $row_brands['brand_id'];
      $brand_title = $row_brands['brand_title'];

      echo "<li><a href='all_products.php?location=$location&brand=$brand_id'> $brand_title </a></li>";
    }	
  }

  /* Display Diet */
  function getDiet() {
    global $con;
    $location = $_GET['location']; 

    $get_diet = "select * from FYP_DietaryRange";
    $run_diet = mysqli_query($con, $get_diet);
							
    while($row_diet = mysqli_fetch_array($run_diet)) {
      $diet_id = $row_diet['diet_id'];
      $diet_title = $row_diet['diet_title'];

      echo "<li><a href='all_products.php?location=$location&diet=$diet_title'> $diet_title </a></li>";
    }
  }

/* Display Products */
function getPro() {
	if(!isset($_GET['cat'])) {
		if(!isset($_GET['brand'])) {
			if(!isset($_GET['diet'])) {
			  if(!isset($_GET['pro'])) {
			    


			global $con;

		   	$get_pro = " select * from FYP_Products where status='Approved' order by RAND() LIMIT 0,5";
			$run_pro = mysqli_query($con, $get_pro);
			$location = $_GET['location'];
					
			while($row_pro = mysqli_fetch_array($run_pro)) {
			  $pro_id = $row_pro['product_id'];
			  $pro_cat = $row_pro['product_category'];
			  $pro_brand = $row_pro['product_brand'];
			  $pro_title = $row_pro['product_title'];
			  $pro_price = $row_pro['product_price'];
			  $pro_image = $row_pro['product_image'];

			  echo "
				<div id='single_product'>						
					<a href='details.php?pro_id=$pro_id&location=$location'> 
					  <img src='admin_area/product_images/$pro_image' width='180' />
					</a>
					<div class='product_title_space'>
					  <h3> $pro_title </h3>
					</div>
					<p><b> Price: &pound; $pro_price </b></p>
						
					<a href='all_products.php?location=$location&add_cart=$pro_id'>
				  	  <button> Add to Cart </button>
 					</a>
				</div>
			  ";
			}
		}}}
	}
}

function get_pro_by_offer() {
  global $con;
    if(isset($_GET['offers'])) {

	//Set timer of Live Offers
	echo "<p style='font-weight:bold;'>Updated product offers at: " . date("h:i:s A l jS \of F Y ") . "</p><br>";

	//Specific Location of User
	$location = $_GET['location'];

	$get_offer_pro = " select * from FYP_Products where product_offer='on' and status='Approved' and LOWER(product_city) like LOWER('%$location%') order by offer_price asc";
	$run_offer_pro = mysqli_query($con, $get_offer_pro);
	$count_offer = mysqli_num_rows($run_offer_pro);

	if($count_offer == 0) {
	  echo "<h2 style='padding:20px;'> No Products in offers at this moment. <br> Offers sold daily. </h2>";
	}				    

	while($row_offer_pro = mysqli_fetch_array($run_offer_pro)) {
	  $brand_name = mysqli_query($con, "select * from FYP_Brands where brand_id='$row_offer_pro[product_brand]'");
	  $brand_fetch = mysqli_fetch_array($brand_name);

	  $pro_id = $row_offer_pro['product_id'];
	  $pro_cat = $row_offer_pro['product_category'];
	  $pro_title = $row_offer_pro['product_title'];
	  $pro_price = number_format($row_offer_pro['product_price'], 2);
	  $offer_price = number_format($row_offer_pro['offer_price'], 2);
	  $pro_image = $row_offer_pro['product_image'];

	  echo "
	    <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
		<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
		<a href='all_products.php?location=$location&offers&add_cart=$pro_id'>
	  	  <button style='background:red; color:white; margin-top:5px;'> Add to Cart </button>
 		</a>
	    </div>
	  ";
	  
	}
    }

}

function get_pro_by_cat_id() {
  global $con;
    if(isset($_GET['cat'])) {

	//Specific Location of User
	$location = $_GET['location'];

	$cat_id = $_GET['cat'];
	$get_cat_pro = " select * from FYP_Products where product_category='$cat_id' and status='Approved' and LOWER(product_city) like LOWER('%$location%') order by product_price asc";
	$run_cat_pro = mysqli_query($con, $get_cat_pro);
	$count_cats = mysqli_num_rows($run_cat_pro);

	if($count_cats == 0) {
	  echo "<h2 style='padding:20px;'> No Products in this category. <br> More products coming daily. </h2>";
	}				    

	while($row_cat_pro = mysqli_fetch_array($run_cat_pro)) {
	  $brand_name = mysqli_query($con, "select * from FYP_Brands where brand_id='$row_cat_pro[product_brand]'");
	  $brand_fetch = mysqli_fetch_array($brand_name);

	  $pro_id = $row_cat_pro['product_id'];
	  $pro_cat = $row_cat_pro['product_category'];
	  $pro_brand = $row_cat_pro['product_brand'];
	  $pro_title = $row_cat_pro['product_title'];
	  $pro_price = number_format($row_cat_pro['product_price'], 2);
	  $pro_image = $row_cat_pro['product_image'];
	  $offer_price = number_format($row_cat_pro['offer_price'], 2);

	  if($row_cat_pro['product_offer'] == 'on') {
	    echo "
	      <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
		<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
		<a href='all_products.php?location=$location&cat=$cat_id&add_cart=$pro_id'>
	  	  <button style='background:red;'> Add to Cart </button>
 		</a>
	      </div>
	    ";
	  } else {
	    echo "
	      <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p><b> Price: &pound; $pro_price </b></p>
						
		<a href='all_products.php?location=$location&cat=$cat_id&add_cart=$pro_id'>
	  	  <button> Add to Cart </button>
 		</a>
	      </div>
	    ";
	  }
	}
    }

}

function get_pro_by_brand_id() {
  global $con;
    if(isset($_GET['brand'])) {

	//Specific Location of User
	$location = $_GET['location'];

	$brand_id = $_GET['brand'];
	$get_brand_pro = " select * from FYP_Products where product_brand='$brand_id' and status='Approved' and LOWER(product_city) like LOWER('%$location%') order by product_price asc";
	$run_brand_pro = mysqli_query($con, $get_brand_pro);
	$count_brand = mysqli_num_rows($run_brand_pro);

	if($count_brand == 0) {
	  echo "<h3 style='padding:20px;'> No Products of this brand. <br> More products coming daily. </h3>";
	}

	while($row_brand_pro = mysqli_fetch_array($run_brand_pro)) {
	  $brand_name = mysqli_query($con, "select * from FYP_Brands where brand_id='$row_brand_pro[product_brand]'");
	  $brand_fetch = mysqli_fetch_array($brand_name);

	  $pro_id = $row_brand_pro['product_id'];
	  $pro_cat = $row_brand_pro['product_category'];
	  $pro_brand = $row_brand_pro['product_brand'];
	  $pro_title = $row_brand_pro['product_title'];
	  $pro_price = number_format($row_brand_pro['product_price'],2);
	  $pro_image = $row_brand_pro['product_image'];
	  $offer_price = number_format($row_brand_pro['offer_price'], 2);

	  if($row_brand_pro['product_offer'] == 'on') {
	    echo "
	      <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
		<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
		<a href='all_products.php?location=$location&brand=$brand_id&add_cart=$pro_id'>
	  	  <button style='background:red;'> Add to Cart </button>
 		</a>
	      </div>
	    ";
	  } else {
	    echo "
	      <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p><b> Price: &pound; $pro_price </b></p>
						
		<a href='all_products.php?location=$location&brand=$brand_id&add_cart=$pro_id'>
	  	  <button> Add to Cart </button>
 		</a>
	      </div>
	    ";
	  }
	} // End while loop
    } 
}


/* Display Diet Range Products */
function get_pro_by_diet_id() {
  global $con;

  if(isset($_GET['diet'])) {

	//Specific Location of User
	$location = $_GET['location'];

	$diet_title = $_GET['diet'];
	$get_diet_pro = " select * from FYP_Products where product_diet LIKE '%$diet_title%' and status='Approved' and LOWER(product_city) like LOWER('%$location%') order by product_price asc";
	$run_diet_pro = mysqli_query($con, $get_diet_pro);
	$count_diet = mysqli_num_rows($run_diet_pro);

	if($count_diet == 0) {
	  echo "<h2 style='padding:20px;'> No products in $diet_title <br> More products coming daily. </h2>";
	}

	while($row_diet_pro = mysqli_fetch_array($run_diet_pro)) {
	  $brand_name = mysqli_query($con, "select * from FYP_Brands where brand_id='$row_diet_pro[product_brand]'");
	  $brand_fetch = mysqli_fetch_array($brand_name);

	  $pro_id = $row_diet_pro['product_id'];
	  $pro_cat = $row_diet_pro['product_category'];
	  $pro_brand = $row_diet_pro['product_brand'];
	  $pro_title = $row_diet_pro['product_title'];
	  $pro_price = number_format($row_diet_pro['product_price'],2);
	  $pro_image = $row_diet_pro['product_image'];
	  $offer_price = number_format($row_diet_pro['offer_price'], 2);

	  if($row_diet_pro['product_offer'] == 'on') {
	    echo "
	      <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
		<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
		<a href='all_products.php?location=$location&diet=$diet_title&add_cart=$pro_id'>
	  	  <button style='background:red;'> Add to Cart </button>
 		</a>
	      </div>
	    ";
	  } else {
	    echo "
	      <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p><b> Price: &pound; $pro_price </b></p>
						
		<a href='all_products.php?location=$location&diet=$diet_title&add_cart=$pro_id'>
	  	  <button> Add to Cart </button>
 		</a>
	      </div>
	    ";
	  }
	} // End while loop	
  }

}

/* Display Filteration */

function get_pro_by_filter() {
  global $con;

    if(isset($_GET['pro'])) {

    //Specific Location of User
    $location = $_GET['location'];

    $pro_filter = $_GET['pro'];

    $select_pro = mysqli_query($con, "select * from FYP_Products where product_title like '%$pro_filter%' and status='Approved' and LOWER(product_city) like LOWER('%$location%') order by product_price asc");
    $count_cats = mysqli_num_rows($select_pro);

    if($count_cats == 0) {
	echo "<h2 style='padding:20px;'> No Products in this category. <br> More products coming daily. </h2>";
    }

    echo "<i class='fa fa-arrow-left' aria-hidden='true'></i> <input class='go_back_filter' style='border:none; background:none; font-size:17px; cursor:pointer;' action='action' type='button' value='Go Back' onclick='window.history.go(-1); return false;' /><br>";

    while($fetch = mysqli_fetch_array($select_pro)) {
	  $brand_name = mysqli_query($con, "select * from FYP_Brands where brand_id='$fetch[product_brand]'");
	  $brand_fetch = mysqli_fetch_array($brand_name);

	  $pro_id = $fetch['product_id'];
	  $pro_cat = $fetch['product_category'];
	  $pro_brand = $fetch['product_brand'];
	  $pro_title = $fetch['product_title'];
	  $pro_price = number_format($fetch['product_price'], 2);
	  $pro_image = $fetch['product_image'];
	  $offer_price = number_format($fetch['offer_price'], 2);

	  if($fetch['product_offer'] == 'on') {
	    echo "
	      <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p style='color:red; font-size:20px;'><b>On Offer: &pound; $offer_price </b></p>
		<p style='font-size:13px;'> Before Offer: &pound; $pro_price </p>
	  				
		<a href='all_products.php?location=$location&cat=$pro_cat&add_cart=$pro_id'>
	  	  <button style='background:red;'> Add to Cart </button>
 		</a>
	      </div>
	    ";
	  } else {
	    echo "
	      <div id='single_product'>						
		<a href='details.php?pro_id=$pro_id&location=$location'> 
		  <img src='admin_area/product_images/$pro_image' width='180' />
		</a>
		<h3> $pro_title </h3>
		<p><a style='border:#FFD966 dotted 2px; padding:5px;'>$brand_fetch[brand_title]</a></p><br>
		<p><b> Price: &pound; $pro_price </b></p>
						
		<a href='all_products.php?location=$location&cat=$pro_cat&add_cart=$pro_id'>
	  	  <button> Add to Cart </button>
 		</a>
	      </div>
	    ";
	  }
    }	
  } 

}

?>