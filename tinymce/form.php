<!-- med hj�lp av att l�nka in f�rdiga javascript-filer f�r man en snygg och funktionell textinmatningsfunktion p� webbsidan -->

<!DOCTYPE>
<html>
<head>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>			<!-- inkluderar javascriptfilen tiny_mce.js -->	
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas"
        });
</script>
<title>Textarea</title>
</head>

<body>

	<form method="post" action="form.php">
		<textarea name="content"></textarea>
		<input type="submit" value="skicka">
	</form>
	
	<?php
		if(isset($_POST['content']))
		{
			echo "<hr>";
			echo $_POST['content'];
			echo "<hr>";
		}
	?>

</body>

</html>