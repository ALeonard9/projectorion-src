<?php

session_start();
ob_start();

include '../connectToDB.php';

$cc = $_GET['country_code'];
$cc = strtolower($cc);
$title = $_GET['title'];
$user_id = $_SESSION['userid'];
$sql = "INSERT INTO `orion`.`countries` (`country_code`, `rank`, `completed`, `title`, `user_id`) VALUES ('$cc', '0', '1', '$title', '$user_id')";

if (isset($_SESSION['username']))
	{
		$db->exec($sql);
		header("Location: country.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
