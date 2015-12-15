<?php

session_start();

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Smash Tracker</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if (isset($_SESSION['username']))
        {
        if ($_SESSION['usergroup']=="Admin" || $_SESSION['usergroup']=="Smash")
                {
                echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='userRecords.php'>View Users</button></div>";
                echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='factionRecords.php'>View Factions</button></div>";
                echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='comboRecords.php'>View Combos</button></div>";
                echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='gameRecords.php'>View Games</button></div>";
                echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='newGame.php'>Add new game</button></div>";
        }
      }
else
        header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
