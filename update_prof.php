<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];if(isset($_POST['update_profile'])){

    $update_name = mysqli_real_escape_string($con, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($con, $_POST['update_email']);
 
    mysqli_query($con, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');
 
    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($con, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($con, md5($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($con, md5($_POST['confirm_pass']));
 
    if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
       if($update_pass != $old_pass){
          $message[] = 'old password not matched! ya 7ramy el accountat ya trash';
       }elseif($new_pass != $confirm_pass){
          $message[] = 'confirm password not matched! copy paste m4 m7taga';
       }else{
          mysqli_query($con, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
          $message[] = 'done(pass)';
       }
    }
 
    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_img/'.$update_image;
 
    if(!empty($update_image)){
       if($update_image_size > 2000000){
          $message[] = 'image is too large|kbeera 7bteen';
       }else{
          $image_update_query = mysqli_query($con, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
          if($image_update_query){
             move_uploaded_file($update_image_tmp_name, $update_image_folder);
          }
          $message[] = 'done(image)';
       }
    }
 
 }
 
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update ur profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="update-profile">

    <?php
   $select = mysqli_query($con, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($select) > 0){
      $fetch = mysqli_fetch_assoc($select);
            }
    ?>
<div class="profile">
<form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>username ya gamd</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
            <span>email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            <span>update picture :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>cpassword :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="home.php" class="delete-btn">home</a>
   </form>
      </div>
</body>
</html>