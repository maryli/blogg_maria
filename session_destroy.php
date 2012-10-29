<?php
session_start();
if(session_destroy())
{
	header("Location:blogg_index.php");
}
?>