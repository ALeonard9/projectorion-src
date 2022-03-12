<?php
require '../composer/vendor/autoload.php';
include '../connectToDB.php';
include 'functions/functions.php';
date_default_timezone_set('Etc/UTC');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$yesterday = date('Y-m-d', strtotime('-1 days'));
$tomorrow = date('Y-m-d', strtotime('+1 days'));
$sql = "SELECT tvmaze FROM orion.tvepisodes where airdate >= '$yesterday' AND airdate <= '$tomorrow'";
$query = $db->query($sql);


foreach ($query as $item)
{
    updateEpisode($item['tvmaze']);
}
header("location: schedule.php");

?>
