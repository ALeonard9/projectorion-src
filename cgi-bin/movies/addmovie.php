<?php

session_start();
ob_start();

include '../connectToDB.php';

$imdbID = $_GET['imdbid'];
$sql = "INSERT INTO `imdb`.`movie` (`movieIMDB`, `movieRanking`, `movieSeen`) VALUES ('$imdbID', '0', '1')";

if (isset($_SESSION['username']))
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
