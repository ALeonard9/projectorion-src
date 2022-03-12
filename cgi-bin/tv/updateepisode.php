<?php
require '../composer/vendor/autoload.php';
include '../connectToDB.php';
include 'functions/functions.php';

if (isset($_GET['tvmaze_id'])) {
  $search = $_GET['tvmaze_id'];
  updateEpisode($search);
}
header("location: schedule.php");
?>
