<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();

include '../connectToDB.php';

$cc = $_GET['country_code'];
$cc = strtolower($cc);
$title = $_GET['title'];
$user_id = $_SESSION['userid'];

$check = "SELECT * FROM orion.countries where country_code='".$cc."';";
$stmt = $db->prepare($check);
$result = $stmt->execute();
if ( false===$result ) {
	error_log( serialize ($stmt->errorInfo()));
}
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( !$row){
	$sql = "INSERT INTO `orion`.`countries` (`country_code`, `title`) VALUES ('$cc', '$title');";
	$db->exec($sql);
	$countries_id =  $db->lastInsertId();
} else {
	$countries_id = $row['id'];
}

if (isset($_SESSION['userid']))
	{
		$sql = "INSERT INTO orion.g_user_countries (`user_id`, `countries_id`, `rank`, `completed`, `g_first`) VALUES ('$user_id', '$countries_id', '0', '1', now());";
		$db->exec($sql);
		header("Location: country.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
