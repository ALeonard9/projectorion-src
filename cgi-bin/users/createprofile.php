<?php

session_start();
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>LeoNine Studios</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if (isset($_SESSION['userid'])) {

    die("User already exists and is logged in.");
}

echo "<div class='col-md-3'></div><div class='col-md-6'>
      <form class='form-signin' action='createprofile.php' id='password_form' method='POST'>
    <div class='form-group'>
      <label for='email'>Email</label>
      <input type='email' class='form-control' name='email'>
    </div>
    <div class='form-group'>
      <label for='display_name'>Display Name</label>
      <input type='text' class='form-control' name='display_name' >
    </div>
    <div class='form-group'>
      <label for='amount'>Password</label>
      <input type='password' id='password' class='form-control' name='password'>
    </div>
    <div class='form-group'>
      <label for='status'>Confirm Password</label>
      <input type='password' class='form-control' name='password2'>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' name='update' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Create Profile</button>";

    echo "</form></br><button class='btn btn-lg btn-inverse btn-block' onclick=location.href='signin.php'><span class='glyphicon glyphicon-pencil'></span> Return to Sign in</button></div>";
    // include('../footer.php');
    echo "
    <script src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js'></script>
    <script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js'></script>
    <script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js'></script>
    <script src='../js/validation.js'></script>
    </div></body></html>";
    if (isset($_POST['email'])){
      $sql = "SELECT * FROM `orion`.`users` WHERE email = '".$email."'";
      $query = $db->query($sql);
      $row_count = $query->rowCount();
        $results = $query->fetch(PDO::FETCH_ASSOC);
      if ($row_count>0){
        die('User alreay exists.');
      }
      $name = $_POST['display_name'];
      if ($name == ''){
        $name = $_POST['email'];
      }
      $email = $_POST['email'];
      $raw = $_POST['password'];
      $password_crypt =  password_hash($raw, PASSWORD_BCRYPT);
      $sql = "INSERT INTO `orion`.`users` (`display_name`, `email`, `user_group`, `password`) VALUES ('".$name."', '".$email."', 'User', '".$password_crypt."')";
      $db->exec($sql);
      $sql = "SELECT * FROM `orion`.`users` WHERE email = '".$email."'";
      $query = $db->query($sql);
      $row_count = $query->rowCount();
        $results = $query->fetch(PDO::FETCH_ASSOC);
      if ($row_count>0){
        $_SESSION['username']=$results['display_name'];
        $_SESSION['email'] = $results['email'];
        if ($_SESSION['username']==''){
          $_SESSION['username']=$_SESSION['email'];
        }
        $_SESSION['usergroup']=$results['user_group'];
        $_SESSION['userid']=$results['id'];
          } else {
            die('Profile creation was not successful.');
          }
      header("Location: ../index.php");
      exit;
    }


?>
