<?php

	//Get data
	$title =  $_POST["webinar-title"];
	$date =  $_POST["webinar-date"];
	$start_time =  $_POST["start-time"];
	$end_time =  $_POST["end-time"];
	
	$conn = mysqli_connect("localhost", "ohiqbhps_admin", "2J^\$eK[P9XSF", "ohiqbhps_otsukapts");
	
	if(!$conn) {
		die("Unable to connect to database: " .  mysql_error());
	}
	
	$query = "INSERT INTO 'ohiqbhps_otsukapts'.'wp_webinar_list'('title', 'date', 'start_time', 'end_time') VALUES ($title, $date, $start_time, $end_time)";
	mysqli_query($conn, $query);
	header("Location https://otsukahealthclone.eunika.xyzwebinar-survey-list/");
	
?>