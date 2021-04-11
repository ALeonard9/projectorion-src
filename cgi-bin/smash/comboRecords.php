<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Smash Tracker</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if(isset($_GET['sortby']))
  $sortby = $_GET['sortby'];
else
  $sortby = 'sorter';

if(isset($_GET['order']))
  $order = $_GET['order'];
else
  $order = 'DESC';

if($order == 'DESC')
  $op = 'ASC';
else
  $op = 'DESC';

$sqlComboRecords = "SELECT *, 100.0 * win_percentage as sorter FROM smash.comborecord order by $sortby $order, wins desc, deck1 asc, deck2 asc";
$sqlUnusedDecks = "SELECT * FROM smash.unusedcombos";
$sqlcountUnusedDecks = "SELECT count(*) as count FROM smash.unusedcombos";

$queryopen = $db->query($sqlComboRecords);
$querydecks = $db->query($sqlUnusedDecks);
$querycountdecks = $db->query($sqlcountUnusedDecks);
  $resultsCount = $querycountdecks->fetch(PDO::FETCH_ASSOC);
echo "<div class='container text-center'><h3>Combo Records</h3>";
echo "<table class='table table-hover table-striped'>";
echo "<tr><td onclick=\"window.location='comboRecords.php?sortby=deck1&order=".$op."'\">Deck 1</td><td onclick=\"window.location='comboRecords.php?sortby=deck2&order=".$op."'\">Deck 2</td><td onclick=\"window.location='comboRecords.php?sortby=wins&order=".$op."'\">Wins</td><td onclick=\"window.location='comboRecords.php?sortby=games&order=".$op."'\">Total Games</td><td onclick=\"window.location='comboRecords.php?sortby=win_percentage&order=".$op."'\">Win Percentage</td></tr>";

        foreach($queryopen as $item){
                echo "<tr><td>".($item['deck1']."</td><td>".$item['deck2']."</td><td>".$item['wins']."</td><td>".$item['games']."</td><td>".$item['win_percentage']."</td></tr>");
        }
echo "</table>";
echo "<br><h3>Unused Combos: ".$resultsCount['count']."</h3>";
echo "<table class='table table-hover table-striped'>";
echo "<tr><td>Deck 1</td><td>Deck 2</td></tr>";

        foreach($querydecks as $item){
                echo "<tr><td>".($item['deck1']."</td><td>".$item['deck2']."</td></tr>");
        }
echo "</table><button class='btn btn-lg btn-inverse btn-block' onclick=location.href='smash.php'><span class='glyphicon glyphicon-tower'></span> Smash Home</button>
</div>";

include('../footer.php');
echo "</div></body></html>";
?>
