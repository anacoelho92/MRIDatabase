<?php

$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
$idsubject = $request['idsubject']; 
$age = $request['age']; 
$sex = $request['sex'];
$education = $request['education'];
$group = $request['sub_group']; 
$project = $request['sub_project']; 
$age_onset = $request['age_onset'];
$med = $request['med'];
$idscanner = $request['idscanner'];
$scans = $request['scans'];
$scales = $request['scales'];
$biomeasures = $request['biomeasures'];

if ((empty($idsubject)) || (empty($age)) || (empty($sex)) || (empty($education)) || (empty($project)) || (empty($group))){
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

	// checkbox queries (scans, scales, biological measures)
	//scans
	$scans_query='';
	if (!empty($scans)){
		foreach($scans as $item)
		{
		    // echo $item . "<br>";
		     $scans_query .= "INSERT INTO subject_has_scans (subject_idsubject,scans_idscans, scans_scanner_idscanner) VALUES ('$idsubject','$item','$idscanner');";
		}
	}
		    
	// scales
	$scales_query='';
	if (!empty($scales)){
		foreach($scales as $item)
	{
	    // echo $item . "<br>";
	    $scales_query .= "INSERT INTO subject_has_scales (subject_idsubject,scales_idscales) VALUES ('$idsubject','$item');";
	}
	}
	
	// biological measures	    
	$biomeasures_query='';
	if (!empty($biomeasures)){
		foreach($biomeasures as $item)
	    {
	        // echo $item . "<br>";
	        $biomeasures_query .= "INSERT INTO subject_has_biological_measures (subject_idsubject,biological_measures_idbiological_measures) VALUES ('$idsubject','$item');";
	    }
	}
		    
	$checkbox_queries = $scans_query.$scales_query.$biomeasures_query;
	 //echo $checkbox_queries;

	if ((!empty($age_onset)) && (!empty($med))){
	
		$sql_sub = "INSERT INTO subject (idsubject, age, sex, education, age_onset, medication, group_idgroup, project_idproject)
			values ('$idsubject','$age', '$sex', '$education', '$age_onset','$med','$group', '$project')";

		$sql = $sql_sub.";".$checkbox_queries;

		if ($conn->multi_query($sql)){

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
	elseif ((!empty($age_onset)) && (empty($med))){
		$sql_sub = "INSERT INTO subject (idsubject, age, sex, education, age_onset, group_idgroup, project_idproject)
			values ('$idsubject','$age', '$sex', '$education', '$age_onset','$group', '$project')";

		$sql = $sql_sub.";".$checkbox_queries;

			if ($conn->multi_query($sql)){

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
	elseif ((empty($age_onset)) && (!empty($med))){
		$sql_sub = "INSERT INTO subject (idsubject, age, sex, education, medication, group_idgroup, project_idproject)
			values ('$idsubject','$age', '$sex', '$education', '$med','$group', '$project')";

		$sql = $sql_sub.";".$checkbox_queries;

			if ($conn->multi_query($sql)){

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
	else{
		$sql_sub = "INSERT INTO subject (idsubject, age, sex, education, group_idgroup, project_idproject)
			values ('$idsubject','$age', '$sex', '$education','$group', '$project')";

		$sql = $sql_sub.";".$checkbox_queries;

			if ($conn->multi_query($sql)){

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
}

/*
else{

	$response = array(
                                 'status_response'  => 'error',
                                 'message_response' => 'MRI ID should not be empty!');
                echo json_encode($response);     
}*/

?>
