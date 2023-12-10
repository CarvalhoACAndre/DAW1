<?php
	//this is the App configuration file, where all relevant parameters are defined.
	
	//validation parameters
	$minUsername = 4;
	$maxUsername = 32;
	$minPassword = 6;
	$maxPassword = 48;
	
	//database parameters
	$dbHost = "localhost";
	$dbUsername = "root";
	$dbPassword = "cm";
	$dbName = "trabalho_prat";
	
	
	//pages that can be viewed without authentication - add more if needed.
	$pages = array('index','registerForm','loginForm', );
?>