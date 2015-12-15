<?php

session_start();

include '../connectToDB.php';

$gameID = $_GET['gameID'];

$sql = "DELETE FROM `smash`.`game` WHERE `game_id`='". $gameID ."'";
echo $sql;

if (isset($_SESSION['username']))
	{
		$db->exec($sql);
		// header("Location: gameRecords.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
