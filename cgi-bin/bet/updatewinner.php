<?php

session_start();

include '../connectToDB.php';

$winner = $_GET['winner'];
$betID = $_GET['betID'];

$sql = "UPDATE `bet`.`history` SET `betWinner`='". $winner ."', `betStatus`='Complete' WHERE `betID`='". $betID ."'";


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