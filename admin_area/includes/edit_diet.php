<?php 
  $edit_diet = mysqli_query($con, "Select * from FYP_DietaryRange where diet_id='$_GET[diet_id]'");
  $fetch_diet = mysqli_fetch_array($edit_diet);
?>

<div class="form_box">

  <form action="" method="post" enctype="multipart/form-data">
    <h2> Edit Dietary Range </h2>
    <div class="border_bottom"> </div><!-- /.border_bottom -->

    <b> Change Dietary Range Title: </b><br><br>
    <input type="text" name="diet_title" value="<?php echo $fetch_diet['diet_title']; ?>" size="30" required /><br><br>		
    <input type="submit" name="edit_diet" value="Update"  />
  </form>

</div> <!-- /.form_box -->
    
<?php 
  if(isset($_POST['edit_diet'])) {
		
	$diet_title = mysqli_real_escape_string($con, $_POST['diet_title']);

	$edit_diet = mysqli_query($con, "update FYP_DietaryRange set diet_title='$diet_title' where diet_id='$_GET[diet_id]'");

	if($edit_diet) {
	  echo "<script>alert('Updated successfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo "<script>alert('Error') </script>";
	}
  }

?>