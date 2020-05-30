<?php
require '../composer/vendor/autoload.php';
include '../connectToDB.php';

if (isset($_GET['ep_id'])) {
  $search = $_GET['ep_id'];
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $api = "http://api.tvmaze.com/episodes/".$search;
  $apiresponse =  file_get_contents($api);
  $json = json_decode($apiresponse, true);
  try {
    $stmt = $db->prepare("UPDATE `orion`.`tvepisodes` SET `title`= :name, `airdate` = :airdate, `season` = :season, `season_number` = :number WHERE `tvmaze`= :tvmaze");
    $stmt->bindParam(':name', $json['name']);
    $stmt->bindParam(':airdate', $json['airdate']);
    $stmt->bindParam(':season', $json['season']);
    $stmt->bindParam(':number', $json['number']);
    $stmt->bindParam(':tvmaze', $search);
    $stmt->execute();
    if ( false===$result ) {
      error_log( serialize ($stmt->errorInfo()));
  }
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
  }
}
header("location: schedule.php");
?>
