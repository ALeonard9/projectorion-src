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

echo "<div class='col-md-3'></div><div class='col-md-6'>
<form class='form-signin' action='login.php' method='POST'>
	<h2 class='form-signin-heading'>Please sign in</h2>
	<label for='inputEmail' class='sr-only'>Email address</label>
	<input name='username' type='email' id='inputEmail' class='form-control' placeholder='Email address' required autofocus>
	<label for='inputPassword' class='sr-only'>Password</label>
	<input name='password' type='password' id='inputPassword' class='form-control' placeholder='Password' required>
	<br>
	<button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-user'></span> Sign in</button>
</form></div>";

include('../footer.php');
echo "</div></body></html>";
?>
