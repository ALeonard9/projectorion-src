<?php
require_once '../composer/vendor/autoload.php';

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();

if (isset($_SESSION['userid'])){
  die('You are already signed in.');
}

include '../connectToDB.php';
$clientID = getenv('GOOGLE_CLIENT_ID');
$clientSecret = getenv('GOOGLE_CLIENT_SECRET');
$redirectUri = getenv('GOOGLE_REDIRECT_URL');
$PROTOCOL = isset($_SERVER['HTTPS']) ? 'https':'http';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
   
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  $sql = "SELECT * FROM `orion`.`users` WHERE email = '".$email."'";
  $query = $db->query($sql);
  $row_count = $query->rowCount();
    $results = $query->fetch(PDO::FETCH_ASSOC);
  if ($row_count>0){
    $_SESSION['username']=$results['display_name'];
    $_SESSION['email']= $results['email'];
      if ($_SESSION['username']==''){
        $_SESSION['username']=$_SESSION['email'];
      }
    $_SESSION['usergroup']=$results['user_group'];
    $_SESSION['userid']=$results['id'];
      } else {
    $sql1 = "INSERT INTO `orion`.`users` (`display_name`, `user_group`, `email`) VALUES ('".$name."', 'User', '".$email."')";
    $query = $db->query($sql1);
    $sql2 = "SELECT * FROM `orion`.`users` WHERE email = '".$email."'";
    $query = $db->query($sql2);
      $results = $query->fetch(PDO::FETCH_ASSOC);
      $_SESSION['username']=$results['display_name'];
      $_SESSION['email'] = $results['email'];
      if ($_SESSION['username']==''){
        $_SESSION['username']=$_SESSION['email'];
      }
      $_SESSION['usergroup']=$results['user_group'];
      $_SESSION['userid']=$results['id'];
  }

  if(isset($_SESSION['url']))
    $url = $_SESSION['url']; // holds url for last page visited.
  else
    $url = "/dashboard.php";
  header("Location: " . $PROTOCOL . "://".$_SERVER['HTTP_HOST'].$url);
  exit;

} else {
  // get the login url
  $authUrl = $client->createAuthUrl();
}

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam's Sandbox</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

echo "<div class='col-md-3'></div><div class='col-md-6'>
<div class='text-center'>
<a class='login' href='" . $authUrl . "''><img src='../images/signin_button.png' height='100px'/></a>
<h2> - OR - </h2></div>
<form class='form-signin' action='login.php' method='POST'>
        <h2 class='form-signin-heading'>Please sign in</h2>
        <label for='inputEmail' class='sr-only'>Email address</label>
        <input name='username' type='email' id='inputEmail' class='form-control' placeholder='Email address' required autofocus>
        <label for='inputPassword' class='sr-only'>Password</label>
        <input name='password' type='password' id='inputPassword' class='form-control' placeholder='Password' required>
        <br>
        <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-user'></span> Sign in</button>
</form>
</br><button class='btn btn-lg btn-inverse btn-block' onclick=location.href='createprofile.php'><span class='glyphicon glyphicon-pencil'></span> Sign up</button>
  </div>";


include('../footer.php');
echo "</div></body></html>";

?>