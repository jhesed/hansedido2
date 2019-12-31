<?php

	// live
	define( 'DB_NAME', 'jsosccx1_wp393' );
	define( 'DB_USER', 'jsosccx1_wp' );
	define( 'DB_PASSWORD', '12345jsos' );
	define( 'DB_HOST', 'localhost' );

	// // local
	// define( 'DB_NAME', 'jhesedhannah' );
	// define( 'DB_USER', 'jhesedhannah' );
	// define( 'DB_PASSWORD', '12345jhesed' );
	// define( 'DB_HOST', 'localhost' );

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>