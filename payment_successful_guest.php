
<!DOCTYPE html><!-- Declaration HTML5 -->
<html>
<head>
  <title>Purchase Payment</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <?php include 'includes/header.php'; ?>
  <!---<link href="styles/checkout.css" rel="stylesheet" />-->

  <style>
    //.menubar {display:none !important;}
  </style>

  <?php 
    $ip = get_ip();
    $select_cart = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip'"); ?>

  <?php if(mysqli_num_rows($select_cart) == 1) { ?>

  <!----------------- Single item Payment ----------------->
  <?php include 'guest/payment_single_item.php'; ?>

  <?php } else { ?>

  <!----------------- Multiple item Payment ----------------->
  <?php include 'guest/payment_multiple_items.php'; ?>


  <?php } ?>

  
</body>
</html>