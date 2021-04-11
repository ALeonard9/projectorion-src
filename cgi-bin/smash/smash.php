<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Smash Tracker</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='userRecords.php'>View Users</button></div>";
echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='factionRecords.php'>View Factions</button></div>";
echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='comboRecords.php'>View Combos</button></div>";
echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='gameRecords.php'>View Games</button></div>";
if (isset($_SESSION['userid'])){
  echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='newGame.php'>Add new game</button></div>";
}
include('../footer.php');
echo "</div></body></html>";
?>
