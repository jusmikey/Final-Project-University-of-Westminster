

<?php 
  session_start();

  if(isset($_SESSION['user_id'])){

    include '../includes/db.php';

    $user_id = $_POST['post_user_id'];
    $invoice_number = $_POST['invoice_number'];
    //$location = $_POST['post_loc'];

    $select_user = mysqli_query($con,"select * from FYP_Users where id='$user_id' ");
    $fetch_user = mysqli_fetch_array($select_user);

    $select_note = mysqli_query($con,"select * from FYP_AdditionalNotes where user_id='$user_id' ");

    if(mysqli_num_rows($select_note) > 0){
  	$update = mysqli_query($con,"update FYP_AdditionalNotes set invoice_number='$invoice_number' where user_id='$user_id' ");
  
    } else {
  	$insert_note = mysqli_query($con,"insert into FYP_AdditionalNotes (invoice_number, user_id, type, payment_type) values ('$invoice_number', '$user_id', 'offline', 'Offline Payment' ) ");
  } // End of if statement (isset)

  $fetch_note = mysqli_fetch_array($select_note);
?>

<div class="billing_address_box">
 <div class="billing_address_header">
  <h3>Billing Address</h3> <i class="fa fa-pencil"> Edit</i>
  
  <div class="billing_address_border_header"></div>
 </div> <!-- /.billing_address_header -->
 
 <div class="billing_address_content">
	 <p><strong><?php echo $fetch_user['name'];?></strong></p>
	 <p>Street Address:<?php echo $fetch_user['user_address']; ?></p>
	 <p>City: <?php echo $fetch_user['city']; ?></p>
	 <p>Country: <?php echo $fetch_user['country']; ?></p>
	 <p>Postcode: <?php echo $fetch_user['postcode']; ?></p>
	 <p>Contact: <?php echo $fetch_user['contact']; ?></p>

	 <?php $select_delivery = mysqli_query($con, "select * from FYP_Cart where buyer_id='$_SESSION[user_id]' and delivery_time=null or delivery_time like ''");

	  if(mysqli_num_rows($select_delivery) > 0) {
	    echo "<p><b>Please set your delivery time.</b></p>";
  	  } elseif(mysqli_num_rows($select_delivery) == 0) { 
	    $select_deli = mysqli_query($con, "select * from FYP_Cart where buyer_id='$_SESSION[user_id]'");

	    if(mysqli_num_rows($select_deli) != 0) {
	    $fetch_delivery = mysqli_fetch_array($select_deli);

	    echo "<b>Delivery Time: </b>" . $fetch_delivery['delivery_time'];

	    } 
	  } ?>
	 
	 <div class="additional_info_box">
	  <p>Additional Notes </p>
	  
	<?php if(empty($fetch_note['note_content'])) { ?>
	  <textarea rows="3" id="checkout_additional_editor" placeholder="You can enter any additional notes or information you want inclued with your order here..."></textarea>

	<?php } else { ?>
	  <textarea rows="3" id="checkout_additional_editor" placeholder="You can enter any additional notes or information you want inclued with your order here..."><?php echo $fetch_note['note_content']; ?></textarea>
	<?php } ?>
	  
	 </div>
 
 </div> <!-- /.billing_address_content -->
</div>


<div class="billing_address_form_box" style="display:none">
 <div class="billing_address_header">
  <h3>Edit Billing Address</h3> <i class="fa fa-close"></i>
  
  <div class="billing_address_border_header"></div>
 </div>
 
 <div class="billing_address_content">
	 Name<p><input type="text" id="edit_name" value="<?php echo $fetch_user['name'];?>"></p>
	 Address<p><textarea id="edit_user_address"><?php echo $fetch_user['user_address']; ?></textarea></p>
	 City<p><input type="text" name="city" id="edit_city" value="<?php echo $fetch_user['city']; ?>"></p>

	<p>Country:    
	  <select id="edit_country" name="country">
	    <option value="<?php echo $fetch_user['country']; ?>"> <?php echo $fetch_user['country']; ?> </option>
	    <option value="England"> England </option>
	    <option value="Scotland"> Scotland </option>
	    <option value="Wales"> Wales </option>
	    <option value="Northern Ireland"> Northern Ireland </option>
    	</select></p><br>

	 <!---Country<p><input type="text" id="edit_country" value="<?php echo $fetch_user['country']; ?>"></p>--->

	 Postcode<p><input type="text" id="edit_postcode" value="<?php echo $fetch_user['postcode']; ?>"></p>
	 Contact<p><input type="text" id="edit_contact" value="<?php echo $fetch_user['contact']; ?>"></p><br>

	 <!---- Delivery Type ---->
	 <h4>Delivery Times </h4>
	 <p>All order deliveries take place 24hours after your order purchase.</p>

	 <?php $sel_time = mysqli_query($con, "select * from FYP_Cart where buyer_id='$_SESSION[user_id]'");
	  if(mysqli_num_rows($sel_time) > 0) {
		$fetch_time = mysqli_fetch_array($sel_time);

	  if($fetch_time['delivery_time'] == 'morning') { ?>

	   <input class="edit_delivery" type="radio" name="delivery" value="morning" checked>
	   <label for="morning">10:00 til 16:00</label><br>
	   <input class="edit_delivery" type="radio" name="delivery" value="evening">
	   <label for="afternoon">16:00 til 21:00</label><br><br>

	<?php } else { ?>

	   <input class="edit_delivery" type="radio" name="delivery" value="morning">
	   <label for="morning">10:00 til 16:00</label><br>
	   <input class="edit_delivery" type="radio" name="delivery" value="evening" checked>
	   <label for="afternoon">16:00 til 21:00</label><br><br>

	<?php } 

	} else { ?>

	   <input class="edit_delivery" type="radio" name="delivery" value="morning">
	   <label for="morning">10:00 til 16:00</label><br>
	   <input class="edit_delivery" type="radio" name="delivery" value="evening">
	   <label for="afternoon">16:00 til 21:00</label><br><br>

	<?php } ?>
 
	 <div class="additional_info_box">
	  <p>Additional Notes </p>

	<?php
		if(empty($fetch_note['note_content'])) {
	?>	  

        <textarea rows="3" id="checkout_additional_editor" class="checkout_additional_editor" placeholder="You can enter any additional notes or information you want inclued with your order here..."></textarea>
	<?php } else { ?>
	<textarea rows="3" id="checkout_additional_editor" class="checkout_additional_editor" placeholder="You can enter any additional notes or information you want inclued with your order here..."><?php echo $fetch_note['note_content']; ?></textarea>

	<?php } ?>

	</div>
     
	 <div class="edit_billing_address_btn_box">
	  
	  <button style="cursor:pointer;" id="update_billing_address_btn" data-user_id="<?php echo $user_id; ?>" data-invoice_number="<?php echo $invoice_number; ?>">Update</button>
	  
	  <button style="cursor:pointer;" id="cancel_billing_address_btn">Cancel</button>
	 </div>
 </div>
</div>

<?php } ?>

