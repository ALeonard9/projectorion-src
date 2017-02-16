<?php

session_start();
ob_start();
include '../connectToDB.php';
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['userid']))
	{

$user_id = $_SESSION['userid'];
echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam Leonard</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

echo "<div class='col-md-3'></div><div class='col-md-6'>
<form class='form-signin' action='changepassword.php' id='password_form' method='POST' novalidate='novalidate'>
<div class='form-group'>
  <label for='amount'>Password</label>
  <input type='password' id='password' class='form-control' name='password'>
</div>
<div class='form-group'>
  <label for='status'>Confirm Password</label>
  <input type='password' class='form-control' name='password2'>
</div>
<button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Change Password</button>
<button class='btn btn-lg btn-danger btn-block' onClick='history.go(-1);return true;'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>
</form>
</div>";

if (isset($_POST['password'])){
  $raw = $_POST['password'];
  $password_crypt =  password_hash($raw, PASSWORD_BCRYPT);
  $sql = "UPDATE `orion`.`users` SET `password`=\"".$password_crypt."\" WHERE `id`='".$user_id."'";
  $db->exec($sql);
  header("Location: profile.php");
  exit;
}

echo "
<script src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js'></script>
<script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js'></script>
<script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js'></script>
<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.ui.touch-punch/0.2.3/jquery.ui.touch-punch.min.js'></script>
<script src='../js/validation.js'></script>
</div></body></html>";
// include('../footer.php');


	}
else
	{
	header("location: ../users/signin.php");
	}

 ?>
