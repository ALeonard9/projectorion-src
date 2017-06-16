<?php

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam's Sandbox</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

$user_id = $_GET['id'];
# TODO Add query for user
$user = 'Adam';
if (isset($user)) {
	$username = $user.'\'s';
}



$booksql = "SELECT * FROM orion.books m, orion.g_user_books g WHERE m.id = g.books_id and g.completed = 1 and g.user_id =".$user_id." order by rank";
            $bookquery = $db->query($booksql);
						$sqlgamesum = "SELECT count(*) as Count FROM orion.books m, orion.g_user_books g WHERE g.completed = 1 and m.id = g.books_id  and g.user_id =".$user_id;
						$querygamesum = $db->query($sqlgamesum);
										 $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

echo "<div class='col-md-12'></div>
      <div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1>".$username." Books</h1>
					<h3>Books Watched:".$resultsgamesum['Count']."</h3>
          </br>
					<ul>";

					foreach($bookquery as $item){
									echo "<li class='list-group-item'><img src='".$item['poster_url']."' class='img-rounded img-responsive' style='width:30px;height:20px;float:left'><span class='badge'>".$item['rank']."</span>   ".$item['title']."</li>";
					}
echo"	</ul>
		</div>";

include('../footer.php');
echo "</div></body></html>";
?>
