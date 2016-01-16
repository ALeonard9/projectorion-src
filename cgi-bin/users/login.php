<?php

session_start();
ob_start();

$username = strtolower($_POST['username']);
$password = $_POST['password'];

include '../connectToDB.php';

$sql = "SELECT * FROM orion.users WHERE email = :username";
if ($username&&$password)
{
		$query = $db->prepare($sql);
		$query->execute(array(':username'=>$username));
				  $row_count = $query->rowCount();
					$results = $query->fetch(PDO::FETCH_ASSOC);
					$dbusername = $results['display_name'];
					$dbpassword = $results['password'];
					$dbusergroup = $results['user_group'];
					$dbuserid = $results['id'];
					$dbemail = $results['email'];

					if ($row_count>0)
						{
							if(password_verify($password, $dbpassword))
							{
							$_SESSION['username']=$dbusername;
							if ($_SESSION['username'] == ''){
								$_SESSION['username'] = $dbemail;
							}
							$_SESSION['email'] = $dbemail;
							$_SESSION['usergroup']=$dbusergroup;
							$_SESSION['userid']=$dbuserid;
							if(isset($_SESSION['url']))
								$url = $_SESSION['url']; // holds url for last page visited.
							else
   							$url = "/index.php";
							header("Location: http://".$_SERVER['HTTP_HOST'].$url);
							exit;
							}
							else
							{
							die("Username/password is incorrect.");
							}
						}
					else {
							die("User does not exist.");
						 }
} else
	die("Please enter a login");

?>
