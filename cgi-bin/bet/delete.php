<?php

session_start();

include '../connectToDB.php';

$betID = $_GET['betID'];

$sql = "DELETE FROM `bet`.`history` WHERE `betID`='". $betID ."';";


if ($_SESSION['username'])
	{
		$db->exec($sql);
		header("Location: betting.php");
		exit;
	}
else
	{
	die("You must login");
	}
?>
