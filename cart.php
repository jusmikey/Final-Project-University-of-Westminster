
<!------------ Header starts --------------------->
  <?php include('includes/header.php'); ?>
<!------------ Header ends ----------------------->

  <?php if(!isset($_GET['location']) || $_GET['location'] == '') {
	echo "<script>alert('Please specify your location..');</script>";
	echo "<script>window.location.replace('index.php');</script>";
  } ?>

<!------------ Content wrapper starts -------------->
  <div class="content_wrapper">
	 
    <div class="shopping_cart_container">

      <div class="continue_cart">
	<a href="all_products.php?location=<?php echo $_GET['location']; ?>"><i class="fa fa-arrow-left" id="left_arr_cont"></i> Continue Your Shopping..</a>
      </div>
 
    	<div class="cart_header">
	      
	  <div class="cart_header_box">
	    <h1><i class="fa fa-shopping-cart"></i> Your Shopping Cart</h1>  
	  </div><!-- /.cart_header_box -->
	      
	</div><!---/.cart_header -------->
	  
	  <div class="cart_left">
	      
	    <div class="cart_left_box">
	  
	  <div id="shopping_cart">
	      
	  <div id="shopping_cart_box">   
	  
	  <?php 
	    if(isset($_SESSION['email'])){
		
		  echo "<b style='color:#90D6AC'>Your Email: </b>" . $_SESSION['email'] . "<br>";
		
		}else{
		
		  echo "";
		}
	  
	  ?>
	   <b style="color:#90D6AC">Total Items In Your Cart: </b>  <?php total_items();?>
	   
	   </div><!--/.shopping_cart_box-->
	   </div><!-- /.shopping_cart ------> 
	   <div class="cart_table">
	   <form action="" method="post" enctype="multipart/form-data">
	   
	   
	       
	   <table>
	   
	     <tr>
		   <th>Remove</th>
		   <th colspan="2">Product</th>
		   <th>Quantity</th>
		   <th style="color:red;">Offer Price</th>
		   <th>Original Price</th>
		   <th>Quantity Total</th>
		 </tr>
		 
	<?php 
    	  $total = 0;
   
   	  $ip = get_ip();
   
   	  $run_cart = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip'");
   
   	  $count_cart = mysqli_num_rows($run_cart);
   
   	  if($count_cart > 1){
       	    $item_message = 'items';
   	  } else {
       	    $item_message = 'item';
   	  }
   
   //Fetch the cart values
   while($fetch_cart = mysqli_fetch_array($run_cart)){
   	$product_id = $fetch_cart['product_id'];
	$product_location = $fetch_cart['product_location'];	  
	$qty = $fetch_cart['quantity'];	   
	$result_product = mysqli_query($con, "select * from FYP_Products where product_id = '$product_id' and status='Approved'");
	   	  
	//Fetch products in the cart

	// If a product's location (product_location) is not the chosen location ($_GET['location'])
	$replace_dash = str_replace('_',' ', $_GET['location']);
	$pos = strpos(strtolower($product_location), str_replace('_',' ',$_GET['location']));

	//Removing items from cart
	$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$replace_dash%')");

	if($pos === false) {
	  echo "<p style='color:white; background:orange; padding:5px;'>Products from a different location were found, these products were already removed from your cart.</p>";

	  //Removing items from cart
	  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$replace_dash%')");
	  
	  if($remove_pros) {
	    break;
	  } else {
	    echo mysqli_error($con);
	  }
	} else {

        while($fetch_product = mysqli_fetch_array($result_product)){              
          $product_price = array($fetch_product['product_price']);
          $product_title = $fetch_product['product_title'];
          $product_image = $fetch_product['product_image'];       
          $sing_price = $fetch_product['product_price']; 
	  $off_price = $fetch_product['offer_price'];

	  //Calculating price of all itmes      
	  $values = array_sum($product_price);		
	  $values_qty = $values * $qty;		
	  $total += $values_qty;

	  //Calculating Prices by Quantity of each product
	  $off_price_quantity = $off_price * $qty;
	  $orig_price_quantity = $sing_price * $qty;

				  
 ?>
		<tr>
		   <td width="2%"><input type="checkbox" name="remove[]" value="<?php echo $product_id;?>" /></td>
		   <td colspan="2">

	   	    <div class="image_title_box">

       		    <div class="cart_image">
        		<img src="admin_area/product_images/<?php echo $fetch_product['product_image']; ?>" width="100" height="70" />  
       		    </div> 
       
       		    <div class="cart_name">
        		<p><a href="details.php?location=<?php echo $_GET['location'];?>&pro_id=<?php echo $fetch_product['product_id'];?>"> <?php echo $fetch_product['product_title']; ?></a></p>   
       		    </div>
     		    </div>   
 
		   </td>

		   <td><input class="qty_id" data-id="<?php echo $product_id; ?>" type="text" size="4" name="qty" value="<?php echo $qty; ?>" /></td>
		   
		   <!--- If product on Offer --->
		   <?php if($fetch_product['product_offer'] == 'on'){ ?>
			<td><?php echo "<b>&#163;" . number_format($fetch_product['offer_price'], 2) . "</b>"; ?></td>
		   <?php } else { ?>
			<td><?php echo "None" ?></td>
		   <?php } ?>
		  
		   <td><?php echo "&#163;" . number_format($sing_price, 2); ?></td>

		   <!--- If product on Offer --->
		   <?php if($fetch_product['product_offer'] == 'on'){ ?>
			<td><?php echo "<b>&#163;" . number_format($off_price_quantity, 2) . "</b>"; ?></td>
		   <?php } else { ?>
			<td><?php echo "<b>&#163;" . number_format($orig_price_quantity, 2) . "</b>"; ?></td>
		   <?php } ?>

		 </tr>
	   
	<?php } //End if not 'location'

	  } } // End While  ?> 

		<tr><th colspan="7"><br></th></tr>
         	
	    <tr align="center">
		   <td colspan="7"><input class="update_cart" type="submit" name="update_cart" value="Update Cart" /></td>		   
		</tr>
		
		<tr><th colspan="7"><br></th></tr>
		
	   </table>
	   
	   </form>
	 
	   </div><!--/.cart_table--->	
 
	 <input type="hidden" class="hidden_ip" value="<?php echo $ip; ?>">
	 
	 <div class="load_ajax"></div>
	   
	 <script>
	  $(document).ready(function(){
	    
	   $(".qty_id").on("keyup", function(){
	    
	    var pro_id = $(this).data("id");
	    
	    var qty = $(this).val();
	    
	    var ip = $(".hidden_ip").val();
	    
	    //alert(ip);
	    
	    // Update product quantity in ajax and php
	    $.ajax({
	    url:'cart/update_qty_ajax.php',
	    type:'post',
	    data:{id:pro_id,quantity:qty,ip:ip},
	    dataType:'html',
	    success:function(update_qty){
	     
	     //alert(update_qty);
	     
	     if(update_qty == 1){
	       $(".load_ajax").html('Your quantity was updated successfully!');
	     }
	        
	    }
	    
	    });
	    
	   });
	   
	  });   
	     
	 </script>  
	   
	   <?php 
	   if(isset($_POST['remove'])){
	     
		 foreach($_POST['remove'] as $remove_id){
		   
		    $run_delete = mysqli_query($con,"delete from FYP_Cart where product_id = '$remove_id' AND ip_address='$ip' ");
		 
		    if($run_delete){
		    	echo "<script>window.open('cart.php?location=$_GET[location]','_self')</script>";
		    }
		 }
	   }
	   	   
	   ?>
	   
	   </div><!---- /.cart_left_box -->
	    
	  </div><!----- /.cart_left --------->
	  
	  <div class="cart_right">
	      
	    <div class="cart_right_box">
	     <p style="font-weight:bold; font-size:22px;">Total Price For All Items: <span style="color:#FFD966"><?php total_price(); ?></span></p>   
	    </div><!--/.cart_right_box-->
	    
	    <div class="checkout_button_box">
	      <a href="checkout.php?payment=process&location=<?php echo $_GET['location']; ?>"><button>Checkout</button></a>
	    </div>
	    
	  </div><!--- /.cart_right ---------->
	  
	 </div><!-- /.shopping_cart_container-->
	
  </div><!-- /.content_wrapper-->
  <!------------ Content wrapper ends -------------->
  
  <?php include ('includes/footer.php'); ?>
  
  