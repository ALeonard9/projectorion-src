<?php

session_start();
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam's Sandbox</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if (isset($_GET['id'])){
  $user_id = $_GET['id'];
  $usersql = "SELECT display_name FROM orion.users  WHERE id =".$user_id;
  $userresp = $db->query($usersql);
           $user = $userresp->fetch(PDO::FETCH_ASSOC);
	$username = $user['display_name'].'\'s';




$moviesql = "SELECT * FROM orion.movies m, orion.g_user_movies g WHERE m.id = g.movies_id and g.completed = 1 and g.user_id =".$user_id." order by rank";
            $moviequery = $db->query($moviesql);
						$sqlgamesum = "SELECT count(*) as Count FROM orion.movies m, orion.g_user_movies g WHERE g.completed = 1 and m.id = g.movies_id  and g.user_id =".$user_id;
						$querygamesum = $db->query($sqlgamesum);
										 $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

echo "<div class='col-md-12'></div>
      <div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1>".$username." Movies</h1>
					<h3>Movies Watched:".$resultsgamesum['Count']."</h3>
          </br>
					<ul>";

					foreach($moviequery as $item){
									echo "<li class='list-group-item'><img src='".$item['poster_url']."' class='img-rounded img-responsive' style='width:30px;height:20px;float:left'><span class='badge'>".$item['rank']."</span>   ".$item['title']."</li>";
					}
echo"	</ul>
		</div>";

} else {
  echo "<h1>This user does not exist.";
}

include('../footer.php');
echo "</div></body></html>";
?>
