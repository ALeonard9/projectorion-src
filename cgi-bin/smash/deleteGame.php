<?php

session_start();
ob_start();

include '../connectToDB.php';

$gameID = $_GET['gameID'];

$sql = "DELETE FROM `smash`.`game` WHERE `game_id`='". $gameID ."'; DELETE FROM `smash`.`gamelog` WHERE `l_game_id`='". $gameID ."';";

if (isset($_SESSION['userid']))
	{
		$db->exec($sql);
		header("Location: gameRecords.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
