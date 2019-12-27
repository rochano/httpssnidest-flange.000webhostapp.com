<?php
	$servername = "localhost";
	$username = "id11195342_root";
	$password = "root@1234";
	$dbname = "id11195342_bacara";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	mysqli_set_charset($conn,"utf8");
?>