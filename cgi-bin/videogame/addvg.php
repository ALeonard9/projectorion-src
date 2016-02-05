<?php

session_start();
ob_start();

include '../connectToDB.php';

$id = $_GET['id'];
$title = $_GET['title'];
$poster = $_GET['poster'];
if ($poster == 'N/A') {
	$poster = 'https://upload.wikimedia.org/wikipedia/en/f/f9/No-image-available.jpg';
}
$user_id = $_SESSION['userid'];
$check = "SELECT * FROM orion.videogames where 'igdb'='".$id."';";
$stmt = $db->prepare($check);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( !$row){
	$sql = "INSERT INTO `orion`.`videogames` (`igdb`, `title`, `poster_url`) VALUES ('$id', '$title', '$poster');";
	$db->exec($sql);
	$row_id =  $db->lastInsertId();
} else {
	$row_id = $row['id'];
}

if (isset($_SESSION['userid']))
	{
		$sql = "INSERT INTO orion.g_user_videogames (`user_id`, `videogames_id`, `rank`, `completed`) VALUES ('$user_id', '$row_id', '0', '1');";
		$db->exec($sql);
		header("Location: videogame.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
