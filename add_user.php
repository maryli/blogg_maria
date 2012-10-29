<?php
require_once("conn.php");		//h‰mtar informationen i filen conn.php d‰r variablerna ‰r definierade
$dbConn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);		//sj‰lva uppkopplingen -- (localhost, anv‰ndaren, lˆsenord, databasens namn)

	$userName = $_POST['userName'];
	$password = $_POST['password'];
		
	$password = hash('sha256', $password);		//hashar lˆsenordet med sha256. Hashen ger alltid 64 tecken.
	
		
	$userName = mysqli_real_escape_string($dbConn, $userName);
	$userName = htmlspecialchars($userName);					//tar bort eventuell html-kod ur anv‰ndarnamnet
		
	$sql = "INSERT INTO usertable (userName, password) VALUES ('$userName', '$password')";
	mysqli_query($dbConn, $sql);
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
	<link href='style.css' rel='stylesheet' type='text/css'>
	<title>Ny anv√§ndare</title>
<head>
<body>
	<div class="user">
		<h2>Du √§r nu registrerad anv√§ndare av Bloggen.</h2>

		<div class="img">
			<img src="images/thumb_connect.jpg">
		</div>
		<p><a href="blogg_index.php">Klicka h√§r</a> f√∂r att g√• tillbaka till bloggen och logga in.</p>
	</div>
</body>
</html>