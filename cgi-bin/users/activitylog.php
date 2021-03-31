<?php

session_start();
ob_start();
date_default_timezone_set('Etc/UTC');

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam's Sandbox</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');
$user_id = $_SESSION['userid'];
$begin = date('Y-m-d', strtotime('-30 days'));




if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){
    $sql = "SELECT t.title as tv_title, e.season, e.season_number, e.title, g.g_first, g.g_id, t.id as tv_id FROM orion.tv t, orion.g_user_tv u, orion.g_user_tvepisodes g, orion.tvepisodes e WHERE u.tv_id = t.id AND g.tvepisode_id = e.id AND g.user_id = ".$user_id." AND u.user_id = ".$user_id." AND e.tv_id = t.id AND g.watched = 1 AND g.g_first >= '".$begin."' order by g.g_first DESC";
    $query = $db->query($sql);
    $count = $query->rowCount();
    if ($count > 0) {
    echo "<div class='col-md-6'><h1 class='text-center'>Activity Log</h1>
            <div class='panel-group'>";
            $day = 0;
            foreach($query as $item){
                $item_day = date('m-d', strtotime($item['g_first']));
                if($day != $item_day && $day != 0){
                echo "</ul></div></div>";
                }
                if( $day != $item_day){
                $day = $item_day;
                echo "<div class='panel panel-default'>
                <div class='panel-heading'>
                    <h4 class='panel-title'>
                    ".date('l', strtotime($item['g_first']))." ".date('m-d', strtotime($item['g_first']))."<a data-toggle='collapse' href='#collapse".$item_day."'><span class='pull-right glyphicon glyphicon-minus'></span></a>
                    </h4>
                </div>
                <div id='collapse".$item_day."' class='panel-collapse collapse in'>
                    <ul class='list-group'>";
                }
 
                $full_string = "<a href='tvdetails.php?id=".$item['tv_id']."'>".$item['tv_title']."</a> ".$item['season'].".".$item['season_number'].": ".$item['title'];

                echo "<li class='list-group-item'>".$full_string."</li>";
            }
            echo "</div></div></div></div>";
    } else {
    echo "<h1>No recent activity!</h1>";
    }

    echo "</div>";
}
else
	  header("location: ../users/signin.php");

include('../footer.php');
echo "</div>
</body></html>";
?>
