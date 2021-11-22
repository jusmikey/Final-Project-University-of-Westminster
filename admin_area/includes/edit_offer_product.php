  <h2>Edit Product Offer</h2>
  <div class="border_bottom"></div>
<?php 

  $select_pro = mysqli_query($con, "select * from FYP_Products where product_id='$_GET[pro_id]'");
  $fetch_pro = mysqli_fetch_array($select_pro);

  $select_brand = mysqli_query($con, "select * from FYP_Brands where brand_id='$fetch_pro[product_brand]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  $select_cat = mysqli_query($con, "select * from FYP_Categories where cat_id='$fetch_pro[product_category]'");
  $fetch_cat = mysqli_fetch_array($select_cat);

?>

  <p><b>Product LIVE Offer Status: </b> <?php echo $fetch_pro['product_offer']; ?><p/>
  <p><b>Product Title: </b> <?php echo $fetch_pro['product_title']; ?><p/>
  <p><b>Product Brand: </b> <?php echo $fetch_brand['brand_title']; ?><p/>
  <p><b>Product Category: </b> <?php echo $fetch_cat['cat_title']; ?><p/>
  <p><b>Product City: </b> <?php echo $fetch_pro['product_city']; ?><p/>
  <p><b>Product Country: </b> <?php echo $fetch_pro['product_country']; ?><p/><br>
  <p><b>Original Price: </b> &#163;<?php echo number_format($fetch_pro['product_price'], 2); ?><p/>

  <?php 

    $offer_price = number_format($fetch_pro['offer_price'], 2);

    if($fetch_pro['product_offer'] == 'on') {
    	echo "<br><p style='color:red;'><b>Offer Price: </b> &#163;$offer_price<p/>";
    } 

  ?>

  <div class="border_bottom"> </div><!-- /.border_bottom --><br>

  <div style="margin-left:20px;">
  <h3>Set a Product Offer</h3><br>
    <form method="post" action="">
	<input type="radio" value="on" name="offer" /> Turn Offer (ON)<br>
	<input type="radio" value="off" name="offer" /> Turn Offer (OFF)<br><br>
	<label for="offer_price">Offer Price </label>

	<?php 
	  if($fetch_pro['product_offer'] == 'on') { ?>
	    <input type="number" step=".01" min="0" name="offer_price" value="<?php echo $fetch_pro['offer_price']; ?>" required/><br></br>
	<?php } else { ?>
	    <input type="number" step=".01" min="0" name="offer_price" required/><br><br>
	<?php } ?>
	
	<input type="submit" value="Set Changes" name="submit_offer" />
    </form>
    </div><br>

  <?php

    if(isset($_POST['submit_offer'])) {

	if(isset($_POST['offer']) == '') {
	  echo "<script>alert('Please select an option of offer status!');</script>";
	} else {
	  $offer = $_POST['offer'];

	  if($offer == 'on') {
	
	    $update_status = mysqli_query($con, "update FYP_Products set product_offer='on', offer_price='$_POST[offer_price]' where product_id='$_GET[pro_id]'");
 	    
   	    if($update_status) {
		echo "<script>alert('Offer has been turned on!');</script>";
		echo "<script>window.open(window.location.href,'_self')</script>";
	    } else {
		echo "<script>alert('Error with turning on the offer, try again!');</script>";
		//echo mysqli_error($con);
	    }
	   
	  } else {
	    $update_status = mysqli_query($con, "update FYP_Products set product_offer = 'off', offer_price=null where product_id='$_GET[pro_id]'");
	    
   	    if($update_status) {
		echo "<script>alert('Offer has been turned off!');</script>";
		echo "<script>window.open(window.location.href,'_self')</script>";
	    } else {
		echo "<script>alert('Error with turning off the offer, try again!');</script>";
	    }
	  }
	}
    }

  ?>

  <div class="border_bottom"></div><br>
<h3 style='float:right; margin-right:30px;'><i class="fa fa-arrow-left"></i><a href="index.php?action=view_pro" style="color:black; text-decoration:none;"> Go back to all products<a/></h3><br><br>
<h3 style='float:right; margin-right:30px;'><i class="fa fa-arrow-left"></i><a href="index.php?action=view_offers" style="color:black; text-decoration:none;"> View all live offer products<a/></h3><br><br>
