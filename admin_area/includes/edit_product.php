<?php 
  $edit_product = mysqli_query($con, "select * from FYP_Products where product_id='$_GET[product_id]' ");
  $fetch_edit = mysqli_fetch_array($edit_product);
  
?>

<div class="form_box">

	<form action="" method="post" enctype="multipart/form-data">
	  <table width="100%"> 
		<tr>
		  <td colspan="7">
		    <h2> Edit Product </h2>
		    <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td> 
		</tr>

		<tr>
		  <td colspan="7">
		    <p><b>Current Status: </b><?php echo $fetch_edit['status']; ?></p><br>
		    <p><b> Change Status:  </b></p><br>
		    <form action="" method="post"><input style="cursor:pointer; color:white; background:red; border:none;" type="submit" value="Pending" name="pending"/></form><br><br>
		    <form action="" method="post"><input style="cursor:pointer; color:white; background:lightgreen; border:none;" type="submit" value="Approve" name="approved"/></form>

		    <?php
			if(isset($_POST['pending'])) {
			  if($fetch_edit['status'] == 'Pending') {
			    echo "<script>alert('Product is already set as pending.');</script>";
			  } else {
			    $update_status = mysqli_query($con, "update FYP_Products set status='Pending' where product_id='$_GET[product_id] '");

			    if($update_status) {
				echo "<script>alert('Product has been set as pending.');</script>";
				echo "<script>window.open(window.location.href,'_self')</script>";
			    } else {
				echo "<script>alert('Product failed to change status as pending. Try again.');</script>";
				//echo mysqli_error($con);
			    }
			  }

			} elseif(isset($_POST['approved'])) {
			  if($fetch_edit['status'] == 'Approved') {
			    echo "<script>alert('Product is already set as approved.');</script>";
			  } else {
			    $update_status = mysqli_query($con, "update FYP_Products set status='Approved' where product_id='$_GET[product_id] '");

			    if($update_status) {
				echo "<script>alert('Product has been approved.');</script>";
				echo "<script>window.open(window.location.href,'_self')</script>";
			    } else {
				echo "<script>alert('Product failed to change status as approved. Try again.');</script>";
				//echo mysqli_error($con);
			    }
			  }

			}
		    ?>

		    <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td> 
		</tr>

		<tr> 
		  <td><b> Product Title: </b></td>
		  <td><input type="text" name="product_title" value="<?php echo $fetch_edit['product_title']; ?>" required /> </td>
		</tr>

		<tr>
		  <td><b> Product Category: </b></td>
		  <td>
			<select name="product_cat">
				<option> Select Category: </option>

				<?php
				  $get_cats ="select * from FYP_Categories";
    				  $run_cats = mysqli_query($con, $get_cats);
		
    				  while($row_cats=mysqli_fetch_array($run_cats)) {
      					$cat_id = $row_cats['cat_id'];
      					$cat_title = $row_cats['cat_title'];

					if($fetch_edit['product_category'] == $cat_id) {
					  echo "<option value='$fetch_edit[product_cat]' selected> $cat_title </option>";
					} else {
					  echo "<option value='$cat_id'> $cat_title </option>";
					}	
    				  }
				?>
			</select>
		  </td>
		</tr>

		<tr>
		  <td><b> Product Brand: </b></td>
		  <td>
			<select name="product_brand">
				<option> Select Brand: </option>

				<?php
				  $get_brands ="select * from FYP_Brands";
    				  $run_brands = mysqli_query($con, $get_brands);
		
    				  while($row_brands=mysqli_fetch_array($run_brands)) {
      					$brand_id = $row_brands['brand_id'];
      					$brand_title = $row_brands['brand_title'];

					if($fetch_edit['product_brand'] == $brand_id) {
					  echo "<option value='$fetch_edit[product_brand]' selected> $brand_title </option>";
					} else {
  					  echo "<option value='$brand_id'> $brand_title </option>";
					}    				  	
    				  }
				?>
			</select>
		  </td>
		</tr>

		<tr>
		  <td><b> Product Country Location: </b></td>
		  <td>
		    <input type="text" name="product_country" value="<?php echo $fetch_edit['product_country']; ?>" required /> 		    
		  </td>

		  </tr>

		<tr>
		  <td><b> Product City / Town Location: </b></td>
		  <td>
		    <input type="text" name="product_city" value="<?php echo $fetch_edit['product_city']; ?>" required />
		  </td>
		</tr>

		</tr>

		<tr>
		  <td><b> Product Dietary Range: </b></td>
		  <td>
		    <input type="text" name="product_diet" value="<?php echo $fetch_edit['product_diet']; ?>" required />
			<?php /*
				$get_diet ="select * from FYP_DietaryRange";
    				$run_diet = mysqli_query($con, $get_diet);
		
    				while($row_diet=mysqli_fetch_array($run_diet)) {
      					$diet_id = $row_diet['diet_id'];
      					$diet_title = $row_diet['diet_title'];
				*/
				/*
      					echo "<input type='checkbox' id='$diet_id' name='diet[]' value='$diet_title' />";
					echo "<label for='$diet_id'> $diet_title</label>";
    				}*/
			?>
		    <!--<div class="border_bottom"> </div> /.border_bottom -->
		  </td>
		</tr>

		<tr>
		  <td valign="top"><b> Product Image: </b></td>
		  <td><input type="file" name="product_image" />
		    <div class="edit_image">
			<img src="product_images/<?php echo $fetch_edit['product_image']; ?>" width="100" />
		    </div>
		    <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td>
		</tr>

		<tr>
		  <td><b> Product Price: </b></td>
		  <td><input type="number" name="product_price" value="<?php echo number_format($fetch_edit['product_price'],2); ?>" step="0.01" required /></td>
		</tr>

		<tr>
		  <td valign="top"><b> Product Description: </b></td>
		  <td><textarea id="edit_content" name="product_desc" rows="7"><?php echo $fetch_edit['product_desc']; ?></textarea>
		</tr>

		<tr>
		  <td valign="top"><b> Other Product Information: </b></td>
		  <td><textarea name="other_product_details" rows="7"><?php echo $fetch_edit['other_product_details']; ?></textarea></td>
		</tr>

		<tr>
		  <td><b> Product Keywords: </b></td>
		  <td><input type="text" name="product_keywords" value="<?php echo $fetch_edit['product_keywords']; ?>" required /></td>
		</tr>

		<tr>
		  <td></td>
		  <td colspan="7"><input type="submit" name="edit_product" value="Update" style="padding:7px;width:300px;" /></td>
		</tr>

	  </table>
	</form>

