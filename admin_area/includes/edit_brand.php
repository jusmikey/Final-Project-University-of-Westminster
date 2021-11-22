<?php 
  $edit_brand = mysqli_query($con, "Select * from FYP_Brands where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($edit_brand);
?>

<div class="form_box">

	<form action="" method="post" enctype="multipart/form-data">
	  <table align="center" width="100%"> 
		<tr>
		  <td colspan="7">
		  <h2> Edit Brand </h2>
		  <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td> 
		</tr>

		<tr> 
		  <td><b> Change Brand Title: </b></td>
		  <td><input type="text" name="brand_title" value="<?php echo $fetch_brand['brand_title']; ?>" size="60" required /> </td>
		</tr>		

		<tr>
		  <td></td>
		  <td colspan="7"><input type="submit" name="edit_brand" value="Update" style="padding:7px;width:300px;" /></td>
		</tr>

	  </table>
	</form>

</div> <!-- /.form_box -->
    
<?php 
  if(isset($_POST['edit_brand'])) {
		
	$brand_title = mysqli_real_escape_string($con, $_POST['brand_title']);

	$edit_brand = mysqli_query($con, "update FYP_Brands set brand_title='$brand_title' where brand_id='$_GET[brand_id]'");

	if($edit_brand) {
	  echo "<script>alert('Updated successfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo "<script>alert('Error') </script>";
	}
  }

?>