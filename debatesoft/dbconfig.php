<?php
	$servername = "localhost";
	$username = "dbsadmin";
	$password = "dbspassadmin";
	$dbname = "candebate";
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>