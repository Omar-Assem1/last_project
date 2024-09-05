<?php
include('config.php');
if(isset($_POST['submit'])){
$name=mysqli_real_escape_string($con,$_POST['name']);
$email=mysqli_real_escape_string($con,$_POST['email']);
$password=mysqli_real_escape_string($con,md5($_POST['password']));
$cpassword=mysqli_real_escape_string($con,md5($_POST['cpassword']));
$image=$_FILES['image']['name'];
$image_size=$_FILES['image']['size'];
$image_tmp_name=$_FILES['image']['tmp_name'];
$image_folder='uploaded image/'.$image;
$select = mysqli_query($con,"SELECT * FROM `user_form` WHERE email='$email' AND password='$password'") or die('query failed');
if(mysqli_num_rows($select)>0){
    $message[]='user already exits';
}else{
    if ($password !=$cpassword){
        $message[]='confirm pass not matched';
    }elseif($image_size>2000000){
    $message[]='image size is too large';
    
}else{
    $insert = mysqli_query($con, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$password', '$image')") or die('query failed');
    if($insert){
        move_uploaded_file($image_tmp_name,$image_folder);
        $message[]='done';
        header('location:login.php');
    }else{
        $message[]='failed';
    }
}



}

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registry </title>
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
                
                <input type="text" name='name' placeholder="username" required class='box'><br>
                <input type="email" name='email' placeholder="email" required class='box'><br>
                <input type="password" name='password' placeholder="password" required class='box'><br>
                <input type="password" name='cpassword' placeholder="write the password again" required class='box'><br>
                <input type="file" name="image" id="" class='box' accept='image/jpg , image/png , image/jpeg'> <br>
              <input type="submit" name='submit' value="register now " class='btn'><hr>
                <p class='register'>now u have an account ? <a href="login.php">login here</a></p>
            </form>
    </div>
</body>
</html>