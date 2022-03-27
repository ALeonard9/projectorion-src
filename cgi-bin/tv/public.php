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

$user_id = $_GET['id'];
# TODO Add query for user
$user = 'Adam';
if (isset($user)) {
	$username = $user.'\'s';
}



$sql = "SELECT * FROM orion.tv c, orion.g_user_tv g WHERE c.id = g.tv_id AND g.user_id =" . $user_id . " order by rank";
$query = $db->query($sql);
$sqlsum     = "SELECT count(*) as Count FROM orion.g_user_tv g WHERE g.user_id =" . $user_id;
$querysum   = $db->query($sqlsum);
$resultssum = $querysum->fetch(PDO::FETCH_ASSOC);

echo "<div class='col-md-12'></div>
      <div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1>".$username." TV Shows</h1>
					<h3>Shows Watched:".$resultssum['Count']."</h3>
          </br>
					<ul>";

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

						echo "<li draggable=true class='list-group-item' id='item_" . ($item['g_id'] . "'><a href='tvdetails.php?id=" . $item['tv_id'] . "'><span class='badge'>" . $item['rank'] . "</span>   " . $item['title'] . "</a><button class='pull-right " . $classw . "' >" . $item['status'] . "</button></li>");
					}
echo"	</ul>
		</div>";

include('../footer.php');
echo "</div></body></html>";
?>
