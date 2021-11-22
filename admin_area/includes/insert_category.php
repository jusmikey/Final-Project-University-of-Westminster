
<div class="form_box">
  <h2> Add Category </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

    <form action="" method="post" enctype="multipart/form-data">

	<b> Add New Category: </b><br><br>
	<input type="text" placeholder="Add New Product Category" name="product_cat" size="30" required /><br><br> 
		
	<input type="submit" name="insert_cat" value="Add Category" />

    </form>

</div> <!-- /.form_box -->
    
<?php 
  if(isset($_POST['insert_cat'])) {
		
	$product_cat = mysqli_real_escape_string($con, $_POST['product_cat']);

	$insert_cat = mysqli_query($con, "insert into FYP_Categories (cat_title) values ('$product_cat')");

	if($insert_cat) {
	  echo "<script>alert('$product_cat has been created succesfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo "<script>alert('Error') </script>";
	}
  }

?>