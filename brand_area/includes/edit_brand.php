
  <h2> Edit Your Brand </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

<?php

  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  $select_bid = mysqli_query($con, "select * from FYP_Brands where brand_title='$fetch_brand[brand_title]'");
  $fetch_bid = mysqli_fetch_array($select_bid);

  if($fetch_brand['status'] == 'Pending') {

?>

  <p>Currently you have not been approved by the service, please be patient.</p>
  <p>Come back another time, and you will be able to insert your products.</p>

<?php } elseif($_SESSION['user_id'] != $fetch_brand['user_id']) { ?>

  <p>You do not have access for this content. <b>Seek Advice if neccessary.</b></p>

<?php } else { ?>

  <div class="edit_section">

    <h3 style="color:#B266FF;">Your Brand Information</h3><br>

    <form method="post" action="">

    	Brand Title: <input type="text" name="brand_title" value="<?php echo $fetch_brand['brand_title']; ?>" />
    	<input type="submit" name="submit_title" /><br>

    	Brand Contact: <input type="text" name="brand_contact" value="<?php echo $fetch_brand['brand_contact']; ?>" />
    	<input type="submit" name="submit_contact" /><br>

    	Business Number: <input type="text" name="brand_number" value="<?php echo $fetch_brand['brand_number']; ?>" />
    	<input type="submit" name="submit_number" /><br><br>

    	<h3 style="color:#B266FF;">Your Main Brand Location</h3><br>

    	City: <input type="text" name="brand_city" value="<?php echo $fetch_brand['brand_city']; ?>" />
    	<input type="submit" name="submit_city" /><br>

    	Postcode: <input type="text" name="brand_postcode" value="<?php echo $fetch_brand['brand_postcode']; ?>" />
    	<input type="submit" name="submit_postcode" /><br>

    	Country: <input type="text" name="brand_country" value="<?php echo $fetch_brand['brand_country']; ?>" />
    	<input type="submit" name="submit_country" /><br><br>

    	<h3 style="color:#B266FF;">Brand Description</h3><br>
    	<textarea name="brand_desc" cols="60" rows="7"><?php echo $fetch_brand['brand_information']; ?></textarea><br>
    	<input type="submit" name="submit_desc" /><br><br>

    </form>

  <?php 

    if(isset($_POST['submit_title'])) {
    	//Check if Brand Title already exists
    	$title = trim(mysqli_real_escape_string($con,$_POST['brand_title']));
    	$check_brand = mysqli_query($con, "select * from FYP_BrandUsers where lower(brand_title) like Lower('$title%')");
    	$count_title = mysqli_num_rows($check_brand);

	if($fetch_brand['brand_title'] == $title){
	  echo "<script>alert('Already set as $title!')</script>";
	} elseif($count_title > 0) {
	  echo "<script>alert('$title is already registered!')</script>";
	} else {
	  $update_title = mysqli_query($con, "update FYP_BrandUsers set brand_title='$title' where brand_id='$_GET[brand_id]'");
	  $update_bid = mysqli_query($con, "update FYP_Brands set brand_title='$title' where brand_id='$fetch_bid[brand_id]'");
	  
	  if($update_title && $update_bid) {
	    echo "<script>alert('Brand title was updated successfully!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";
	  } else {
	    //echo mysqli_error($con);
	    echo "<script>alert('Brand title failed to change, try again!')</script>";
	  }
	}
    }

    if(isset($_POST['submit_contact'])) {
    	//Check if Brand contact already exists
    	$contact = trim(mysqli_real_escape_string($con,$_POST['brand_contact']));
    	$check_cont = mysqli_query($con, "select * from FYP_BrandUsers where brand_contact='$contact'");
    	$count_cont = mysqli_num_rows($check_cont);

	if($fetch_brand['brand_contact'] == $contact){
	  echo "<script>alert('Already set as $contact!')</script>";
	} elseif($count_cont > 0) {
	  echo "<script>alert('$contact is already registered!')</script>";
	} else {
	  $update_con = mysqli_query($con, "update FYP_BrandUsers set brand_contact='$contact' where brand_id='$_GET[brand_id]'");
	  
	  if($update_con) {
	    echo "<script>alert('Brand contact was updated successfully!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";
	  } else {
	    //echo mysqli_error($con);
	    echo "<script>alert('Brand contact failed to change, try again!')</script>";
	  }
	}
    }

    if(isset($_POST['submit_number'])) {
    	//Check if Business Number already exists
    	$bus_num = trim(mysqli_real_escape_string($con,$_POST['brand_number']));
    	$check_num = mysqli_query($con, "select * from FYP_BrandUsers where brand_number='$bus_num'");
    	$count_num = mysqli_num_rows($check_num);

	if($fetch_brand['brand_number'] == $bus_num){
	  echo "<script>alert('Already set as $bus_num!')</script>";
	} elseif($count_num > 0) {
	  echo "<script>alert('$bus_num is already registered!')</script>";
	} else {
	  $update_num = mysqli_query($con, "update FYP_BrandUsers set brand_number ='$bus_num' where brand_id='$_GET[brand_id]'");
	  
	  if($update_num) {
	    echo "<script>alert('Business number was updated successfully!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";
	  } else {
	    echo mysqli_error($con);
	    echo "<script>alert('Business number failed to change, try again!')</script>";
	  }
	}
    }

    if(isset($_POST['submit_city'])) {
	$update_city = mysqli_query($con, "update FYP_BrandUsers set brand_city='$_POST[brand_city]' where brand_id='$_GET[brand_id]'");

	if($update_city) {
	    echo "<script>alert('City location was updated successfully!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";
	} else {
	    echo mysqli_error($con);
	    //echo "<script>alert('Brand description failed to change, try again!')</script>";
	}
    }

    if(isset($_POST['submit_postcode'])) {

  	//Check if brand postcode already exists
    	$post = trim(mysqli_real_escape_string($con,$_POST['brand_postcode']));
    	$check_post = mysqli_query($con, "select * from FYP_BrandUsers WHERE Lower(REPLACE(brand_postcode, ' ', '')) = Lower(REPLACE('$_POST[brand_postcode]', ' ', ''))");
    	$count_post = mysqli_num_rows($check_post);

	if($fetch_brand['brand_postcode'] == $post){
	  echo "<script>alert('Already set as $post!')</script>";
	} elseif($count_post > 0) {
	  echo "<script>alert('$post is already registered!')</script>";
	} else {
	  $update_post = mysqli_query($con, "update FYP_BrandUsers set brand_postcode='$post' where brand_id='$_GET[brand_id]'");

	  if($update_post) {
	    echo "<script>alert('Postcode location was updated successfully!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";
	  } else {
	    echo mysqli_error($con);
	    //echo "<script>alert('Postcode location failed to change, try again!')</script>";
	  }
	}
    }

    if(isset($_POST['submit_country'])) {
	$update_country = mysqli_query($con, "update FYP_BrandUsers set brand_country='$_POST[brand_country]' where brand_id='$_GET[brand_id]'");

	if($update_country) {
	    echo "<script>alert('Country location was updated successfully!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";
	} else {
	    echo mysqli_error($con);
	    //echo "<script>alert('Country failed to change, try again!')</script>";
	}
    }

    if(isset($_POST['submit_desc'])) {
    	$desc = trim(mysqli_real_escape_string($con,$_POST['brand_desc']));
	$update_desc = mysqli_query($con, "update FYP_BrandUsers set brand_information='$desc' where brand_id='$_GET[brand_id]'");

	if($update_desc) {
	    echo "<script>alert('Brand Description was updated successfully!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";
	} else {
	    echo mysqli_error($con);
	    //echo "<script>alert('Brand description failed to change, try again!')</script>";
	}

    }

  ?>

  </div><!---- /.edit_section ---->


<?php } // End if pending status ?>
