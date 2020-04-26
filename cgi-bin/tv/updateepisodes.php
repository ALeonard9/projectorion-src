<?php

require '../composer/vendor/autoload.php';
include '../connectToDB.php';
date_default_timezone_set('Etc/UTC');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM orion.tv WHERE status = 'Running'";
$query = $db->query($sql);
$today = date('Y-m-d');
$week =  date('Y-m-d', strtotime('+7 days'));

foreach($query as $item){
	$api = "http://api.tvmaze.com/shows/".$item['tvmaze']."/episodes";
	$apiresponse =  file_get_contents($api);
	$json = json_decode($apiresponse, true);
	foreach($json as $jsonitem){
		if ($jsonitem['airdate'] >= $today && $jsonitem['airdate'] <= $week){
			$insertsql = "INSERT INTO `orion`.`tvepisodes` (`title`, `tvmaze`, `tv_id`, `airdate`, `season`, `season_number`) VALUES ";
      $insertsql .= "(\"".$jsonitem['name']."\", ".$jsonitem['id'].", ".$item['id'].", \"".$jsonitem['airdate']."\", ".$jsonitem['season'].", ".$jsonitem['number'].")";
			try {
				$stmt = $db->prepare($insertsql);
				$stmt->execute();
				$row_id =  $db->lastInsertId();
			} catch (PDOException $e) {
					echo 'Connection failed: ' . $e->getMessage();
			}
			$userssql = "SELECT user_id FROM orion.g_user_tv WHERE tv_id = ".$item['id'];
			$userquery = $db->query($userssql);
			foreach($userquery as $useritem){
				try {
					$gerundsql = "INSERT INTO g_user_tvepisodes(tvepisode_id, user_id, watched) VALUES (".$row_id.", ".$useritem['user_id'].", 0)";
					$stmt = $db->prepare($gerundsql);
					$stmt->execute();
				} catch (PDOException $e) {
						echo 'Connection failed: ' . $e->getMessage();
				}
			}
		}
	}
}
?>
