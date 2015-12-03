<?php

session_start();

include '../connectToDB.php';

$betDescription = $_POST['description'];
$betAmount = $_POST['amount'];
$betStatus = $_POST['status'];
$betWinner = $_POST['winner'];

$sql = "INSERT INTO `bet`.`history` (`betDescription`, `betAmount`, `betWinner`, `betStatus`) VALUES ('".$betDescription."', '".$betAmount."', '".$betWinner."', '".$betStatus."')";



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