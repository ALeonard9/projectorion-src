<?php

session_start();
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>LeoNine Studios</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');




$sqlSoumsum = "SELECT SUM(betAmount) as betAmount FROM bet.history WHERE betWinner = 'Soumya'";
$sqlAdamsum = "SELECT SUM(betAmount) as betAmount FROM bet.history WHERE betWinner = 'Adam'";
$sqlopen = "SELECT * FROM bet.history WHERE betStatus = 'Open' order by betDate DESC";
$sqlall = "SELECT * FROM bet.history order by betDate DESC";

$intro= "Adam owes Soumya";

if (isset($_SESSION['username']))
        {
                $querySoumsum = $db->query($sqlSoumsum);
                        $resultsSoumsum = $querySoumsum->fetch(PDO::FETCH_ASSOC);
                $queryAdamsum = $db->query($sqlAdamsum);
                        $resultsAdamsum = $queryAdamsum->fetch(PDO::FETCH_ASSOC);
                        $dbbalance = $resultsSoumsum['betAmount'] - $resultsAdamsum['betAmount'];
                $queryopen = $db->query($sqlopen);
                        #$resultsopen = $queryopen->fetch(PDO::FETCH_ASSOC);
                $queryall = $db->query($sqlall);
                        #$resultsall = $queryall->fetch(PDO::FETCH_ASSOC);


        if ($dbbalance < 0)
                {
                $intro= "Soumya owes Adam";
                $dbbalance *= -1;
                }
        echo "<div class='container text-center'><h1>".$intro.": $".$dbbalance."</h1>";
        echo "<div class='row'><div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='quickbet.php?type=fart'>Quick Win S</button></div>";
        echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='quickbet.php?type=pick'>Quick Win A</button></div>";
        echo "<div class='col-md-4'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='newbet.php'>New Bet</button></div></div>";
        echo "<br><h3>Open Bets</h3>";
        echo "<table class='table table-hover table-striped'>";
        echo "<tr><td>Description</td><td>Amount</td><td>Last Update</td></tr>";

                foreach($queryopen as $item){
                        echo "<tr><td><a href='betdetails.php?betID=".($item['betID']."'>".$item['betDescription']."</a></td><td>$".abs($item['betAmount'])."</td><td>".substr($item['betDate'],5, 5)."</td></tr>");
                }
        echo "</table>";

        echo "<h3>History</h3>";
        echo "<table class='table table-hover table-striped'>";
        echo "<tr><td>Description</td><td>Amount</td><td>Status</td><td>Winner</td><td>Last Update</td></tr>";
                foreach($queryall as $item){
                        echo "<tr><td><a href='betdetails.php?betID=".($item['betID']."'>".$item['betDescription']."</a></td><td>$".abs($item['betAmount'])."</td><td>".$item['betStatus']."</td><td>".$item['betWinner']."</td><td>".substr($item['betDate'],5, 5)."</td></tr>");
                }
        #if ($_SESSION['usergroup']=='Admin')

        #if ($_SESSION['usergroup']=='User')
        }
else
  {
  header("location: ../users/signin.php");
  }
include('../footer.php');
echo "</table></div></div></body></html>";
?>
