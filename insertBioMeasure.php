<?php

$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
$idbiomeasure = $request['idbiomeasure']; 
$name = $request['name']; 

if ((empty($idbiomeasure)) || (empty($name))){
	$response = array(
							 'status_response'  => 'error',
							 'message_response' => 'Please fill in all the required fields!');
			echo json_encode($response);  
}
else{
$host = "127.0.0.1";
$dbusername = "root";
$dbpassword = "Neuroimg20";
$dbname = "MRIdb";

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
	die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
}
else{
	$sql = "INSERT INTO biological_measures (idbiological_measures, name)
	values ('$idbiomeasure','$name')";

	if ($conn->query($sql)){
		$response = array(
			'status_response'  => 'success',
			'message_response' => 'New record inserted successfuly!');
		echo json_encode($response);
	}
	else{
		$response = array(
			'status_response'  => 'error',
			'message_response' => "Error: ".$conn->error);
		echo json_encode($response);
	}
	$conn->close();
}
}

?>
