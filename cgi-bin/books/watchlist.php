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
$user_id = $_SESSION['userid'];
$username = 'Your';
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'].'\'s';
}
if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){

$booksql = "SELECT * FROM orion.books m, orion.g_user_books g WHERE m.id = g.books_id and g.completed = 0 and g.user_id =".$user_id." order by m.title";
            $bookquery = $db->query($booksql);

echo "<div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1><a href='book.php'>".$username." Book Watchlist</a></h1>
					<a href='findbook.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-plus'></span> Add a Book</a></br>
					<ul class='list-group' id='list-items'>";
					foreach($bookquery as $item){
            echo "<li class='list-group-item'><a href='https://books.google.com/books?id=".$item['googleid']."' target='_blank'><span class='glyphicon glyphicon-book'></span></a>    <a href='watched.php?id=".$item['g_id']."'>".$item['title']."</a></li>";
					}
echo"	</ul>
		</div>";

}
else
	  header("location: book.php");

include('../footer.php');
echo "</div></body></html>";
?>
