<div class="cart">
    <ul>
	  <li class="dropdown_header_cart">
	   <div id="notification_total_cart" class="shopping-cart">
		 <i class="fa fa-shopping-cart" style="font-size:40px"></i>

          <?php
             $ip = get_ip();
             $sel_cart = mysqli_query($con,"select * from FYP_Cart where ip_address='$ip' ");
	     $cart_count = mysqli_num_rows($sel_cart);

	     if($cart_count > 0) {
	  ?>

          <div class="noti_cart_number">
            <?php total_items();?>
          </div><!-- /.noti_cart_number -->

    	  <?php } ?>
		  
	   </div><!--/.shopping-cart ------------>
	   
	   <ul class="sub_dropdown_cart">
	     <li>
           <div style="padding:10px"><b><i class="fa fa-shopping-basket"></i> Your Shopping Cart</b></div>
           
           <div id="over_flow">
 
           
	  <?php 
           while($row_c = mysqli_fetch_array($sel_cart)){
             $get_pro_id = $row_c['product_id']; 
             
             $product_purchase = mysqli_query($con,"select * from FYP_Products where product_id = '$get_pro_id' and status='Approved'");
             
             while($row_product = mysqli_fetch_array($product_purchase)){
            
            ?>
            
            <div class="cart_item_box">
                
             <div class="cart_item_image">
              <img src="admin_area/product_images/<?php echo $row_product['product_image']; ?>">    
             </div><!----/.cart_item_image -->
             
             <div class="cart_item_text_box">
                 
              <div class="cart_item_title">
                <p>
                 <a href="details.php?pro_id=<?php echo $get_pro_id;?>"><?php echo $row_product['product_title']; ?></a>
                </p>  
              </div><!--/.cart_item_title--->
              
              <div class="cart_item_price">
                <p style="color:black">
                &#163;<?php echo number_format($row_c['product_price'], 2); ?>
                </p>  
              </div><!--/.cart_item_price -->
              
             </div><!---/.cart_item_text_box ----->
             
            </div><!--------/.cart_item_box -------------->
            
            <?php } } // End While Loop  ?>  
            
           </div><!--- /#over_flow ---->
	       
	       <div class="cart_item_border"></div>
	       
	       <div style="height:35px;line-height:35px;text-align:right;padding-right:30px"><b>Your Total:</b> <span style="color:#B266FF"><?php total_price(); ?></span></div>
	        
	        <?php if(mysqli_num_rows($sel_cart) > 0 && isset($_GET['location'])) { ?>
	        
	        <div class="go_to_cart_btn_box" align="center">
	         <a href="cart.php?location=<?php echo $_GET['location']; ?>"><button id="btn_go_to_cart">Go to Cart</button></a>    
	        </div>
	        <?php } ?>

	  	<?php if(!isset($_GET['location'])) { ?>

	        <div class="go_to_cart_btn_box" align="center">
	         <a id="myBtn2Loc"><button id="btn_go_to_cart">Explore in your Location</button></a>    
	        </div>

		<?php } ?>

  <!--- Modal User + Service Location --->
  <script>
    // Get the modal
    var modalLoc = document.getElementById("myModalLoc");

    // Get the button that opens the modal
    var btnLoc = document.getElementById("myBtn2Loc");

    // Get the <span> element that closes the modal
    var spanLoc = document.getElementsByClassName("closeLoc")[0];

    // When the user clicks the button, open the modal 
    btnLoc.onclick = function() {
      	modalLoc.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    spanLoc.onclick = function() {
  	modalLoc.style.display = "none";
    }

  </script>

	           
	     </li>
	   </ul>
	   
	  </li>
	</ul>
  </div>  

 