
  <h2> Brand-Support Service Chat </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

<?php

  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  if($fetch_brand['status'] == 'Pending') {

?>

  <p>Currently you have not been approved by the service, please be patient.</p>
  <p>Come back another time, and you will be able to insert your products.</p>

<?php } else { ?>

  <?php 
    $select_message = mysqli_query($con, "select * from FYP_BrandServiceChat where brand_id='$_GET[brand_id]' order by message_timestamp desc");
  ?>

    <div class="chat_container">

	<?php 
	  while($fetch_message = mysqli_fetch_array($select_message)) {
	    $content = $fetch_message['message_content'];
	    $date = $fetch_message['message_timestamp'];

	    if($fetch_message['message_author'] == 'admin') {

	    	echo "
	    	  <div class='admin_message'>
		    <p style='color:#CCCCCC; font-size:12px; font-weight:bold;'>Admin Personnel</p>
	      	    <p>$content</p>
	      	    <p style='margin-top:10px; color:#CCCCCC; float:right; font-size:12px; font-weight:bold;'>$date</p>
	    	  </div>
	    	"; 

	    } elseif($fetch_message['message_author'] == 'brand') {

	    	echo "
	    	  <div class='user_message'>
	      	    <p style='color:#90D6AC; font-size:12px; font-weight:bold;'>$fetch_message[user_email]</p>		    
	      	    <p>$content</p>
	      	    <p style='margin-top:10px; color:#90D6AC; float:right; font-size:12px; font-weight:bold;'>$date</p>
	    	  </div>
	    	"; 
	    }
	  } 
	?>

    </div> <!--- /.chat_container --->
    <div class="border_bottom"> </div><!-- /.border_bottom -->

    <div class="message_container">

   <?php 
	if(isset($_POST['send'])) {
	  $message = trim(mysqli_real_escape_string($con, $_POST['content']));
	  $brand_id = $_GET['brand_id'];
	  $user_email = $_SESSION['email'];

	  $insert_message = mysqli_query($con, "insert into FYP_BrandServiceChat (message_author, brand_id, user_email, message_content) values ('brand','$brand_id', '$user_email', '$message') ");

	  if($insert_message) {
	    echo "<script>alert('Message sent successfully!') </script>" ;
	    echo "<script>window.open(window.location.href,'_self') </script>";
	  } else {
	    echo "<h4 style='background:red; color:white; padding:10px; margin-bottom:20px;'>There was an error with your message, please try again.</h4>";
	    echo mysqli_error($con);
	  }
	}
    ?>

	<div class="form_container">

	  <h3>Send a message for service support </h3><br>
	    <form method="post" action="" id="message_form" enctype="multipart/form-data">
	  	<textarea rows="6" cols="60" name="content" form="message_form" placeholder="Type message for user here." required></textarea><br>
		<input class="bttn" type="submit" name="send" value="Reply" />
	    </form>

	</div> <!--- /.form_container --->
    </div> <!--- /.message_container ---><br><br>

  </body>
</html>

<?php } // End if pending status ?>
