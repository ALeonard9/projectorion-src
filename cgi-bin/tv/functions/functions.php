<?php
require '../composer/vendor/autoload.php';
date_default_timezone_set('Etc/UTC');

function updateEpisode($tvmaze_id)
  {
    include '../connectToDB.php';

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $api = "http://api.tvmaze.com/episodes/".$tvmaze_id;
    $apiresponse =  file_get_contents($api);
    $json = json_decode($apiresponse, true);
    try {
      $stmt = $db->prepare("UPDATE `orion`.`tvepisodes` SET `title`= :name, `airdate` = :airdate, `season` = :season, `season_number` = :number WHERE `tvmaze`= :tvmaze");
      $stmt->bindParam(':name', $json['name']);
      $stmt->bindParam(':airdate', $json['airdate']);
      $stmt->bindParam(':season', $json['season']);
      $stmt->bindParam(':number', $json['number']);
      $stmt->bindParam(':tvmaze', $tvmaze_id);
      $result = $stmt->execute();
      if ( false===$result ) {
        error_log( serialize ($stmt->errorInfo()));
    }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    return;
  }

?>