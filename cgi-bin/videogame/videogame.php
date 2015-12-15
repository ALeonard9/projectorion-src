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



$sqlcomplete = "SELECT * FROM videogame.game WHERE GameStatus = 'Complete' order by Series ASC, SeriesNum ASC, Title ASC";
$sqlgamesum = "SELECT count(*) as Count FROM videogame.game WHERE GameStatus = 'Complete'";

if (isset($_SESSION['username']))
        {
                $querycomplete = $db->query($sqlcomplete);
                        #$resultsopen = $queryopen->fetch(PDO::FETCH_ASSOC);
                $querygamesum = $db->query($sqlgamesum);
                         $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

        echo "<div class='container text-center'><h1>Video game history</h1>";
        echo "<br><h3>Completed Games:".$resultsgamesum['Count']."</h3>";
        echo "<!DOCTYPE html>";
        echo "<html>";
        echo "<table class='table table-hover table-striped'>";
        echo "<tr><td>Title</td><td>System</td><td>Series</td><td>Rating</td></tr>";

                foreach($querycomplete as $item){
                        echo "<tr><td><a href='betdetails.php?betID=".($item['GameID']."'>".$item['Title']."</a></td><td>".$item['System']."</td><td>".$item['Series']."</td><td>".$item['Rating']."</td></tr>");
                }
        echo "</table></div>";

        // echo "<br><h3>History</h3>";
        // echo "<table class='table table-hover table-striped'>";
        // echo "<tr><td>Description</td><td>Amount</td><td>Status</td><td>Winner</td><td>Last Update</td></tr>";
        //         foreach($queryall as $item){
        //                 echo "<tr><td><a href='betdetails.php?betID=".($item['betID']."'>".$item['betDescription']."</a></td><td>$".abs($item['betAmount'])."</td><td>".$item['betStatus']."</td><td>".$item['betWinner']."</td><td>".substr($item['betDate'],5, 5)."</td></tr>");
        //         }
        // echo "</html>";
        #if ($_SESSION['usergroup']=='Admin')

        #if ($_SESSION['usergroup']=='User')
        }
else
        header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
