<!------ Header ------>
  <?php include 'includes/header.php'; ?>

  <?php 
    $ip = get_ip();
    $select_cart = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip'"); ?>

  <?php if(mysqli_num_rows($select_cart) == 1) { ?>

  <!----------------- Single item Payment ----------------->
  <?php include 'payment_single_item.php'; ?>

  <?php } else { ?>

  <!----------------- Multiple item Payment ----------------->
  <?php include 'payment_multiple_items.php'; ?>

  <?php } ?>

  
</body>
</html>