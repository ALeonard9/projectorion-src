<?php

session_start();
ob_start();
date_default_timezone_set('Etc/UTC');

include '../connectToDB.php';

$date = date('Y-m-d-H', time());
$asql = "INSERT INTO `smash`.`game` (game_date) VALUES ('".$date."')";
$db->exec($asql);
$gameid =  $db->lastInsertId();

$numPlayers = $_POST['num_players'];
$x = 1;
$sql = "INSERT INTO `smash`.`gamelog` (`l_game_id`, `l_user_id`, `l_deck_id`) VALUES ";
while($x <= $numPlayers) {
		${"u$x"} = $_POST['user'.$x];
		${"deck1$x"} = $_POST['deck1'.$x];
		${"deck2$x"} = $_POST['deck2'.$x];
		$sql .= " ('".$gameid."', '".${"u$x"}."', '".${"deck1$x"}."'),";
		$sql .= " ('".$gameid."', '".${"u$x"}."', '".${"deck2$x"}."'),";
		$x++;
}
$sql = rtrim($sql, ',');

if (isset($_SESSION['userid']))
	{
		$db->exec($sql);
	  header("Location: gameDetails.php?gameID=".$gameid);
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
