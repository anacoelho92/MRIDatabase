<?php

$request = $_REQUEST;
$idsubject =$request['idsubject_search'];
$min_age = $request['ageMin_search']; 
$max_age = $request['ageMax_search']; 
$sex_search = $request['sex_search'];
$min_education = $request['educationMin_search'];
$max_education = $request['educationMax_search'];
$group_search = $request['group_search']; 
$project_search = $request['project_search']; 
$scanner = $request['scanner_search'];
$scans = $request['scans_search'];
$scales = $request['scales_search'];
$biomeasures = $request['biomeasures_search'];

if(!empty($idsubject)){
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

        $sql = "SELECT * from subject WHERE idsubject = '$idsubject'";
        $result = mysqli_query($conn,$sql);

		if (mysqli_num_rows($result) > 0) {
            while ($res = mysqli_fetch_array($result)) {
            echo $res['age']. "<br/>";
          }
        } else {
          echo "
          <div class='alert alert-danger mt-3 text-center' role='alert'>
              Data not found
          </div>
          ";
        }
		
		
		$conn->close();
    }
}

?>