</div> <!-- /.form_box -->

  <div class="border_bottom"></div><br>
<h3 style='float:right; margin-right:30px;'><i class="fa fa-arrow-left"></i><a href="index.php?action=view_pro" style="color:black; text-decoration:none;"> Go back to all products<a/></h3><br><br>

    
<?php 

  if(isset($_POST['edit_product'])) {

	$product_title = trim(mysqli_real_escape_string($con,$_POST['product_title']));
	$product_cat = $_POST['product_cat'];
	$product_brand = $_POST['product_brand'];
	$product_country = trim(mysqli_real_escape_string($con,$_POST['product_country']));
	$product_city = trim(mysqli_real_escape_string($con,$_POST['product_city']));
	$product_diet = trim(mysqli_real_escape_string($con,$_POST['product_diet']));

	//Image from the file inpute
	$product_image = $_FILES['product_image']['name'];
	$product_image_tmp = $_FILES['product_image']['tmp_name'];

	$product_price = $_POST['product_price'];
	$product_desc = trim(mysqli_real_escape_string($con, $_POST['product_desc']));
	$other_product_info = $_POST['other_product_details'];
	$product_keywords = $_POST['product_keywords'];

	if(!empty($_FILES['product_image']['name'])) {
	  if(move_uploaded_file($product_image_tmp, "product_images/$product_image")) {
	    $update_product = mysqli_query($con,"update FYP_Products set product_title='$product_title', product_category='$product_cat', product_brand='$product_brand', product_country='$product_country', product_city='$product_city', product_diet='$product_diet',
	    product_image='$product_image', product_price='$product_price', product_desc='$product_desc', other_product_details='$other_product_info', product_keywords='$product_keywords' where product_id='$_GET[product_id]'");
	  }
	} else {
	    $update_product = mysqli_query($con,"update FYP_Products set product_title='$product_title', product_category='$product_cat', product_brand='$product_brand', product_country='$product_country', product_city='$product_city', product_diet='$product_diet',
	    product_price='$product_price', product_desc='$product_desc', other_product_details='$other_product_info', product_keywords='$product_keywords' where product_id='$_GET[product_id]'");
	}

	if($update_product) {
	  echo "<script>alert('Product was updated successfully!')</script>";
	  echo "<script>window.open(window.location.href,'_self')</script>";
	}
	

}

?>

<script type="text/javascript" src="tinymce_custom/tinymce.min.js"></script>

<script>
tinymce.init({
  selector: 'textarea#edit_content',
  auto_focus: 'edit_content',
  height: false,
  menubar: false,
  branding: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code help wordcount'
  ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code codesample",
   image_advtab: true ,
 
  setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
    
});
</script>




