<?php

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
 
IF ($iphone || $android || $palmpre || $ipod || $berry == true) 
{ 
header('Location: blogg_phone.php');
 
}

require_once("conn.php");		//hämtar informationen i filen conn.php där variablerna är definierade
$dbConn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);		//själva uppkopplingen -- (localhost, användaren, lösenord, databasens namn)

	

if (mysqli_connect_errno()) 
		{
			printf("Connect failed: %s\n", mysqli_connect_error());		//skriver ut felmeddelande och avslutar
			exit();
		}
?>
<!doctype html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
<link href='style.css' rel='stylesheet' type='text/css'>
<title>Blogg</title>
</head>

<body>

<div id="wrapper">
			
		<?php
		session_start();
			if(isset($_SESSION['inloggad']))
			{
				if($_SESSION['inloggad'] == "japp")
				{
					echo "<div id='login'>";
					echo "<a href='session_destroy.php'><input type='submit' value='Logga ut'/></a>";
					echo "<a href='blogg_add.php'><input type='submit' value='Admin'/></a>";
					echo "</div>";
				}	
								
			}
			else 	
			{
				echo "<div id='login'>";
				echo "<a href='inlogg.php'><input type='submit' value='Logga in'/></a>";
				echo "</div>";
			}
							
		?>	
	
	
		
	<div id="header"><h1><a href="blogg_index.php">Blogg</a></h1></div> 
	<div id="menu">
		<ul>
			<?php 
			if(isset($_GET['currentCatID']))
			{
				$catDesc = displayCategories($currentCatID); 	//kallar på funktionen displayCategories() som skriver ut menyn och skickar in $currentCatID
			}
			else
			{
				$catDesc = displayCategories(1);
			}
			?>			
						
		</ul>
	</div> <!-- end of menu div -->
		
			
							
	
	<div id="content">
	
    	<h2>Senaste inläggen</h2>
			
		
		<?php
		
			writePosts_index();		//kallar på funktionen writePosts_index
		?>
		   
        
	</div> <!-- end of content div -->
	<div id="footer">Layout: Maria Lindén</div> <!-- end of footer div -->
</div> <!-- end of wrapper div -->

</body>

</html>

<?php
	function writePosts_index()
	{
		global $dbConn;
		
		$sql =  "SELECT posted, bloggID, content, posterName, posted FROM bloggposts ORDER BY bloggID DESC LIMIT 0,10  ";	//hämtar information från databasen
		//$sql =  "SELECT posted, bloggID, content, posterName, posted FROM bloggPosts ORDER BY bloggID DESC LIMIT 0,10  ";

		$res = mysqli_query($dbConn, $sql);
		while ( $row = mysqli_fetch_assoc($res) )		//så länge som det finns rader att hämta kommer loopen att hämta dem
		{
			echo "<div class='box'>".   $row['content'] ; 							//skriver ut raden med content (och divklassen)
			echo "<p>" . $row['posterName'] . " - " . $row['posted'] ."</p>";		//skriver ut namnet på inläggsförfattaren och datumet
			echo "</div>";
	
		}
		
	}
		
	
	function displayCategories($currentCatID)
	{
		global $dbConn;														//gör databasen tillgänglig
		$sql = "SELECT catID, catName, catDesc FROM bloggcat";			//fråga till databasen
		
		$res = mysqli_query($dbConn, $sql);									//stoppar in frågan i $res
		
		while ($row = mysqli_fetch_assoc($res))								//loopar igenom alla rader
		{
			$catID = $row['catID'];
			$catName = $row['catName'];
			
			if ($catID == $currentCatID)
			{
			$description = $row['catDesc'];
			}
			
			echo "<li><a href='blogg_cat.php?ID=$catID'>$catName</a></li>";
		}
		
		return $description;												//skickar tillbaka description till sidan
	}
		
	
	mysqli_close($dbConn) ;			//stänger ner uppkopplingen till databasen -> viktigt att den inte är INUTI funktionen
?>



