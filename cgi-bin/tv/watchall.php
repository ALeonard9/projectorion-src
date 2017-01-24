<?php

session_start();
ob_start();

include '../connectToDB.php';

$id = $_GET['id'];
$watched = $_GET['watched'];
$user_id = $_SESSION['userid'];

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SESSION['userid']))
	{
		try {
			$stmt = $db->prepare("UPDATE `orion`.`g_user_tvepisodes` SET `watched`=:watched WHERE `user_id`=:user AND `tvepisode_id` IN (SELECT e.id FROM orion.tvepisodes e WHERE e.tv_id = :id)");
			$stmt->bindParam(':user', $user_id);
			$stmt->bindParam(':id', $id);
      $stmt->bindParam(':watched', $watched);
			$stmt->execute();
		} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
		}
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
