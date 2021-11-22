
<form method="post" action="" >

  <input type="submit" name="submit_loc" />

</form>

<?php 

if(isset($_POST['submit_loc'])) {
$select_user = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
$fetch_user = mysqli_fetch_array($select_user);

$ip = get_ip();

	//Locations allowed (POSTCODES / TOWN NAMES / AREA NAMES(Specifically for London))

	//Setting City
	$location_value_city = strtolower($fetch_user['city']);
	$location_value_post = strtolower($fetch_user['postcode']);

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
	$user_explode = str_split($location_value_post, 3); //Fetch first 3 values
	$user_sub = str_split($location_value_post, 4); //Fetch first 4 values

	//False country location to that of products
        $select_cart_country = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_country) not like lower('%$fetch_user[country]%')");

	//False country location to that of products
        $select_cart_loc = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_location) not like lower('%$fetch_user[city]%')");

	if($location_value_city == 'london' || in_array($user_explode[0], $london_postcodes) || in_array($location_value_city, $highwycombe_locations) 
	  || in_array($user_explode[0], $highwycombe_postcodes) || in_array($user_sub[0], $highwycombe_postcodes) || in_array($location_value_city, $guildford_locations) || in_array($user_explode[0], $guildford_postcodes)
	  || in_array($location_value_city, $windsor_locations) || in_array($user_explode[0], $windsor_postcodes)) {

	  //Eliminate specified locations
	  if($location_value_city == 'london') { 
	    if(in_array($user_explode[0], $london_postcodes) == false) {
		echo "<script>alert('Invalid Postcode')</script>";

	    } elseif(mysqli_num_rows($select_cart_country) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_country) not like lower('%$fetch_user[country]%')");
		echo "<script>alert('Products were removed by invalid location')</script>";

	    } elseif(mysqli_num_rows($select_cart_loc) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_location) not like lower('%$fetch_user[city]%')");
		echo "<script>alert('Products were removed by invalid location')</script>";

	    } else {
		include('payment.php');
	   }

	  } }}

?>