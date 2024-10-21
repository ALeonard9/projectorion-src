<?php
// Queries tv episodes within a few days and ensures the data is correct
date_default_timezone_set('Etc/UTC');
echo "Update recent TV Episodes executed on: " . date('Y-m-d H:i:s') . "\n";

require '../composer/vendor/autoload.php';
include '../connectToDB.php';
include 'functions/functions.php';

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$yesterday = date('Y-m-d', strtotime('-1 days'));
$tomorrow = date('Y-m-d', strtotime('+1 days'));
$sql = "SELECT tvmaze FROM orion.tvepisodes where airdate >= '$yesterday' AND airdate <= '$tomorrow'";
$query = $db->query($sql);


foreach ($query as $item)
{
    updateEpisode($item['tvmaze']);
}
// Check if the request is coming from a browser
if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== false) {
    header("Location: schedule.php");
    exit(); // Always call exit after a redirect
}

?>
