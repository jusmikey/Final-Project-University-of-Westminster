  <h2> Edit Product </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

<?php
  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  $select_id = mysqli_query($con, "select * from FYP_Brands where brand_title='$fetch_brand[brand_title]'");
  $fetch_id = mysqli_fetch_array($select_id);

  $select_pro = mysqli_query($con, "select * from FYP_Products where product_brand='$fetch_id[brand_id]' and product_id='$_GET[product_id]'");
  $fetch_pro = mysqli_fetch_array($select_pro);

  if($fetch_brand['status'] == 'Pending') {

?>

  <p>Currently you have not been approved by the service, please be patient.</p>
  <p>Come back another time, and you will be able to insert your products.</p>

<?php } else { ?>

<div class="form_box">

  <form action="" method="post" enctype="multipart/form-data">
    <table width="100%"> 

	<tr> 
	  <td><b> Product Title: </b></td>
	  <td><input type="text" name="product_title" value="<?php echo $fetch_pro['product_title']; ?>" required /> </td>
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

					if($fetch_pro['product_category'] == $cat_id) {
					  echo "<option value='$fetch_pro[product_cat]' selected> $cat_title </option>";
					} else {
					  echo "<option value='$cat_id'> $cat_title </option>";
					}	
    				  }
				?>
			</select>
		  </td>
		</tr>

		<tr>
		  <td><b> Product Country Location: </b></td>
		  <td>
		    <input type="text" name="product_country" value="<?php echo $fetch_pro['product_country']; ?>" required /> 		    
		  </td>

		  </tr>

		<tr>
		  <td><b> Product City / Town Location: </b></td>
		  <td>
		    <input type="text" name="product_city" value="<?php echo $fetch_pro['product_city']; ?>" required />
		  </td>
		</tr>

		</tr>

		<tr>
		  <td><b> Product Dietary Range: </b></td>
		  <td>
		    <input type="text" name="product_diet" value="<?php echo $fetch_pro['product_diet']; ?>" required />
		  </td>
		</tr>

		<tr>
		  <td valign="top"><b> Product Image: </b></td>
		  <td><input type="file" name="product_image" />
		    <div class="edit_image">
			<img src="../admin_area/product_images/<?php echo $fetch_pro['product_image']; ?>" width="100" />
		    </div>
		    <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td>
		</tr>

		<tr>
		  <td><b> Product Price: </b></td>
		  <td><input type="number" name="product_price" value="<?php echo number_format($fetch_pro['product_price'],2); ?>" step="0.01" /></td>
		</tr>

		<tr>
		  <td valign="top"><b> Product Description: </b></td>
		  <td><textarea id="edit_content" name="product_desc" rows="7"><?php echo $fetch_pro['product_desc']; ?></textarea>
		</tr>

		<tr>
		  <td valign="top"><b> Other Product Information: </b></td>
		  <td><textarea name="other_product_details" rows="7"><?php echo $fetch_pro['other_product_details']; ?></textarea></td>
		</tr>

		<tr>
		  <td><b> Product Keywords: </b></td>
		  <td><input type="text" name="product_keywords" value="<?php echo $fetch_pro['product_keywords']; ?>" required /></td>
		</tr>

		<tr>
		  <td></td>
		  <td colspan="7"><input type="submit" name="edit_product" value="Update" style="padding:7px;width:300px;" /></td>
		</tr>

	  </table>
	</form>

</div> <!-- /.form_box -->
    
<?php 

  if(isset($_POST['edit_product'])) {

	$product_title = trim(mysqli_real_escape_string($con,$_POST['product_title']));
	$product_cat = $_POST['product_cat'];
	$product_country = trim(mysqli_real_escape_string($con,$_POST['product_country']));
	$product_city = trim(mysqli_real_escape_string($con,$_POST['product_city']));
	$product_diet = trim(mysqli_real_escape_string($con,$_POST['product_diet']));

	//Image from the file inpute
	$product_image = $_FILES['product_image']['name'];
	$product_image_tmp = $_FILES['product_image']['tmp_name'];

	$product_price = $_POST['product_price'];
	$product_desc = trim(mysqli_real_escape_string($con, $_POST['product_desc']));
	$other_product_info = trim(mysqli_real_escape_string($con, $_POST['other_product_details']));
	$product_keywords = trim(mysqli_real_escape_string($con, $_POST['product_keywords']));

	if(!empty($_FILES['product_image']['name'])) {
	  if(move_uploaded_file($product_image_tmp, "../admin_area/product_images/$product_image")) {
	    $update_product = mysqli_query($con,"update FYP_Products set product_title='$product_title', product_category='$product_cat', product_country='$product_country', product_city='$product_city', product_diet='$product_diet',
	    product_image='$product_image', product_price='$product_price', product_desc='$product_desc', other_product_details='$other_product_info', product_keywords='$product_keywords' where product_id='$_GET[product_id]'");
	  }
	} else {
	    $update_product = mysqli_query($con,"update FYP_Products set product_title='$product_title', product_category='$product_cat', product_country='$product_country', product_city='$product_city', product_diet='$product_diet',
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
  selector: 'textarea#other_product_details',
  auto_focus: 'other_product_details',
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

<?php } // End if pending status ?>
