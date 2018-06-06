<?php
	$servername = "localhost";
	$username = "dbsadmin";
	$password = "dbspassadmin";
	$dbname = "attempt1";
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>