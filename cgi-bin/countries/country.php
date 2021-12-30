<?php

if(!isset($_SESSION)) {
  session_start();
} ;
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

$api = 'https://raw.githubusercontent.com/lipis/flag-icons/main/flags/4x3/';

$sql = "SELECT * FROM orion.countries c, orion.g_user_countries g WHERE c.id = g.countries_id and (g.rank >= $start_rank or g.rank = 0 ) and g.user_id =".$user_id." order by rank";
            $query = $db->query($sql);
						$sqlcompletesum = "SELECT count(*) as Count FROM orion.countries c, orion.g_user_countries g WHERE c.id = g.countries_id and g.completed = 1 and g.user_id =".$user_id;
						$querycompletesum = $db->query($sqlcompletesum);
										 $resultscompletesum = $querycompletesum->fetch(PDO::FETCH_ASSOC);

echo "<div class='col-md-12'><a href='country.php?rank=".$start_rank."' class='fixed_middle_right' ><span class='glyphicon glyphicon-refresh'></span></a></div>
      <div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1>".$username." Countries</h1>
					<a href='findcountry.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-plus'></span> Add a Country</a>
          <a href='countryflags.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-flag'></span> Flag Page</a>
          <h3>Countries Visited:".$resultscompletesum['Count']."</h3>
          <form class='form-signin' action='country.php' form='thisForm' method='POST'>
          <div class='input-group'>
            <input type='hidden' id='table' value='countries'>
            <input type='number' class='form-control' id='rank' name='rank' value='".$start_rank."'>
            <span class='input-group-btn'>
              <button class='btn btn-default' type='submit'>Go To...</button>
            </span>
          </div>
          </form></br>
					<ul class='list-group' id='list-items'>";

					foreach($query as $item){
            $apiresponse = $api.$item['country_code'].".svg";
						echo "<li draggable=true class='list-group-item' id='item_".($item['g_id']."'><a href='countrydetails.php?id=".$item['countries_id']."'><div class='container-fixed'><div class='row-fluid'><img src='".$apiresponse."' class='img-rounded img-responsive' style='width:30px;height:20px;float:left'><span class='badge'>".$item['rank']."</span>   ".$item['title']."</div></div></a></li>");
					}
echo"	</ul>
		</div>";

}
else
	  header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
