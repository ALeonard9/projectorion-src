<?php

session_start();
ob_start();

include '../connectToDB.php';

$id = $_GET['id'];
$title = urldecode($_GET['title']);
$poster = $_GET['poster'];
if ($poster == 'N/A') {
	$poster = 'https://upload.wikimedia.org/wikipedia/en/f/f9/No-image-available.jpg';
}
$user_id = $_SESSION['userid'];
$check = "SELECT * FROM orion.videogames where igdb='".$id."';";
$stmt = $db->prepare($check);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( !$row){
	$stmt = $db->prepare("INSERT INTO `orion`.`videogames` (`igdb`, `title`, `poster_url`) VALUES (:id, :title, :poster)");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':title', $title);
	$stmt->bindParam(':poster', $poster);
	$stmt->execute();
	$row_id =  $db->lastInsertId();
} else {
	$row_id = $row['id'];
}

if (isset($_SESSION['userid']))
	{

		$stmt = $db->prepare("INSERT INTO orion.g_user_videogames (`user_id`, `videogames_id`, `rank`, `completed`) VALUES (:user, :row, '0', '1')");
		$stmt->bindParam(':user', $user_id);
		$stmt->bindParam(':row', $row_id);
    $stmt->execute();
  	header("Location: videogame.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
