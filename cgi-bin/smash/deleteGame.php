<?php

session_start();

include '../connectToDB.php';

$gameID = $_GET['gameID'];

$sql = "DELETE FROM `smash`.`game` WHERE `game_id`='". $gameID ."'";
echo $sql;

if ($_SESSION['username'])
	{
		$db->exec($sql);
		// header("Location: gameRecords.php");
		exit;
	}
else
	{
	die("You must login");
	}
?>
