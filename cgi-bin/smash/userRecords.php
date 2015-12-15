<?php

session_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Smash Tracker</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');



$sqlUserRecords = "SELECT * FROM smash.userRecord order by win_percentage desc";

if (isset($_SESSION['username']))
        {
                $queryopen = $db->query($sqlUserRecords);

        echo "<div class='container text-center'><h3>User Records</h3>";
        echo "<table class='table table-hover table-striped'>";
        echo "<tr><td>Name</td><td>Wins</td><td>Total Games</td><td>Win Percentage</td></tr>";

                foreach($queryopen as $item){
                        echo "<tr><td>".($item['display_name']."</td><td>".$item['wins']."</td><td>".$item['games']."</td><td>".$item['win_percentage']."</td></tr>");
                }
        echo "</table><button class='btn btn-lg btn-inverse btn-block' onclick=location.href='smash.php'><span class='glyphicon glyphicon-tower'></span> Smash Home</button>
        </div>";

        }
else
        header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
