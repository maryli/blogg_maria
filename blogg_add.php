<?php
require_once("conn.php");
session_start();
	



$dbConn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);			//kan flyttas till conn

if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	
IF (isset($_FILES['filen']))
{
				
		$thumbname = createThumb();
		$image = ($_FILES['filen']['name']);
				
		$sql = "INSERT INTO gallery (thumbName, imageName) VALUES ('$thumbname', '$image' )";		//frågan till databasen
		mysqli_query($dbConn, $sql);									//skickar in frågan till databasen
   
}

?>
<!doctype html>

<html>
<head>
<title>Blogg</title>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
<link href='style.css' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>			<!-- inkluderar javascriptfilen tiny_mce.js -->	
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas"
        });
</script>

</head>

<body>

<div id="wrapper">
	
	<!--<div id="login">-->
		<?php
		
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
			
			
			/*if(isset($_SESSION['inloggad']))
			{
				if($_SESSION['inloggad'] == "japp")
				{
					echo "<a href='session_destroy.php'><input type='submit' value='Logga ut'/></a>";
					echo "<a href='blogg_add.php'><input type='submit' value='Admin'/></a>";
				}
				else
				{
					echo "Sidan kräver inloggning";
					die();
				}
			}
			else 
			{
				echo "Du måste logga in för att skriva inlägg.";
				//die();
			}*/
		?>	
	<!--</div>-->
	
	<div id="header"><h1><a href="blogg_index.php">Blogg</a></h1></div> 
	
	<div id="menu">
		<ul>
			<?php 
				if(isset($_GET['ID']))
				{
					$catDesc = displayCategories($currentCatID); 
				}
				else
				{
					$catDesc = displayCategories(1);
				}
			?>			
							
		</ul>
	</div>
	<div id="content">
	
    	<h2>Skriv ett inlägg</h2>
			<form method="post" action="blogg_add.php" class="box">
				<p>Namn: <br><input type="text" name="namn"/></p>
				<p><textarea name="comment"></textarea></p>
				<p>Välj bloggkategori:</p>
				<p><select name="ID">
					<option value="1">Kategori 1</option>
					<option value="2">Kategori 2</option>
				</select><br>
				<input type="submit" value="Posta"/></p>
        
			</form>
			
			<h3>Ladda upp en bild till bildgalleriet</h3>
			<form METHOD="post" action="blogg_add.php" enctype="multipart/form-data" class="box">
				<p><input TYPE="file" name="filen" />
				<input TYPE="submit" value="Ladda upp"/></p>
			</form>
              
     </div>  <!-- end of content div --> 
	  	<div id="footer">Layout: Maria Lindén</div>
	
</div> <!-- end of wrapper div -->

</body>

</html>
    <?php
		

if (isset($_POST['namn']))
{
	$posterName = checkInput($_POST['namn'] );			//kallar på funktionen checkInput
	$content = ($_POST['comment'] );
	$catID = checkInput($_POST['ID']);
	
	$insertSQL = "INSERT INTO bloggposts (posterName, content, posted, catID) VALUE ('$posterName', '$content', NOW(), $catID ) ";
	
	
	mysqli_query($dbConn, $insertSQL);
	
	writePosts();		//kallar på funktionen writePosts
}

/**
* Skriver ut en div class box med det senaste inlägget. 

*/
function writePosts()
	{
		global $dbConn;
		
				
		$sql = "SELECT * FROM bloggposts ORDER BY bloggID DESC LIMIT 1";		//hämtar information från databasen

		$res = mysqli_query($dbConn, $sql);
		$row = mysqli_fetch_assoc($res);
		
				
			echo "<div class='box'>"; 							//skriver ut raden med content (och divklassen)
			echo "<h3>Ditt senaste inlägg:</h3>";
			echo "<p>".$row['content']."</p>";	
			echo "<p>Postat av ".$row['posterName']. " - " .$row['posted']."</p>";		//skriver ut namnet på inläggsförfattaren och datumet
			echo "</div>";		

	}
		



function checkInput($string)
{
	global $dbConn;
	$string = mysqli_real_escape_string($dbConn, $string);
	$string = htmlentities($string);
	return $string;
	
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
		
		return $description;	
	}
	
	
	
	function createThumb()										//funktion som skapar tumnagelbilder
		{
			$image = imagecreatefromjpeg($_FILES['filen']['tmp_name']);		//hämtar tmp-filen
			$orgWidth = imagesx($image);							//räknar ut bildens bredd
			$orgHeight = imagesy($image);							//räknar ut bildens höjd
	
			$thumbWidth = ceil(($orgWidth / $orgHeight) * 150);		//ger proportionerna i bildstorleken och gångar med 150 som är den nya höjden. ceil avrundar
	
			$thumb = imagecreatetruecolor($thumbWidth, 150);		//sätter storleken på tumnagelbilden - höjden är alltid 150 px
	
			imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbWidth, 150, $orgWidth, $orgHeight);
	
			$thumbname = "thumb_" . $_FILES['filen']['name'];		//sparar bildens namn i $thumbname, samt lägger till prefixet thumb_
			imagejpeg($thumb, $thumbname, 100);						//vilken bild, namn på bilden, kvalitet på bilden
			imagedestroy($thumb);										//imagedestroy tar bort bilderna ur webbserverns minne efter ett tag
			imagedestroy($image);
			
			return $thumbname;
		}
		mysqli_close($dbConn) ;
?>