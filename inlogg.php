<?php
require_once("conn.php");		//hämtar informationen i filen conn.php där variablerna är definierade
$dbConn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);		//själva uppkopplingen -- (localhost, användaren, lösenord, databasens namn)

	if(isset($_POST['userName']))
	{
		
		$userName = $_POST['userName'];
		$password = $_POST['password'];
		
		$password = hash('sha256', $password);	
		
		$sql = "SELECT password, userName FROM usertable WHERE password = '$password' AND userName = '$userName'";
		
		$res = mysqli_query($dbConn, $sql);
		if($row = mysqli_fetch_assoc($res))		//om det finns en användare med dessa uppgifter
		{
			echo "Korrekt inloggning";
			session_start();
			$_SESSION['inloggad'] = "japp";
			header("Location:blogg_index.php");
			die();
			
		}
			else
			{
				echo "Felaktig inloggning";
				die();
			}
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
<link href='style.css' rel='stylesheet' type='text/css'>
<title>Inloggning</title>
</head>
<body>
	<div id="loginpage">

		<form method="post" action="inlogg.php">		
			<h4>Logga in</h4>
			Namn<input type="text" name="userName"/>
			Lösenord<input type="password" name="password"/>
			<input type="submit" value="Logga in"/>
		</form>
	
	
	
		<form method="post" action="add_user.php">
			<h4>Registrera ny användare</h4>	
			Namn<input type="text" name="userName"/>
			Lösenord<input type="password" name="password"/>
			<input type="submit" value="Registrera dig"/>
		</form>
	</div>

</body>

</html>