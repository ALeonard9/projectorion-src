<?php
// Queries each TV series and checks whether it is running or stopped
date_default_timezone_set('Etc/UTC');
echo "Update TV executed on: " . date('Y-m-d H:i:s') . "\n";

require '../composer/vendor/autoload.php';
include '../connectToDB.php';

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM orion.tv";
$query = $db->query($sql);

foreach($query as $item){
	$searchafter = $item['imdb'];
	$response = Unirest\Request::get("http://api.tvmaze.com/lookup/shows?imdb=$searchafter",
		array(
			"Accept" => "application/json"
		)
	);
	$json = json_decode($response->raw_body, true);
	if ($json['status'] != $item['status']) {
		try {
			$stmt = $db->prepare("UPDATE `orion`.`tv` SET `status`=:status WHERE `id`=:id");
			$stmt->bindParam(':id', $item['id']);
			$stmt->bindParam(':status', $json['status']);
			$stmt->execute();
			if ( !$stmt ) {
				error_log( serialize ($stmt->errorInfo()));
			}
			echo $item['title']." updated to ".$json['status']." \n";
		} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
		}
	}
}
?>
