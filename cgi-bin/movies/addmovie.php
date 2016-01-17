<?php

session_start();
ob_start();

include '../connectToDB.php';

$imdbID = $_GET['imdbid'];
$movieTitle = $_GET['title'];
$poster = $_GET['poster'];
if ($poster == 'N/A') {
	$poster = 'https://upload.wikimedia.org/wikipedia/en/f/f9/No-image-available.jpg';
}
$user_id = $_SESSION['userid'];
$sql = "INSERT INTO `orion`.`movies` (`imdb`, `rank`, `completed`, `title`, `user_id`, `poster_url`) VALUES ('$imdbID', '0', '1', '$movieTitle', '$user_id', '$poster')";

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
