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



$sql = "SELECT * FROM smash.game g LEFT JOIN smash.users u ON g.winner_user = u.user_id order by game_id desc";

if ($_SESSION['username'])
        {
                $queryopen = $db->query($sql);

        echo "<div class='container text-center'><h3>Games</h3>";
        echo "<table class='table table-hover table-striped'>";
        echo "<tr><td>Game ID</td><td>Game Date</td><td>Winner</td></tr>";

                foreach($queryopen as $item){
                        echo "<tr><td><a href='gameDetails.php?gameID=".($item['game_id']."'>".$item['game_id']."</a></td><td>".$item['game_date']."</td><td>".$item['display_name']."</td></tr>");
                }
        echo "</table><button class='btn btn-lg btn-inverse btn-block' onclick=location.href='smash.php'><span class='glyphicon glyphicon-tower'></span> Smash Home</button>
        </div>";

        }
else
        die("You must login");

include('../footer.php');
echo "</div></body></html>";
?>
