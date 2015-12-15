<?php

session_start();

include '../connectToDB.php';
// include 'functions/functions.php';

// $user = nameUser(1);
// echo $user;
$deck_id
 = '1';

function nameDeck($deck_id123)
  {
		include '../connectToDB.php';
//     $sql123 = "SELECT * FROM smash.deck d where d.deck_id=".$deck_id123;
// 		echo $sql123;
//     $query = $db->query($sql123);
// 		echo $query;
//     $res123 = $query->fetch();
// 		echo $res123;
//     $faction_name123 = $res123['faction_name'];
//     echo $faction_name123;
// 		return $faction_name123;
$sql1 = "SELECT * FROM smash.deck d where d.deck_id=".$deck_id123;
echo $sql1;
$query1 = $db->query($sql1);
$res = $query1->fetch();
$faction_name = $res['faction_name'];
echo $faction_name;
return $faction_name;

  }

$asdf= nameDeck('1');

echo $asdf;
//
// $gameID = '8';
//
// $sql = "SELECT l.l_user_id AS user, l.l_deck_id AS deck1, k.l_deck_id AS deck2 FROM smash.gamelog l, smash.gamelog k WHERE l.l_game_id = k.l_game_id AND l.l_user_id = k.l_user_id AND l.l_deck_id < k.l_deck_id AND l.l_game_id =".$gameID;
//
// if (isset($_SESSION['username']))
// 	{
//   // echo "hello";
// 	$query = $db->query($sql);
// 	foreach($query as $item){
// 		// echo "yep ype";
//     // $user = nameUser(1);
//     // $deck1 = nameDeck(2);
//     // $deck2 = nameDeck(3);
//     // echo $user;
//     // echo $deck1;
//     // echo $deck2;
//
//
//   }
// }

?>
