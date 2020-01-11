<?php
	// require "../../_include/php/itextmo.php";
	require "../../_include/php/engagespark.php";
	
	$file = fopen("../guest_list.csv","r");

	echo("Texting:");	
	while(! feof($file)) {
		$data = fgetcsv($file);
		$to      = $data[4];
		$user 	 = $data[1];

		if(empty($to)) {
			continue;
		}

		$message = "(hansedido) {USER}, You are invited to our wedding on February 25. Please confirm attendance via our website, http://hansedido.com before January 18. You may also check your email for more details. Thanks! - Jhesed and Hannah";
		$message = str_replace('{USER}', ucfirst($user), $message);
		echo("<br/> -");
		echo($to);
		// itexmo_curless($to, $message);
    	// itexmo_curl($to, $message);
    	engagespark_curl($to, $message);
	}

fclose($file);
?>