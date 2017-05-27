<?php
require 'stdlib.php';
require_once('class.phpmailer.php');
//CHECK FOR ERRORS
//error reporting
error_reporting(0);

// report simple errors on execution
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//  E_NOTICE report
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// report all errors with the exception of E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

// report all PHP errors
error_reporting(E_ALL);

// error report
error_reporting(-1);

ini_set('display_errors',1);

//setup vars
if (!empty($_POST)) {

	$recipient = $_POST['recipient'];
	$senderName = $_POST['senderName'];
	$body = addslashes($_POST['senderBody']);
	$password = $_POST['pass'];
	$hint = $_POST['passHint'];

	if (empty($body)  || empty($password)) {
		exit('Please fill in everything.');
	}

	if (!is_dir(DATA_FOLDER) && !mkdir(DATA_FOLDER)) {
		exit('Cannot create data folder.');
	}

	$docName = SHA1(uniqid());
	$docPassName = $docName.'_pass';
	$docPassHintName = $docName.'_hint';
//Modify the link below to suit your website
	$link = 'www.wonebase.com/arthur/selfdestruct/read.php?m='.$docName;

	makeFile(DATA_FOLDER . $docName, $body);
	makeFile(DATA_FOLDER . $docPassName, SHA1($password));

	if (!empty($hint)) {
		makeFile(DATA_FOLDER . $docPassHintName, htmlentities($hint));
	}

	if (!filesExist(array(DATA_FOLDER. $docName, DATA_FOLDER . $docPassName))) {
		exit("oops! Files could not be created successfully.");
	}
	//Mail subject text

	$mail             = new PHPMailer(); // defaults to using php "mail()"

$mail->SetFrom('name@yourdomain.com', $senderName);

$mail->AddReplyTo("name@yourdomain.com",$senderName);

$address = $recipient;
$mail->AddAddress($address, $senderName);

$mail->Subject    = $senderName . " sent you a message";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

//$mail->AddAttachment($uploaded_file);     // attachment
//$mail->AddAttachment($uploaded_file); // attachment

//	$subject = $senderName . " sent you a message";
//Here  it's the message that will be displayed inside the mail
	$body = "This mail got sent using a script that sends self-destructive messages.  Please keep in mind that {$senderName}'s message will delete itself "
	."after you read it: \n\n".$link . "\n\n<br><br>";
	$mail->MsgHTML($body);

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
	$messageSent = true;
}


}
//If the message got sent successfully
if (isset($messageSent)) {
	exit("Message sent successfully!<br/><br/> <a href='index.php' class='formButton'>Send another</a> ");
}
?>
<!-- The main homepage form setup -->
<form method="post" id="send" name="compose">
	<table>
		<tr>
			<td>
				<fieldset>
					<legend> Recipient Email </legend>
					<input type="text" name="recipient"/>
				</fieldset>
			</td>
			<td>
			<fieldset>
				<legend> Your Name </legend>
				<input type="text" name="senderName"/>
			</fieldset>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<fieldset>
					<legend> Password </legend>
					<input type="password" name="pass"/>
				</fieldset>
			</td>
			<td>
				<fieldset>
					<legend> Password Hint <em>(Optional)</em> </legend>
					<input type="text" name="passHint"/>
				</fieldset>
			</td>
		</tr>
	</table>
	<fieldset>
		<legend> Message </legend>
		<textarea name="senderBody"></textarea>
	</fieldset>

	<fieldset style="text-align:center;">

<a href="javascript:document.compose.submit();" class="formButton">Send Mail</a>
</fieldset>
</form>
<br/>
<br/>
<br/>
<footer></footer>

</body>
</html>