  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <style>

	.chat_container {
	  height:350px;
	  width:100%;
	  overflow:auto;
	}

	.user_message {
	  width:52%;
	  float:left;
	  background:white;
	  padding:13px; 
	  margin:13px 10px 13px 15px; 
	  border:solid lightgrey 0.3px; 
	  border-radius:10px; 
	}

	.admin_message {
	  width:52%;
	  float:right;
	  background:lightblue;
	  padding:13px; 
	  margin:13px 15px 13px 10px; 
	  border:solid lightblue 1px; 
	  border-radius:10px; 
	}

	.message_container {
	  height:220px;
	  width:100%;
	  text-align:center;
	}

	.form_container h3 {
	  padding-top:15px;
	}

 	.bttn {
	  margin-top:20px;
	  padding:8px 30px 8px 30px;
	  cursor:pointer;
	  background:rgb(45, 144, 173);
	  color:white;
	  border:none;
	}

	.bttn:hover {
	  background:rgb(45, 144, 173, 0.7);
	  color:white;
	  border:none;
	}

	.go_back {
	  float:right;
	  margin-right:20px;
	}
	
	.go_back a {
	  font-weight:bold;
	  font-size:18px;
	  color:black;
	  text-decoration:none;
	}

    </style>
  </head>


  <h2> Brand-Support Service Chat </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

<?php

  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  $select_message = mysqli_query($con, "select * from FYP_BrandServiceChat where brand_id='$_GET[brand_id]' order by message_timestamp desc");

?>

    <div class="chat_container">

	<?php 
	  while($fetch_message = mysqli_fetch_array($select_message)) {
	    $content = $fetch_message['message_content'];
	    $date = $fetch_message['message_timestamp'];

	    if($fetch_message['message_author'] == 'brand') {

	    	echo "
	    	  <div class='user_message'>
	      	    <p style='color:blue; font-size:12px; font-weight:bold;'>$fetch_message[user_email]</p>		    
	      	    <p>$content</p>
	      	    <p style='margin-top:10px; color:black; float:right; font-size:12px; font-weight:bold;'>$date</p>
	    	  </div>
	    	"; 

	    } elseif($fetch_message['message_author'] == 'admin') {

	    	echo "
	    	  <div class='admin_message'>
	      	    <p>$content</p>
	      	    <p style='margin-top:10px; float:right; font-size:12px; font-weight:bold;'>$date</p>
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
	  $admin_id = $_SESSION['user_id'];

	  $insert_message = mysqli_query($con, "insert into FYP_BrandServiceChat (message_author, brand_id, message_content, admin_id) values ('admin','$brand_id', '$message', '$admin_id') ");

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

	  <h3>Send a reply to the brand </h3><br>
	    <form method="post" action="" id="message_form" enctype="multipart/form-data">
	  	<textarea rows="6" cols="60" name="content" form="message_form" placeholder="Type message for user here." required></textarea><br>
		<input class="bttn" type="submit" name="send" value="Reply" />
	    </form>

	</div> <!--- /.form_container --->

    </div> <!--- /.message_container ---><br><br>

    <div class="go_back"><p><i class="fa fa-arrow-left"></i><a href="index.php?action=view_brand_messages"> Go back to all Support Chats</a></p></div>

    <br><br>

  </body>

