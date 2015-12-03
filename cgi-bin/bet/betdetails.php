<?php

session_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>LeoNine Studios</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

$betID = $_GET['betID'];

$sql = "SELECT * FROM bet.history where betID=" . $betID;

echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='updatewinner.php?betID=".$betID."&winner=Adam'>Adam Wins!</button></div>";
echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='updatewinner.php?betID=".$betID."&winner=Soumya'>Soumya Wins!</button></div>";
echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block'  onclick=location.href='delete.php?betID=".$betID."'>Delete Bet</button></div>";


if ($_SESSION['username'])
	{
	$query = $db->query($sql);
	foreach($query as $item){
	echo"
  <div class='col-md-3'></div><div class='col-md-6'>
	<form class='form-signin' action='updatebet.php' id='myForm' method='POST'>
	<input type='hidden' name='id' value='".$item['betID']."'>
  <div class='form-group'>
    <label for='description'>Description</label>
    <input type='text' class='form-control' name='description' value='".$item['betDescription']."'>
  </div>
  <div class='form-group'>
    <label for='amount'>Amount</label>
    <input type='number' class='form-control' name='amount' value='".$item['betAmount']."'>
  </div>
  <div class='form-group'>
    <label for='status'>Status</label>
    <select class='form-control' name='status' form='myForm'>
      <option value='Open'>Open</option>
      <option ";
      if ($item['betStatus'] == 'Complete')
            {
              echo "selected='selected' ";
            }
      echo "value='Complete'>Complete</option>
    </select>
  </div>
  <div class='form-group'>
    <label for='winner'>Winner</label>
    <select class='form-control' name='winner' form='myForm'>
      <option value=''>Winner</option>
      <option ";
      if ($item['betWinner'] == 'Adam')
            {
              echo "selected='selected' ";
            }
      echo "value='Adam'>Adam</option>
      <option ";
      if ($item['betWinner'] == 'Soumya')
            {
              echo "selected='selected' ";
            }
      echo "value='Soumya'>Soumya</option>
    </select>
  </div>
  <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Edit</button>
  <button class='btn btn-lg btn-danger btn-block' onClick='history.go(-1);return true;'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>
  </form>
  </div>";

	}

	}
else
	{
	die("You must login");
	}

include('../footer.php');
echo "</div></body></html>";
?>
