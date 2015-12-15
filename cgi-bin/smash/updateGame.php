<?php

session_start();
ob_start();

include '../connectToDB.php';

$gameID = $_POST['gameid'];
$gameNotes = $_POST['notes'];
$gameWinner = $_POST['winner'];

if (isset($_SESSION['username']))
	{
		if (isset($_POST['update'])) {
			$sql = "UPDATE `smash`.`game` SET `game_id`='".$gameID."', `winner_user`='".$gameWinner."', `game_notes`='".$gameNotes."' WHERE `game_id`='".$gameID."'";
	  } 	else if (isset($_POST['delete'])) {
			$sql = "DELETE FROM `smash`.`game` WHERE `game_id`='". $gameID ."'; DELETE FROM smash.gamelog WHERE l_game_id = '".$gameID."'";
		} else {
    	die("Error button not pushed.");
		}
		$db->exec($sql);
		header("Location: gameRecords.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
