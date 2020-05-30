<?php

session_start();
ob_start();

include '../connectToDB.php';

$id = $_GET['id'];
$freeze = $_GET['freeze'];
$user_id = $_SESSION['userid'];

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SESSION['userid']))
	{
		try {
			$stmt = $db->prepare("UPDATE `orion`.`g_user_tv` SET `freeze`=:freeze WHERE `g_id`=:id AND `user_id`=:user");
			$stmt->bindParam(':user', $user_id);
			$stmt->bindParam(':id', $id);
      		$stmt->bindParam(':freeze', $freeze);
			$stmt->execute();
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
