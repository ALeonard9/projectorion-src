<?php
require '../composer/vendor/autoload.php';
include '../connectToDB.php';

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if (isset($_GET['tv_id'])) {
  $search = $_GET['tv_id'];

  $sql = "SELECT tvmaze FROM orion.tvepisodes where tv_id =".$search;
  $query = $db->query($sql);

  foreach($query as $item){
    echo "</br>". $item['tvmaze'];
    $api = "http://api.tvmaze.com/episodes/".$item['tvmaze'];
    $apiresponse =  file_get_contents($api);
    $json = json_decode($apiresponse, true);
    try {
      $stmt = $db->prepare("UPDATE `orion`.`tvepisodes` SET `title`=:name, `airdate` = :airdate, `season` = :season, `season_number` = :number WHERE `tvmaze`=:tvmaze");
      $stmt->bindParam(':name', $json['name']);
      $stmt->bindParam(':airdate', $json['airdate']);
      $stmt->bindParam(':season', $json['season']);
      $stmt->bindParam(':number', $json['number']);
      $stmt->bindParam(':tvmaze', $item['tvmaze']);
			$result = $stmt->execute();
      if ( false===$result ) {
        error_log( serialize ($stmt->errorInfo()));
      }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
  }

}
header("location: schedule.php");

?>
