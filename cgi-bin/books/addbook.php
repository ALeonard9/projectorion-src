<?php

session_start();
ob_start();
date_default_timezone_set('Etc/UTC');

include '../connectToDB.php';
$today = date();
$week =  date('Y-m-d', strtotime('+7 days'));

$id = $_GET['id'];
$title = urldecode($_GET['title']);
$poster = urldecode($_GET['poster']);
$isbn = $_GET['isbn'];
$complete = $_GET['complete'];
$user_id = $_SESSION['userid'];

if ($poster == 'N/A') {
	$poster = 'https://upload.wikimedia.org/wikipedia/en/f/f9/No-image-available.jpg';
}
$check = "SELECT * FROM orion.books where googleid='".$id."';";
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare($check);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( !$row){
	try {
		$stmt = $db->prepare("INSERT INTO orion.books (`googleid`,`title`, `poster_url`, `isbn`) VALUES (:id, :title, :poster, :isbn)");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':poster', $poster);
		$stmt->bindParam(':isbn', $isbn);
		$stmt->execute();
		if ( false===$result ) {
            error_log( serialize ($stmt->errorInfo()));
        }
		$row_id =  $db->lastInsertId();
	} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	}
} else {
	$row_id = $row['id'];
}

echo "ROW ID: ".$row_id;
echo "User ID: ".$user_id;
echo "Complete: ".$complete;
if (isset($_SESSION['userid']))
	{
		try {
			$stmt = $db->prepare("INSERT INTO orion.g_user_books (`user_id`, `books_id`, `rank`, `completed`) VALUES (:user, :row, '0', :complete)");
			$stmt->bindParam(':user', $user_id);
			$stmt->bindParam(':row', $row_id);
			$stmt->bindParam(':complete', $complete);
			$stmt->execute();
			if ( false===$result ) {
				error_log( serialize ($stmt->errorInfo()));
			}
		} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
		}
  	header("Location: book.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
