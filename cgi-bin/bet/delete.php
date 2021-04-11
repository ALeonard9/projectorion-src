<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();

include '../connectToDB.php';

$betID = $_GET['betID'];

$sql = "DELETE FROM `bet`.`history` WHERE `betID`='". $betID ."';";


if (isset($_SESSION['userid']))
	{
		$db->exec($sql);
		header("Location: betting.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
