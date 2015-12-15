<?php

session_start();

include '../connectToDB.php';

$betID = $_POST['id'];
$betDescription = $_POST['description'];
$betAmount = $_POST['amount'];
$betStatus = $_POST['status'];
$betWinner = $_POST['winner'];

$sql = "UPDATE `bet`.`history` SET `betDescription`='".$betDescription."', `betAmount`='".$betAmount."', `betWinner`='".$betWinner."', `betStatus`='".$betStatus."' WHERE `betID`='".$betID."'";



if (isset($_SESSION['username']))
	{
		$db->exec($sql);
		#header("Location: betdetails.php?betID=$betID");
		header("Location: betting.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
