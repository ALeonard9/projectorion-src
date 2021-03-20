<?php

session_start();
ob_start();

include '../connectToDB.php';
include 'functions/functions.php';

$imdbID = $_GET['imdbid'];
$complete = $_GET['complete'];
$movieTitle = urldecode($_GET['title']);
$tmdb_api_key = getenv('TMDB_API_KEY');
$api = "https://api.themoviedb.org/3/find/".$imdbID."?api_key=".$tmdb_api_key."&external_source=imdb_id";
$apiresponse =  file_get_contents($api);
$json = json_decode($apiresponse, true);
$poster_path =  $json['movie_results'][0]['poster_path'];
$poster = "https://image.tmdb.org/t/p/w185".$poster_path;
if ($poster == 'https://image.tmdb.org/t/p/w185') {
        $poster = 'https://upload.wikimedia.org/wikipedia/en/f/f9/No-image-available.jpg';
}
$user_id = $_SESSION['userid'];

$check = "SELECT * FROM orion.movies where imdb='".$imdbID."';";
$stmt = $db->prepare($check);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( !$row){
        $stmt = $db->prepare("INSERT INTO `orion`.`movies` (`imdb`, `title`, `poster_url`) VALUES (:id, :title, :poster)");
        $stmt->bindParam(':id', $imdbID);
        $stmt->bindParam(':title', $movieTitle);
        $stmt->bindParam(':poster', $poster);
        $stmt->execute();
        $movie_id =  $db->lastInsertId();
} else {
        $movie_id = $row['id'];
}

updateMovie($imdbID);

if (isset($_SESSION['userid']))
        {
                $stmt = $db->prepare("INSERT INTO orion.g_user_movies (`user_id`, `movies_id`, `rank`, `completed`, `g_first`) VALUES (:user, :row, '0', :complete, now())");
                $stmt->bindParam(':user', $user_id);
                $stmt->bindParam(':row', $movie_id);
                $stmt->bindParam(':complete', $complete);
                $stmt->execute();

                if ($complete == 0)
                {
                        header("Location: watchlist.php");
                        exit;
                }
                else
                {
                        header("Location: movie.php");
                        exit;
                }
        }
else
        {
        header("location: ../users/signin.php");
        }
?>