<?php
	$to      = 'jhesed.tacadena@gmail.com';
	$subject = "You're invited!";
	$message = 'hello';
	$headers = 'From: webmaster@example.com' . "\r\n" .
	    'Reply-To: webmaster@example.com' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $message, $headers);
?>