<?php
//header("Content-type: image/jpeg");
	require_once("conn.php");
	$dbConn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
	
	$ID = $_GET['imageID'];
 
	
	$sql = "SELECT imageName FROM gallery WHERE imageID=$ID";
	$res = mysqli_query($dbConn, $sql);
	$row = mysqli_fetch_assoc($res);
	
	$bigImage = $row['imageName'];
	echo "<div class='box'>";
	echo "<img src='images/$bigImage'>";
	echo "</div>";
?>
<!DOCTYPE>
<html>
<head>
<title>Stora bilder</title>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
<link href='style_phone.css' rel='stylesheet' type='text/css'>
</head>
<body>
</body>
</html>