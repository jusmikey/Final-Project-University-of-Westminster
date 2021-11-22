  <!-- Footer -->
  <div id="footer">
    <div class="brand_element">
  	<p><a href="brand_area/login.php" target="_blank">You can sell your products too! Register now as a local grocery brand</a></p>
    </div> <!--- /.brand_element --->

    <?php if(isset($_SESSION['user_id'])) {

	//Only display admin access to admin roles!
	if($_SESSION['role'] == 'admin') {
    ?>

    <div class="footer2">
	<a class="admin_footer_link" href="admin_area/login.php">Admin Area (Only Accessible For Admin)</a>
    </div> <!--- /.footer2 --->

    <?php } } //End if statement ?>

    <img src="images/logo.png" alt="Project logo" />

    <div class="footer1">
	<h5 style="color:lightgrey;"> &copy; <?php echo date('Y');?> - Online Shopping Project By Michal Szatkowski (W1712116) </h5>
    </div> <!--- /.footer1 --->
  
  </div> <!-- Footer (Closing) -->	

