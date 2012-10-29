<?php
require_once("conn.php");

/*var_dump($_GET);
if(isset($_GET['id'])){
	echo "jaaaaa";
	echo "ID �r = " . $_GET['id'];

}


die();*/

 


$dbConn = mysqli_connect($db_hostname, $db_username, $db_password, "blogg");			//kan flyttas till conn

if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

?>
<!doctype html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
<link href='style.css' rel='stylesheet' type='text/css'>

</head>

<body>

<div id="wrapper">
	<div id="header"><h1><a href="blogg_index.php">Blogg</a></h1></div> <!-- Kommentar -->
	<div id="sidebar">
		<ul>
			<?php 
			if(isset($_GET['currentCatID']))
			{
				$catDesc = displayCategories($currentCatID); 
			}
			else
			{
				$catDesc = displayCategories(1);
			}
			?>			<!-- kallar p� funktionen displayCategories() som skriver ut menyn och skickar in $currentCatID-->
			
			<!--<li><a href="blogg_cat.php">Till framsidan</a></li>-->
		
		</ul>
	</div>
	<div id="content">
	
    	<h2>Skriv ett inlägg</h2>
        <form method="post" action="blogg_add.php" class="box">
        <p>Namn: <br><input type="text" name="namn"></p>
        <p>Inlägg:<br><textarea name="comment"></textarea></p>
		<p>Välj bloggkategori:</p>
		<p><select name="ID">
			<option value="1">Kategori 1</option>
			<option value="2">Kategori 2</option>
		</select><br>
        <input type="submit" value="Posta"></p>
        
        </form>
        
      
        
    <?php
		

if (isset($_POST['namn']))
{
	$posterName = checkInput($_POST['namn'] );
	$content = checkInput($_POST['comment'] );
	//echo $content;
	$catID = checkInput($_POST['ID']);
	
	$insertSQL = "INSERT INTO bloggPosts (posterName, content, posted, catID) VALUE ('$posterName', '$content', NOW(), $catID ) ";
	
	
	mysqli_query($dbConn, $insertSQL);
	
	writePosts();		//kallar p� funktionen writePosts
}

/**
* Skriver ut en div class box med det senaste inl�gget. 

*/
function writePosts()
	{
		global $dbConn;
		
				
		$sql = "SELECT * FROM bloggposts ORDER BY bloggID DESC LIMIT 1";		//h�mtar information fr�n databasen

		$res = mysqli_query($dbConn, $sql);
		$row = mysqli_fetch_assoc($res);
		
				
			echo "<div class='box'>"; 							//skriver ut raden med content (och divklassen)
			echo "<h3>Ditt senaste inl�gg:</h3>";
			echo "<p>".$row['content']."</p>";	
			echo "<p>Postat av ".$row['posterName']. " - " .$row['posted']."</p>";		//skriver ut namnet p� inl�ggsf�rfattaren och datumet
			echo "</div>";		

	}
		
	
mysqli_close($dbConn) ;


?>
        
        
	</div>
	<div id="footer">Layout: Maria Lind�n</div>
</div>

</body>

</html>
<?php

function checkInput($string)
{
	global $dbConn;
	$string = mysqli_real_escape_string($dbConn, $string);
	$string = htmlentities($string);
	return $string;
	
}

function displayCategories($currentCatID)
	{
		global $dbConn;														//g�r databasen tillg�nglig
		$sql = "SELECT catID, catName, catDesc FROM bloggCat";			//fr�ga till databasen
		
		$res = mysqli_query($dbConn, $sql);									//stoppar in fr�gan i $res
		
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
?>