<?php

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam Leonard</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');
$user_id = $_SESSION['userid'];
$username = 'Your';
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'].'\'s';
}
if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){

$start_rank = 1;

if (isset($_GET['rank'])) {
  $start_rank = $_GET['rank'];
}

if (isset($_POST['rank'])) {
  $start_rank = $_POST['rank'];
}

$sql = "SELECT * FROM orion.tv c, orion.g_user_tv g WHERE c.id = g.tv_id and (g.rank >= $start_rank or g.rank = 0 ) and g.user_id =".$user_id." order by rank";
            $query = $db->query($sql);
						$sqlgamesum = "SELECT count(*) as Count FROM orion.g_user_tv g WHERE g.user_id =".$user_id;
						$querygamesum = $db->query($sqlgamesum);
										 $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

echo "<div class='col-md-12'><a href='tv.php?rank=".$start_rank."' class='fixed_middle_right' ><span class='glyphicon glyphicon-refresh'></span></a></div>
      <div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1>".$username." TV</h1>
          <a href='schedule.php' class='btn btn-lg btn-inverse btn-block' >Schedule</a>
					<a href='findtv.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-plus'></span> Add a Tv Series</a>
					<h3>Series Watched: ".$resultsgamesum['Count']."</h3>
          <form class='form-signin' action='tv.php' form='thisForm' method='POST'>
          <div class='input-group'>
            <input type='hidden' id='table' value='tv'>
            <input type='number' class='form-control' id='rank' name='rank' value='".$start_rank."'>
            <span class='input-group-btn'>
              <button class='btn btn-default' type='submit'>Go To...</button>
            </span>
          </div>
          </form></br>
					<ul class='list-group' id='list-items'>";

					foreach($query as $item){
            $classw = '';
            switch ($item['status']) {
                case 'Up to Date':
                    $classw = 'uptodate';
                    break;
                case 'Behind':
                    $classw = 'behind';
                    break;
                case 'Complete':
                    $classw = 'complete';
                    break;
            }
						echo "<li draggable=true class='list-group-item' id='item_".($item['g_id']."'><a href='tvdetails.php?id=".$item['tv_id']."'><span class='badge'>".$item['rank']."</span>   ".$item['title']."</a><button class='pull-right ".$classw."' >".$item['status']."</button></li>");
					}
echo"	</ul>
		TV information was freely provided by <a href='http://www.tvmaze.com/'>tvmaze.com.</a></div>";

}
else
	  header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
