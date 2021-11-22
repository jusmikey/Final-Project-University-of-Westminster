
<div class="form_box">

  <form action="" method="post" enctype="multipart/form-data">
    <h2> Add Dietary Range </h2>
    <div class="border_bottom"> </div><!-- /.border_bottom -->

    <b> Add New Diet: </b><br><br>
    <input type="text" placeholder="Add New Diet Range" name="diet_title" size="30" required /><br><br> 
    <input type="submit" name="insert_diet" value="Add Dietary Range" />
  </form>

</div> <!-- /.form_box -->
    
<?php 
  if(isset($_POST['insert_diet'])) {
		
	$product_diet = mysqli_real_escape_string($con, $_POST['diet_title']);

	$insert_diet = mysqli_query($con, "insert into FYP_DietaryRange (diet_title) values ('$product_diet')");

	if($insert_diet) {
	  echo "<script>alert('$product_diet has been created succesfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo "<script>alert('Error') </script>";
	}
  }

?>