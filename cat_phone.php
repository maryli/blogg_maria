<?php
require_once("conn.php");		//hämtar informationen i filen conn.php där variablerna är definierade


$currentCatID = (int) $_GET['ID'];		//hämtar informationen i adressfältet (ID=1) och gör om informationen till ett heltal
if($currentCatID == 0)					//vid felaktigt ID eller inget ID...
{
	$currentCatID = 1;					//...hämtas ID 1
}

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
<link href='style_phone.css' rel='stylesheet' type='text/css'>
<title>Blogg</title>
</head>

<body>

<div id="wrapper">
<div id="header"><h1><a href="blogg_phone.php">Blogg</a></h1></div> <!-- Kommentar -->
	<div id="menu">
		<ul>
			<?php 
			$catDesc = displayCategories($currentCatID); 			//kallar på funktionen displayCategories() som skriver ut menyn och skickar in $currentCatID
			
			?>
			
		</ul>
	</div>
	
	<div id="content">
	
    	<h2>Senaste inläggen</h2>
		
		<?php
			echo "<div id='catDesc'>".$catDesc."</div>";
				
			writePosts($currentCatID);		//kallar på funktionen writePosts med parametern $currenCatID
			
			if(isset($_GET['ID']))
			{
				if($_GET['ID'] == 3)
				{
					gallery();
				}
			}
		?>
		
           
	</div> <!-- end of content div -->
	
	<div id="footer">Layout: Maria Lindén</div> <!-- end of footer div -->
	
</div> <!-- end of wrapper div -->

</body>

</html>

<?php
	function writePosts($catID)
	{
		global $dbConn;
		
		$sql =  "SELECT posted, bloggID, content, posterName, posted FROM bloggposts WHERE catID=$catID ORDER BY bloggID DESC LIMIT 0,10  ";		//hämtar information från databasen


		$res = mysqli_query($dbConn, $sql);
		while ( $row = mysqli_fetch_assoc($res) )		//så länge som det finns rader att hämta kommer loopen att hämta dem
		{
			echo "<div class='box'>".   $row['content'] ; 							//skriver ut raden med content (och divklassen)
			echo "<p>" . $row['posterName'] . " - " . $row['posted'] ."</p>";		//skriver ut namnet på inläggsförfattaren och datumet
			echo "</div>";
	
		}
		
	}
	
	// funktion för galleriet
	function gallery()
	{
		global $dbConn;
		
		$sql = "SELECT thumbName, imageID FROM gallery ORDER BY imageID";
		
		$res = mysqli_query($dbConn, $sql);
		while ( $row = mysqli_fetch_assoc($res) )
		{
			$thumbName = $row['thumbName'];
			$imageID = $row['imageID'];
			
			echo "<div class='boxImg'>";
						
			echo "<a href='phone_image.php?imageID=$imageID'><img src='$thumbName'></a>";
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
			
			echo "<li><a href='cat_phone.php?ID=$catID'>$catName</a></li>";
		}
		
		return $description;												//skickar tillbaka description till sidan
	}
	
	
	
	mysqli_close($dbConn) ;			//stänger ner uppkopplingen till databasen -> viktigt att den inte är INUTI funktionen
?>