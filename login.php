<?php
include('config.php');
session_start();
if(isset($_POST['submit'])){
$email=mysqli_real_escape_string($con,$_POST['email']);
$password=mysqli_real_escape_string($con,md5($_POST['password']));
$select = mysqli_query($con,"SELECT * FROM `user_form` WHERE email='$email' AND password='$password'") or die('query failed');
if(mysqli_num_rows($select)>0){
   $row=mysqli_fetch_array($select);
   $_SESSION['user_id']=$row['id'];
   header('location:home.php');
}else{
    $message[]='failed';
}


}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="form-container">
            <form action="" method='POST' enctype='multipart/form-data'>
                <h3>register now</h3>
                <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
                <input type="email" name='email' placeholder="email" required class='box'><br>
                <input type="password" name='password' placeholder="password" required class='box'><br>
              <input type="submit" name='submit' value="login now " class='btn'><hr>
                <p class='register'>m3ndk4 ? <a href="register.php">register here</a></p>
            </form>
    </div>
</body>
</html>