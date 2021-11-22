
<div class="form_box">

<form action="" method="post" enctype="multipart/form-data">
  <h2> Add a Brand </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

  <b> Add New Brand: </b><br><br>
  <input type="text" placeholder="Add New Brand" name="brand" size="30" required /> <br><br>
  <input type="submit" name="insert_brand" value="Add Brand" />
</form>

</div> <!-- /.form_box -->
    
<?php 
  if(isset($_POST['insert_brand'])) {
		
	$brand = mysqli_real_escape_string($con, $_POST['brand']);

	$insert_brand = mysqli_query($con, "insert into FYP_Brands (brand_title) values ('$brand')");

	if($insert_brand) {
	  echo "<script>alert('$brand has been created succesfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo "<script>alert('Error') </script>";
	}
  }

?>