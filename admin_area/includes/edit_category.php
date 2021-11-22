
<?php 
  $edit_cat = mysqli_query($con, "Select * from FYP_Categories where cat_id='$_GET[cat_id]'");
  $fetch_cat = mysqli_fetch_array($edit_cat);
?>

<div class="form_box">

  <form action="" method="post" enctype="multipart/form-data">
    <h2> Edit Category </h2>
    <div class="border_bottom"> </div><!-- /.border_bottom -->

    <b> Change Category Name: </b><br><br>
    <input type="text" name="product_cat" value="<?php echo $fetch_cat['cat_title']; ?>" size="30" required /><br><br>
    <input type="submit" name="edit_cat" value="Update" />
  </form>

</div> <!-- /.form_box -->
    
<?php 
  if(isset($_POST['edit_cat'])) {
		
	$cat_title = mysqli_real_escape_string($con, $_POST['product_cat']);

	$edit_cat = mysqli_query($con, "update FYP_Categories set cat_title='$cat_title' where cat_id='$_GET[cat_id]'");

	if($edit_cat) {
	  echo "<script>alert('Updated successfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo "<script>alert('Error') </script>";
	}
  }

?>