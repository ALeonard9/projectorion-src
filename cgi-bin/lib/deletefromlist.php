<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();

include '../connectToDB.php';

$id = $_GET['id'];
$table = $_GET['table'];
$user_id = $_SESSION['userid'];

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SESSION['userid']))
	{
		try {
			$stmt = ("DELETE FROM $table WHERE `g_id`=:id AND `user_id`=:user");
			$stmt->bindParam(':user', $user_id);
			$stmt->bindParam(':id', $id);
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
