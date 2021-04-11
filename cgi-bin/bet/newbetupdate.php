<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();

include '../connectToDB.php';

$betDescription = $_POST['description'];
$betAmount = $_POST['amount'];
$betStatus = $_POST['status'];
$betWinner = $_POST['winner'];

if (isset($_GET['ruleid']))
        {
$ruleID = $_GET['ruleid'];
$rulesql = "SELECT * FROM bet.rules WHERE ruleID = $ruleID";
$rulequery = $db->query($rulesql);
$result = $rulequery->fetch(PDO::FETCH_ASSOC);
$betDescription = $result['ruleDescription'];
$betAmount = $_GET['amount'];
$betStatus = "Complete";
$betWinner = $_GET['winner'];
				}

$sql = "INSERT INTO `bet`.`history` (`betDescription`, `betAmount`, `betWinner`, `betStatus`) VALUES ('".$betDescription."', '".$betAmount."', '".$betWinner."', '".$betStatus."')";



if (isset($_SESSION['userid']))
	{
		$db->exec($sql);
		header("Location: betting.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
