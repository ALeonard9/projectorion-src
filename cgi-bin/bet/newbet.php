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

if (isset($_SESSION['userid']))
	{
	echo "<div class='col-md-3'></div><div class='col-md-6'>
	<form class='form-signin' action='newbetupdate.php' id='myForm' method='POST'>
  <div class='form-group'>
    <label for='description'>Description</label>
    <input type='text' class='form-control' name='description' placeholder='Description'>
  </div>
  <div class='form-group'>
    <label for='amount'>Amount</label>
    <input type='number' class='form-control' name='amount' placeholder='Amount'>
  </div>
  <div class='form-group'>
    <label for='status'>Status</label>
    <select class='form-control' name='status' form='myForm'>
      <option selected='selected' value='Open'>Open</option>
      <option value='Complete'>Complete</option>
    </select>
  </div>
  <div class='form-group'>
    <label for='winner'>Winner</label>
    <select class='form-control' name='winner' form='myForm'>
      <option selected='selected' value=''>Winner</option>
      <option value='Adam'>Adam</option>
      <option value='Soumya'>Soumya</option>
    </select>
  </div>
  <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Submit</button>
	<button class='btn btn-lg btn-danger btn-block' onClick='history.go(-1);return true;'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>
	</form>
	</div>";

	}
else
	{
	header("location: ../users/signin.php");
	}
include('../footer.php');
echo "</div></body></html>";
?>
