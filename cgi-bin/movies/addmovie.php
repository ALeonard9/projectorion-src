<?php

session_start();
ob_start();

include '../connectToDB.php';

$imdbID = $_GET['imdbid'];
$movieTitle = $_GET['title'];
$user_id = $_SESSION['userid'];
$sql = "INSERT INTO `orion`.`movies` (`imdb`, `rank`, `completed`, `title`, `user_id`) VALUES ('$imdbID', '0', '1', '$movieTitle', '$user_id')";

if (isset($_SESSION['userid']))
	{
		$db->exec($sql);
		header("Location: movie.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
