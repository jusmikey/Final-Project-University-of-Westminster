<?php 
  session_start();
  include("includes/db.php");
  include("functions/functions.php");
?>

<html>

<head>

  <title> Welcome to Online Shopping | W1712116 </title>
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles/footer.css" media="all" />
  <link rel="stylesheet" href="styles/header_index.css" media="all" />
  <script src="js/jquery-3.5.1.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

  <div class="main">
    <div class="header">

	<div class="block2">

  	  <div class="header_logo">
  	    <a href="index.php">
    		<img id="logo" alt="Project logo" src="images/logo.png" width="85px" height="100%" />
  	    </a>
  	  </div><!--/.header_logo-->

	</div><!-- /.block2 -->

	<div class="navigation">

	  <a href="index.php">Home</a>
	  <a id="myBtn">Explore Live Product Offers</a>
	  <a href="contact.php">Service Chat</a>

	</div><!-- /.navigation -->

	<div class="block3">

 	  <?php if(!isset($_SESSION['user_id'])){ ?>

	    <a href="index.php?action=login">Login</a>
	    <a href="register.php">Register Membership</a>
	    <a href="brand_area/login.php">Register Your Brand</a>

  	  <?php } else { ?>

	    <a style='position:relative; top:-20;' href="brand_area/login.php">Register Your Brand</a>

  	  <?php 
  	    $select_user = mysqli_query($con,"select * from FYP_Users where id='$_SESSION[user_id] '");
  	    $data_user = mysqli_fetch_array($select_user);
  	  ?>    

	  <ul>
	    <li class="dropdown_header">

	   	<?php if($data_user['image'] !=''){ ?>
	   
	    	  <span><img src="upload-files/<?php echo $data_user['image']; ?>"></span> 
		 
	   	<?php } else { ?>
	   
	   	  <span><img src="images/userIcon.png"></span>
	   
	   	<?php } ?>

	   	  <ul class="dropdown_menu_header">
	     	    <li><a href="my_account.php?action=account">My Account</a></li>
	     	    <li><a href="my_account.php?action=purchase_history">Purchase History</a></li>
		    <li><a href="logout.php">Logout</a></li>
	   	  </ul>
	   
	    </li>
	  </ul>

	  <?php } ?>

	</div><!-- /.block3 --> 

	<!--- The User Location Modal --->
  	<div id="myModal" class="modal">

    	<!--- Modal content --->
    	  <div class="modal-content">
    	    <span class="close">&times;</span>
	    <h3><i class="fa fa-map-marker"></i> Please specify your location for most affordable products near you..</h3><br>
	    <p>Simply write your postcode or the town nearest to your location. </p>
	    <p>If you are in London, then please specify either the borough, street name, or postcode. </p>
	    <br>

    	    <form method="post">
		<input style="width:200px; height:20px;" type="text" name="location" placeholder="Postocode or nearest town" required />
		<input  type="submit" value="Search" name="submit_location" />
    	    </form><br>

    <?php 
	if(isset($_POST['submit_location'])) {
	  $location_value = trim(strtolower($_POST['location']));

	  //Locations allowed (POSTCODES / TOWN NAMES / AREA NAMES(Specifically for London))

	  //London
	  $london_locations = array("regent street", "new cavendish street", "cavendish", "regent", "fitzrovia", "marylebone", "great portland");
	  $london_postcodes = array("w1b", "w1w", "w1u");

	  //Buckighamshire (High Wycombe)
	  $highwycombe_locations = array("high wycombe", "amersham", "chesham", "maidenhead", "watlington", "aylesbury", "benson", "marlow", "west wycombe");
	  $highwycombe_postcodes = array("hp5","hp6","hp7", "hp8","hp9","hp10","hp11","hp12","hp13", "hp14", "hp15", "hp16","hp17");

	  //Surrey (Guildford)
	  $guildford_locations = array("guildford", "wordplesdon", "sutton green", "jacobs well", "whitmoor common", "west clandon", "fairlands", "littleton", "artington", "chilworth", "pewley down", "compton", "peasmarsh", "shalford","farncombe", "bramley", "blackheath");
	  $guildford_postcodes = array("gu1", "gu2", "gu3", "gu4");

	  //Berkshire (Windsor)
	  $windsor_locations = array("windsor", "slough", "maidenhead", "old windsor", "holyport", "taplow", "burnham", "holyport", "bray", "dorney", "dorney reach", "eton wick", "boveney", "water oakley", "fifield", "datchet", "woodside", "cranbourne");
	  $windsor_postcodes = array("sl1", "sl2", "sl3", "sl4", "sl6");

	  //Fetch user first three / four values (sub string)
	  $user_explode = str_split($location_value, 3); //Fetch first 3 values
	  $user_sub = str_split($location_value, 4); //Fetch first 4 values

	  if(in_array($location_value, $london_locations)) {
	    echo "<p style='background:lightgreen; padding:5px; color:white;'>Your location is serviced: " . $location_value . "</p><br>
		<a href='all_products.php?location=london&offers'><p class='location_button'>Explore Live Product Offers in Central London</p></a> ";
	  } elseif(in_array($user_explode[0], $london_postcodes)) {
	    echo "<p style='background:lightgreen; padding:5px; color:white;'>Your postcode is serviced, from " . $user_explode[0] . "</p><br>
		<a href='all_products.php?location=london&offers'><p class='location_button'>Explore Live Products Offers in Central London</p></a> ";
	  } elseif(in_array($location_value, $highwycombe_locations)) {
	    echo "<p style='background:lightgreen; padding:5px; color:white;'>Your location is serviced, from High Wycombe </p><br>
		<a href='all_products.php?location=high_wycombe&offers'> <p class='location_button'>Explore Live Products Offers around High Wycombe</p></a> ";
	  } elseif(in_array($user_explode[0], $highwycombe_postcodes) || in_array($user_sub[0], $highwycombe_postcodes)) {
	    echo "<p style='background:lightgreen; padding:5px; color:white;'>Your location is serviced, from High Wycombe </p><br>
		<a href='all_products.php?location=high_wycombe&offers'> <p class='location_button'>Explore Live Products Offers around High Wycombe</p></a> ";
	  } elseif(in_array($location_value, $guildford_locations)) {
	    echo "<p style='background:lightgreen; padding:5px; color:white;'>Your location is serviced, from Guildford </p><br>
		<a href='all_products.php?location=guildford&offers'> <p class='location_button'>Explore Live Products Offers around Guildford</p></a> ";
	  } elseif(in_array($user_explode[0], $guildford_postcodes)) {
	    echo "<p style='background:lightgreen; padding:5px; color:white;'>Your location is serviced, from Guildford </p><br>
		<a href='all_products.php?location=guildford&offers'> <p class='location_button'>Explore Live Products Offers around Guildford</p></a> ";
	  } elseif(in_array($location_value, $windsor_locations)) {
	    echo "<p style='background:lightgreen; padding:5px; color:white;'>Your location is serviced, from Windsor </p><br>
		<a href='all_products.php?location=windsor&offers'> <p class='location_button'>Explore Live Products Offers around Windsor</p></a> ";
	  } elseif(in_array($user_explode[0], $windsor_postcodes)) {
	    echo "<p style='background:lightgreen; padding:5px; color:white;'>Your location is serviced, from Windsor </p><br>
		<p><a href='all_products.php?location=windsor&offers'> <p class='location_button'>Explore Live Products Offers around Windsor</p></a> ";
	  } else {
	    echo "<p style='background:red; padding:5px; color:white;'>Sorry your location is not serviced. Try a different location";
	  } ?>

 	  <script>
	    var modal = document.getElementById("myModal");
	    modal.style.display = "block";
	  </script>	
        
	<?php } // end if(isset) ?>
    </div>

  </div>

  <!--- Modal User + Service Location --->
  <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
      	modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
  	modal.style.display = "none";
    }

  </script>

    </div <!--- /.header --->

  <div/> <!-- /.main -->

 <?php include('js/drop_down_menu.php'); ?>
