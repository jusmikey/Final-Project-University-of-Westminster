
  <h2> Add Product </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->
  <div class="form_box">
<?php
  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  $select_id = mysqli_query($con, "select * from FYP_Brands where brand_title='$fetch_brand[brand_title]'");
  $fetch_id = mysqli_fetch_array($select_id);

  if($fetch_brand['status'] == 'Pending') {

?>

  <p>Currently you have not been approved by the service, please be patient.</p>
  <p>Come back another time, and you will be able to insert your products.</p>

<?php } else { ?>

	<form action="" method="post" enctype="multipart/form-data">

	  <table align="center" width="100%"> 
	    <tr>
	    	<td colspan="7">
		</td> 
	    </tr>

	    <tr> 
		 <td><b> Product Title: </b></td>
		 <td><input type="text" name="product_title" required /> </td>
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

      					echo "<option value='$cat_id'> $cat_title </option>";	
    				  }
				?>
			</select>
		  </td>
		</tr>

		<tr>
		  <td><b> Product Country Location: </b></td>
		  <td>
			<input type="checkbox" name="country[]" value="England" id="england" />
			<label for="england"> England</label><br>
			<input type="checkbox" name="country[]" value="Scotland" id="scotland" />
			<label for="scotland"> Scotland</label><br>
			<input type="checkbox" name="country[]" value="Wales" id="wales" />
			<label for="wales"> Wales</label><br>
			<input type="checkbox" name="country[]" value="Northern_Ireland" id="n_ireland" />
			<label for="n_ireland"> Northern Ireland</label><br>
		    <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td>

		  </tr>

		<tr>
		  <td><b> Product City / Town Location: </b></td>
		  <td>
		  	<input type="checkbox" name="city[]" value="London" id="london" />
			<label for="london"> London</label><br>
			<input type="checkbox" name="city[]" value="Windsor" id="Windsor" />
			<label for="windsor"> Windsor</label><br>
			<input type="checkbox" name="city[]" value="Guildford" id="guildford" />
			<label for="guildford"> Guildford</label><br>
			<input type="checkbox" name="city[]" value="High Wycombe" id="high_wycombe" />
			<label for="high_wycombe"> High Wycombe</label><br>
		    <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td>
		</tr>

		</tr>

		<tr>
		  <td><b> Product Dietary Range: </b></td>
		  <td>
			<?php
				$get_diet ="select * from FYP_DietaryRange";
    				$run_diet = mysqli_query($con, $get_diet);
		
    				while($row_diet=mysqli_fetch_array($run_diet)) {
      					$diet_id = $row_diet['diet_id'];
      					$diet_title = $row_diet['diet_title'];

      					echo "<input type='checkbox' id='$diet_id' name='diet[]' value='$diet_title' />";
					echo "<label for='$diet_id'> $diet_title</label>";
    				}
			?>
		    <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td>
		</tr>

		<tr>
		  <td><b> Product Image: </b></td>
		  <td><input type="file" name="product_image" />
		    <div class="border_bottom"> </div><!-- /.border_bottom -->
		  </td>
		</tr>

		<tr>
		  <td><b> Product Price: </b></td>
		  <td><input type="number" name="product_price" step="0.01" required /></td>
		</tr>

		<tr>
		  <td valign="top"><b> Product Description: </b></td>
		  <td><textarea id="add_content" name="product_desc" rows="7" required></textarea>
		</tr>

		<tr>
		  <td valign="top"><b> Other Product Information: </b></td>
		  <td><textarea name="other_product_details" rows="7" required></textarea></td>
		</tr>

		<tr>
		  <td><b> Product Keywords: </b></td>
		  <td><input type="text" name="product_keywords" required /></td>
		</tr>

		<tr>
		  <td></td>
		  <td  colspan="7"><input class="submit_btn" type="submit" name="insert_pro" value="Add Product" style="padding:7px;width:300px;" /></td>
		</tr>

	  </table>
	</form>

</div> <!-- /.form_box -->
    
<?php 

  if(isset($_POST['insert_pro'])) {
	
	if(isset($_FILES['product_image']['name']) == null) {
	  echo "<script>alert('Product Image Failed to insert') </script>";
	} elseif($_FILES["product_image"]["size"] > 5098888){
	  echo "<script>alert('Product Image Too large! Max file size is 5MB.') </script>";
	} elseif(isset($_POST['product_cat']) == '') {
	  echo "<script>alert('Error with Category.') </script>";
	} elseif(isset($_POST['country']) == '') {
	  echo "<script>alert('Error with inserting country.') </script>";
	} elseif(isset($_POST['city']) == '') {
	  echo "<script>alert('Error with inserting city.') </script>";
	} elseif(isset($_POST['diet']) == '') {
	  echo "<script>alert('Error with inserting diet.') </script>";
        } else {

	/* Form Values */
	$product_title = trim(mysqli_real_escape_string($con, $_POST['product_title']));
	$product_cat = $_POST['product_cat'];
	$product_brand = $fetch_id['brand_id'];

	//Dietary Range
	$get_diet = $_POST['diet'];
	$product_diet = implode(", ", $get_diet);

	$product_price = $_POST['product_price'];
	$product_desc = trim(mysqli_real_escape_string($con, $_POST['product_desc']));
	$other_product_info = trim(mysqli_real_escape_string($con, $_POST['other_product_details']));
	$product_keywords = trim(mysqli_real_escape_string($con, $_POST['product_keywords']));

	//Image from the file inpute
	$product_image = $_FILES['product_image']['name'];
	$product_image_tmp = $_FILES['product_image']['tmp_name'];

	move_uploaded_file($product_image_tmp, "../admin_area/product_images/$product_image");

	//Location checkboxes
	$get_country = $_POST['country'];
	$product_country = implode(", ", $get_country);
	
	$get_city = $_POST['city'];
	$product_city = implode(", ", $get_city);

	  $insert_product = " insert into FYP_Products (product_title, product_category, product_brand, product_country, product_city, product_diet, product_image, product_price, product_desc, other_product_details, product_keywords, status) 
		values ('$product_title','$product_cat','$product_brand','$product_country','$product_city','$product_diet','$product_image','$product_price','$product_desc','$other_product_info','$product_keywords', 'Pending') ";

	  $insert_pro = mysqli_query($con, $insert_product);

	  if($insert_pro) {
	  
		echo "<script>alert('$product_title has been created succesfully!') </script>" ;
		//echo "<script>window.open('insert_product.php','_self') </script>";
	} else {
	  //echo "<script>alert('Error with inserting image.') </script>";
	echo mysqli_error($con);
    }}
  }

?>

  <script type="text/javascript" src="tinymce_custom/tinymce.min.js"></script>

  <script>
    tinymce.init({
  	selector: 'textarea#add_content',
  	auto_focus: 'add_content',
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

<?php } // end status if statement ?>