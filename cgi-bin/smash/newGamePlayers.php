<?php

session_start();
ob_start();

include '../connectToDB.php';
include 'functions/functions.php';

$numPlayers = $_POST['num_players'];
$players = array();
$u1 = $_POST['nuser1'];
$u2 = $_POST['nuser2'];
$u3 = $_POST['nuser3'];
$u4 = $_POST['nuser4'];

for ($x = 1; $x <= $numPlayers; $x++) {
  array_push($players, ${'u'.$x});
}
shuffle($players);

$sql2 = "SELECT deck_id FROM smash.deck";
$decks = array();
$querydecks = $db->query($sql2);
foreach($querydecks as $deck){
  array_push($decks, $deck['deck_id']);
}
shuffle($decks);
$sql = "SELECT * FROM smash.users";
$queryopen = $db->query($sql);
echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Smash Tracker</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if (isset($_SESSION['username']))
	{
    echo "
    <div class='col-md-3'></div><div class='col-md-6'>
    <form class='form-signin' action='newGameUpdate.php' method='POST' id='myForm'>
      <input type='hidden' name='num_players' value='".$numPlayers."'>
      <input type='hidden' name='gameid' value='".$gameid."'>";
    $x = 1;
    while($x <= $numPlayers) {
        echo "
        <div class='form-group'>
          <label for='user".$x."'>User ".$x."</label>
          <select class='form-control' form='myForm' name='user".$x."'>
            <option disabled='disabled'>Select Player</option>";
            $sql = "select * from smash.users order by display_name";
            $queryopen = $db->query($sql);
            foreach($queryopen as $item){
                    echo "<option ";
                    if ($item['user_id'] == $players[$x-1])
                    {
                      echo "selected='selected' ";
                    }
                    echo "value=".($item['user_id'].">".$item['display_name']."</option>");
            };

        echo "</select></div>
        <div class='form-group'>
          <label for='deck1".$x."'>Deck 1</label>
          <select class='form-control' form='myForm' name='deck1".$x."'>
            <option disabled='disabled' selected='selected'>Select Deck</option>";
            $sql = "select * from smash.deck order by faction_name";
            $queryopen = $db->query($sql);
            foreach($queryopen as $item){
                    echo "<option ";
                    if ($item['deck_id'] == $decks[($x*2)+1])
                    {
                      echo "selected='selected' ";
                    }
                    echo "value=".($item['deck_id'].">".$item['faction_name']."</option>");
            };

        echo "</select></div>
        <div class='form-group'>
          <label for='deck2".$x."'>Deck 2</label>
          <select class='form-control' form='myForm' name='deck2".$x."'>
            <option disabled='disabled' selected='selected'>Select Deck</option>";
            $sql = "select * from smash.deck order by faction_name";
            $queryopen = $db->query($sql);
            foreach($queryopen as $item){
                    echo "<option ";
                    if ($item['deck_id'] == $decks[($x*2)+2])
                    {
                      echo "selected='selected' ";
                    }
                    echo "value=".($item['deck_id'].">".$item['faction_name']."</option>");
            };
        echo "</select></div>";
        $x++;
    }
		echo"<button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Submit</button>
    	<button class='btn btn-lg btn-warning btn-block' onClick='history.go(-1);return true;'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>
	</form></div>";
	}
else
	{	header("location: ../users/signin.php"); }
include('../footer.php');
echo "</div></body></html>";
?>
