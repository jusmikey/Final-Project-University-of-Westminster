<?php 

$select_user = mysqli_query($con,"select * from FYP_Users where id='$_SESSION[user_id]' ");

$fetch_user = mysqli_fetch_array($select_user);
?>
	
<div class="set_profile_image">

  <form method = "post" action="" enctype="multipart/form-data">
	
    <h2 style="color:#FFD966;">Your Account Image</h2><br />

    <b>Your Current Image:</b><br><br>

    <div>
	<img src="upload-files/<?php echo $fetch_user['image']; ?>" alt="Set Your Profile Image" width="130" height="100" />
    </div><br>

    <input type="file" name="image" /><br><br>
    <input type="submit" name="user_profile_picture" value="Upload Image" />	
	
  </form>

</div> <!--- /.set_profile_image --->

<?php 

if(isset($_POST['user_profile_picture'])){   
 
 // Check if file not empty 
 if(!empty($_FILES['image']['name'])){
 
   $image = $_FILES['image']['name'];
   $image_tmp = $_FILES['image']['tmp_name'];   
   $target_file = "upload-files/" . $image;   
   $uploadOk = 1;
   $message = '';  
   
   
   // Check if the file size more than 5 MB.
   if($_FILES["image"]["size"] < 5098888){
  
   // Check if file already exists
   if(file_exists($target_file)){
   
    $uploadOk = 0;
	$message .=" Sorry, file already exists. ";
	
   }if($uploadOk == 0){ // Check if uploadOk is set to 0 by an error
   
    $message .="Sorry, your file was not uploaded . ";
	
   }else{
    if(move_uploaded_file($image_tmp, $target_file)){
	
	$update_image = mysqli_query($con,"update FYP_Users set image='$image' where id='$_SESSION[user_id]'");
	
	$message .= "The file" . basename($image) . " has been uploaded. ";

	if($update_image) {
	  echo "<script>alert('Your image was uploaded and updated successfully.')</script>";
	  echo "<script>window.open(window.location.href,'_self')</script>";
	}

	}else{
	 $message .= "Sorry, there was an error uploading your file. ";
	}
   }
   
   }// End if the file size more than 5 MB.
   else{
    $message .= "File size max 5 MB. ";
   }
   
   }
  
}

?>