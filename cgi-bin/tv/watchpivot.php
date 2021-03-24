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
			$stmt = $db->prepare("UPDATE `orion`.`g_user_tvepisodes` SET `watched`=:watched, `g_first`=now() WHERE `g_id`=:id AND `user_id`=:user");
			$stmt->bindParam(':user', $user_id);
			$stmt->bindParam(':id', $id);
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
