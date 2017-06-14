<?php
session_start();
ob_start();
require '../composer/vendor/autoload.php';
include '../connectToDB.php';

if (isset($_GET['tv_id']) && $_SESSION['userid']) {
  $tvid = $_GET['tv_id'];
  $user_id = $_SESSION['userid'];
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try {
    $stmt = $db->prepare("DELETE FROM `orion`.`g_user_tv` WHERE `tv_id` = :tvid and `user_id` = :userid;DELETE FROM `orion`.`g_user_tvepisodes` WHERE `user_id` = :userid AND `tvepisode_id` in (SELECT id FROM `orion`.`tvepisodes` where `tv_id` = :tvid)");
    $stmt->bindParam(':userid', $user_id);
    $stmt->bindParam(':tvid', $tvid);
    $stmt->execute();
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
  }
}
header("location: schedule.php");
?>
