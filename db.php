<?php
	$conn = new mysqli('127.0.0.1', 'root', 'Neuroimg20', 'MRIdb');
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>
