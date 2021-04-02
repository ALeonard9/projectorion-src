<?php
session_start();
ob_start();
date_default_timezone_set('Etc/UTC');

include '../connectToDB.php';

$user_id = $_SESSION['userid'];
$tv_id = $_GET['tv_id'];
$season = $_GET['season'];
$watched = $_GET['watched'];

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SESSION['userid']))
	{
		try {
			$stmt = $db->prepare("UPDATE `orion`.`g_user_tvepisodes` SET `watched`=:watched, `g_first`=now()  WHERE `user_id`=:user AND  `watched`<>:watched AND `tvepisode_id` IN (SELECT `id` FROM `orion`.`tvepisodes` WHERE `tv_id`=:tv_id AND `season`=:season)");
			$stmt->bindParam(':user', $user_id);
			$stmt->bindParam(':tv_id', $tv_id);
      		$stmt->bindParam(':watched', $watched);
			$stmt->bindParam(':season', $season);
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
