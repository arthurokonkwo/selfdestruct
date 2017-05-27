<?php

# 'testing' or 'production'. Errors are displayed in 'testing' mode.
define("MODE", "testing");
define("DATA_FOLDER", "../../messages/");

//Make the file 
function makeFile($name, $contents)
{
	if ($fh = fopen($name, 'wb')) {
		fwrite($fh, $contents); 
		fclose($fh); 
		return true; 
	}
	return false; 
}
//If file still exists 
function filesExist($files)
{
	foreach($files as $f) {
		if (!file_exists($f)) {
			return false; 
		}
	}
	return true; 
}
//Homepage HTML setup
?>
<!doctype HTML>
<html>
<head>
	<title> Self destruct  </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script type="text/javascript">
	$(function(){
		$("input:first").focus();
	});
	</script>
<!--Below it's the styling of the form -->
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<!--The headers message / logo -->
		<table id="header" border="0">
		<tr>
			<td style="width:10%;"> <h1>Self <br>Destruct</h1></td>

			<td style="width:70%;text-align:right;"> <h2>Send secured anonymous e-mails that will self-destruct after the recipient reads it.</h2> </td>
		</tr>
	</table>

	<br/>