<?php

session_start();
ob_start();

include '../connectToDB.php';

$imdbID = $_GET['imdbid'];
$movieTitle = $_GET['title'];
$sql = "INSERT INTO `imdb`.`movie` (`movieIMDB`, `movieRanking`, `movieSeen`, `movieTitle`) VALUES ('$imdbID', '0', '1', '$movieTitle')";

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
