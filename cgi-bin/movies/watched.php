<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();

include '../connectToDB.php';

$id = $_GET['id'];

if (isset($_SESSION['userid']))
	{
    try {
        $stmt = $db->prepare("UPDATE `orion`.`g_user_movies` SET `completed`='1', `g_first`=now() WHERE `g_id`= :gid");
        $stmt->bindParam(':gid', $id);
        $stmt->execute();
        $result = $stmt->execute();
        if ( false===$result ) {
            error_log( serialize ($stmt->errorInfo()));
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    header("Location: movie.php");
    exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
