<?php

session_start();
ob_start();

include '../connectToDB.php';

$id = $_GET['id'];

if (isset($_SESSION['userid']))
	{
    $stmt = $db->prepare("UPDATE `orion`.`g_user_videogames` SET `completed`='1' WHERE `g_id`= :gid");
    $stmt->bindParam(':gid', $id);
    $stmt->execute();
    header("Location: videogame.php");
    exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
