
<!-- (FOR REGISTERED USER) SUPPORT CHAT -->
<?php 
  $select_message = mysqli_query($con, "select * from FYP_ServiceChat where user_id='$_GET[user_id]' order by message_timestamp desc");
?>

<html>

  <body>
    <h2>Support Chat for User ID: <?php echo $_GET['user_id'];?></h2>
    <div class="border_bottom"></div><br>

    <div class="chat_container">

	<?php 
	  while($fetch_message = mysqli_fetch_array($select_message)) {
	    $content = $fetch_message['message_content'];
	    $date = $fetch_message['message_timestamp'];

	    if($fetch_message['message_author'] == 'user') {

	    	echo "
	    	  <div class='user_message'>
	      	    <p style='float:left; width:100%; font-size:12px; font-weight:bold;'>Consumer</p>
	      	    <p>$content</p>
	      	    <p style='float:right; width:100%; font-size:12px; font-weight:bold;'>$date</p>
	    	  </div>
	    	"; 

	    } elseif($fetch_message['message_author'] == 'admin') {

	    	echo "
	    	  <div class='admin_message'>
	      	    <p style='float:left; width:100%; font-size:12px; font-weight:bold;'>Admin</p>
	      	    <p>$content</p>
	      	    <p style='float:right; width:100%; font-size:12px; font-weight:bold;'>$date</p>
	    	  </div>
	    	"; 
	    }
	  } 
	?>

    </div> <!--- /.chat_container --->
  <div class="border_bottom"></div>

    <div class="message_container">

   <?php 
	if(isset($_POST['send'])) {
	  $message = $_POST['content'];
	  $admin_id = $_SESSION['user_id'];
	  $user_id = $_GET['user_id'];

	  if($admin_id == $user_id) {
	    echo "<h4 style='background:red; color:white; padding:10px; margin-bottom:20px;'>You cannot send yourself a message, please choose an appropriate user.</h4>";
	  } elseif(empty($message)) {
	    echo "<h4 style='background:red; color:white; padding:10px; margin-bottom:20px;'>Your reply is empty, please write a message.</h4>";
	  } else {
	    $insert_message = mysqli_query($con, "insert into FYP_ServiceChat (message_author, user_id, message_content, admin_id) values ('admin','$user_id','$message','$admin_id')");

	    /* Send Reply Email to Consumer in Support */
	    $to = "michbodzio97@yahoo.com"; //$consumer
	    $subject = "Reply from Client Support Team | W1712116 Online Shopping.";
	    $txt = "You have received reply from Client Support at FYP_w1712116 Online Shopping, where you can also find in your account!" . "\r\n Reply: " .
		$message;
	    
	    $headers = "Client Support Team has responded to your enquiry.";

	    if($insert_message) {
	  	echo "<script>alert('Reply sent successfully!') </script>" ;
	  	echo "<script>window.open(window.location.href,'_self') </script>";
 		mail($to,$subject,$txt,$headers);

	    } else {
	    	echo "<h4 style='background:red; color:white; padding:10px; margin-bottom:20px;'>There was an error with your message, please try again.</h4>";
	    }
	  }
	}
    ?>

	<div class="form_container">

	  <h3>Send a reply to consumer support request</h3><br>
	    <form method="post" action="" id="message_form" enctype="multipart/form-data">
	  	<textarea rows="6" cols="60" name="content" form="message_form" placeholder="Type message for user here." required></textarea><br>
		<input class="bttn" type="submit" name="send" value="Reply" />
	    </form>

	</div> <!--- /.form_container --->
    </div> <!--- /.message_container --->

    <div class="go_back"><p><i class="fa fa-arrow-left"></i><a href="index.php?action=view_messages"> Go back to all Support Chats</a></p></div>

  </body>
</html>