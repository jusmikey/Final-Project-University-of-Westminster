  <h2> Your Brand </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

<?php
  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  if($fetch_brand['status'] == 'Pending') {

?>

  <p>Currently you have not been approved by the service, please be patient.</p>
  <p>Come back another time, and you will be able to view your brand.</p>

<?php } else { ?>

  <h3 style="color:#FFD966;">Your Brand Information:</h3><br>
  <p><b>Brand Title: </b><?php echo $fetch_brand['brand_title']; ?></p>
  <p><b>Brand ID: </b><?php echo $fetch_brand['brand_id']; ?></p>
  <p><b>Brand Contact: </b><?php echo $fetch_brand['brand_contact']; ?></p>
  <p><b>Business Number: </b><?php echo $fetch_brand['brand_number']; ?></p>
  <p><b>Brand Registration Date: </b><?php echo $fetch_brand['register_date']; ?></p><br>

  <h3 style="color:#FFD966;">Your Main Location:</h3><br>
  <p><b>Brand City: </b><?php echo $fetch_brand['brand_city']; ?></p>
  <p><b>Brand Postcode: </b><?php echo $fetch_brand['brand_postcode']; ?></p>
  <p><b>Brand Country: </b><?php echo $fetch_brand['brand_country']; ?></p><br>

  <h3 style="color:#FFD966;">Other:</h3><br>
  <p><b>Brand Description: </b><?php echo $fetch_brand['brand_information']; ?></p>








<?php } // End if pending status ?>
