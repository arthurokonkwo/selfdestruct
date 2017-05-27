<?php
require 'stdlib.php';
//Delete the message function
function deleteFiles($files)
{
	foreach($files as $f) {
		if (file_exists($f)) {
			unlink($f);
		}
	}
	return true;
}


if (!empty($_GET['m'])) {
	$docName = $_GET['m'];
//Display the message when the message don't exist anymore
	if (!file_exists(DATA_FOLDER.$docName)) {
		exit('oops! That message no longer exists. Please keep in mind that messages self-destruct '
			.'after you read them.<br/><br/><a href="index.php" class="formButton"> Back to Home </a>');
	}

	$authOK = false;
//Check for correct password
	if (!empty($_POST['password'])) {
		$password = $_POST['password'];
		$correctPassword = file_get_contents(DATA_FOLDER.$docName.'_pass');
		$loginFailed = true;

		if (SHA1($password) === $correctPassword) {
			$authOK = true;
		}
	}
//If the authorization it's passed
	if ($authOK) {
		?>
		<strong> This message will delete itself when you close or reload this page:</strong> <br/><br/>

		<div style="width:115%;line-height:200%;">
		<?php
		$data = file_get_contents(DATA_FOLDER.$docName);
		$data = htmlentities(stripslashes($data));
		echo nl2br($data);

		deleteFiles( array(
			DATA_FOLDER . $docName,
			DATA_FOLDER . $docName.'_pass',
			DATA_FOLDER . $docName.'_hint'
		));
		?>
		</div>
		<br/><a href="index.php"> &lt;&lt; Back to main page</a>

<?php exit; ?>
<?php
	} else {
		?>
		<form method="post" name="unlock">
		<?php
		$hintFile = DATA_FOLDER . $docName . '_hint';

		if (file_exists($hintFile)) {
			echo "<fieldset>"
			."<legend><strong>Password Hint:</strong></legend>".file_get_contents($hintFile)
			."</fieldset>";
		} else {
			echo "<strong>The sender didn't provide a password hint.</strong>";
		}

		echo "<br/>";

		?>

			<fieldset>
				<legend> 
					<?php
					//Wrong password 
						if (isset($loginFailed)) {
							echo "SORRY, that password is incorrect. Please try again:";
						} else {
							echo "Plese enter password to open message: ";
						}
					?>
				</legend>
				<input type="password" name="password"/>
			</fielset>
			<fieldset>
				<a href="javascript:document.unlock.submit();" class="formButton">Unlock</a>
			</fieldset>
		</form>
		<?php
	}

}
//Go back to main page
?>
<br/><a href="index.php"> &lt;&lt; return to main page</a>
</body>
</html>
