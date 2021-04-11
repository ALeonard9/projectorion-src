<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();
date_default_timezone_set('Etc/UTC');

include '../connectToDB.php';

$id = $_GET['id'];
$watched = $_GET['watched'];
$user_id = $_SESSION['userid'];
$today = date('Y-m-d');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SESSION['userid']))
	{
		try {
			$stmt = $db->prepare("UPDATE `orion`.`g_user_tvepisodes` SET `watched`=:watched, `g_first`=now() WHERE `user_id`=:user AND `watched`<>:watched AND `tvepisode_id` IN (SELECT e.id FROM orion.tvepisodes e WHERE e.tv_id = :id AND e.airdate < :today)");
			$stmt->bindParam(':user', $user_id);
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':today', $today);
      		$stmt->bindParam(':watched', $watched);
			$result = $stmt->execute();
			if ( false===$result ) {
				error_log( serialize ($stmt->errorInfo()));
			}
		} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
		}
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
