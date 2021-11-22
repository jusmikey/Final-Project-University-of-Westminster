<?php 

  $user_account = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $row = mysqli_fetch_array($user_account);

?>

  <h2>Welcome to your Brand Panel: <?php echo $row['brand_title']; ?></h2>
  <div class="border_bottom"> </div><!-- /.border_bottom --><br>
  
  <p>Try any of the sections on on the left navigation tool bar, and enjoy the process..</p><br>
  <p><b>If you have any enquiries, please do not hesitate to contact the Client-Support Team.. </b></p><br>
  <p>All the best for your brand and your team!</p>
