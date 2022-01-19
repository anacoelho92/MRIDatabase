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

  $sql_sub = "SELECT * from subject";
  $sql_id = "SELECT idsubject from subject";

  $andParts = array();

    // MRI ID
    if(!empty($idsubject)){
      $andParts[] = "idsubject = '$idsubject'";
    }

    // Age
    if(!empty($min_age) && !empty($max_age)){
      $andParts[] = "age BETWEEN '$min_age' AND '$max_age'";
    }
    else if(!empty($min_age) && empty($max_age)){
      $andParts[] = "age >= '$min_age'";
    }
    else if(!empty($max_age) && empty($min_age)){
      $andParts[] = "age <= '$max_age'";
    }
    

    // Sex
    if(!empty($sex_search)){
      if (sizeof($sex_search)==1){
        foreach($sex_search as $item)
        {
            $andParts[] = "sex = '$item'";
        }
      }
    }

    // Education
    if(!empty($min_education) && !empty($max_education)){
      $andParts[] = "education BETWEEN '$min_education' AND '$max_education'";
    }
    else if(!empty($min_education) && empty($max_education)){
      $andParts[] = "education >= '$min_education'";
    }
    else if(!empty($max_education) && empty($min_education)){
      $andParts[] = "education <= '$max_education'";
    }
    

    // Group
    $group_query='';
    if(!empty($group_search)){
      if (sizeof($group_search)>1){
        foreach($group_search as $key=>$item)
        {
          if($key==0){
            $group_query.="(group_idgroup = '$item' OR ";
          }
          else if($key==(sizeof($group_search)-1)){
            $group_query.="group_idgroup = '$item')";
          }
          else{
            $group_query.="group_idgroup = '$item' OR ";
          }
        }
      }else{
        foreach($group_search as $item)
        {
            $group_query.="group_idgroup = '$item'";
        }
      }

      $andParts[] = $group_query;
    }

    // Project
    $project_query='';
    if(!empty($project_search)){
      if (sizeof($project_search)>1){
        foreach($project_search as $key=>$item)
        {
          if($key==0){
            $project_query.="(project_idproject = '$item' OR ";
          }
          else if($key==(sizeof($project_search)-1)){
            $project_query.="project_idproject = '$item')";
          }
          else{
            $project_query.="project_idproject = '$item' OR ";
          }
        }
      }else{
        foreach($project_search as $item)
        {
            $project_query.="project_idproject = '$item'";
        }
      }

      $andParts[] = $project_query;
    }

    if (!empty($andParts)){
      $sql_sub .= " WHERE ".implode(" AND " , $andParts);
      $sql_id .= " WHERE ".implode(" AND " , $andParts);
    }

    // Scanner
    $scanner_query='';
    if(!empty($scanner)){
      if (sizeof($scanner)>1){
        foreach($scanner as $key=>$item)
        {
          if($key==0){
            $scanner_query.="WHERE (scans_scanner_idscanner = '$item' OR ";
          }
          else if($key==(sizeof($scanner)-1)){
            $scanner_query.="scans_scanner_idscanner = '$item')";
          }
          else{
            $scanner_query.="scans_scanner_idscanner = '$item' OR ";
          }
        }
      }else{
        foreach($scanner as $item)
        {
            $scanner_query.="WHERE scans_scanner_idscanner = '$item'";
        }
      }
      
    }

    // Scans
    $scans_query='';
    if(!empty($scans)){
      $str=" WHERE ";

      if (sizeof($scans)>1){
        foreach($scans as $key=>$item)
        {
          if($key==0){
            $scans_query.= $str." (scans LIKE '%".$item."(%' OR ";
          }
          else if($key==(sizeof($scans)-1)){
            $scans_query.="scans LIKE '%".$item."(%')";
          }
          else{
            $scans_query.="(scans LIKE '%".$item."(%' OR ";
          }
        }
      }else{
        foreach($scans as $item)
        {
            $scans_query.=$str." scans LIKE '%".$item."(%'";
        }
      }
    }

    // Scales
    $scales_query='';
    if(!empty($scales)){

      if(empty($scanner)){
        $str="WHERE";
      }
      else{
        $str=" AND ";
      }

      if (sizeof($scales)>1){
        foreach($scales as $key=>$item)
        {
          if($key==0){
            $scales_query.= $str." (C.scales LIKE '%".$item."(%' OR ";
          }
          else if($key==(sizeof($scales)-1)){
            $scales_query.="C.scales LIKE '%".$item."(%')";
          }
          else{
            $scales_query.="(C.scales LIKE '%".$item."(%' OR ";
          }
        }
      }else{
        foreach($scales as $item)
        {
            $scales_query.=$str." C.scales LIKE '%".$item."(%'";
        }
      }
    }

    // Biological Measures
    $biomeasures_query='';
    if(!empty($biomeasures)){

      if(empty($scanner) && empty($scales)){
        $str="WHERE";
      }
      else{
        $str=" AND ";
      }
      
      if (sizeof($biomeasures)>1){
        foreach($biomeasures as $key=>$item)
        {
          if($key==0){
            $biomeasures_query.=$str." (D.biomeasures LIKE '%".$item."(%' OR ";
          }
          else if($key==(sizeof($biomeasures)-1)){
            $biomeasures_query.="D.biomeasures LIKE '%".$item."(%')";
          }
          else{
            $biomeasures_query.="D.biomeasures LIKE '%".$item."(%' OR ";
          }
        }
      }else{
        foreach($biomeasures as $item)
        {
            $biomeasures_query.=$str." D.biomeasures LIKE '%".$item."(%'";
        }
      }
    }

    // Build Query
    $sql =  "SELECT * FROM (SELECT B.idsubject idsubject, A.scans_scanner_idscanner scanner, GROUP_CONCAT(A.count SEPARATOR ' , ') AS scans, 
      B.age age, B.sex sex, B.education ed, B.project_idproject proj, B.group_idgroup grp, C.scales scales, D.biomeasures biomeasures
      FROM 
      (SELECT subject_idsubject, scans_scanner_idscanner, CONCAT(scans_idscans, '(', count(scans_idscans), ')') AS count 
          FROM subject_has_scans GROUP BY subject_idsubject, scans_scanner_idscanner, scans_idscans) A 
          RIGHT JOIN (".$sql_sub.") B ON A.subject_idsubject = B.idsubject 
          LEFT JOIN 
        (SELECT s.subject_idsubject, GROUP_CONCAT(s.count SEPARATOR ' , ') scales
        FROM
         (SELECT subject_idsubject, CONCAT(scales_idscales, '(', count(scales_idscales), ')') AS count     
        FROM subject_has_scales
        GROUP BY subject_idsubject, scales_idscales) s
      GROUP BY s.subject_idsubject) C ON B.idsubject = C.subject_idsubject 
          LEFT JOIN
        (SELECT bm.subject_idsubject, GROUP_CONCAT(bm.count SEPARATOR ' , ') biomeasures
        FROM
         (SELECT subject_idsubject, CONCAT(biological_measures_idbiological_measures, '(', count(biological_measures_idbiological_measures), ')') AS count     
        FROM subject_has_biological_measures
        GROUP BY subject_idsubject, biological_measures_idbiological_measures) bm
      GROUP BY bm.subject_idsubject) D ON B.idsubject = D.subject_idsubject 
      ".$scanner_query." ".$scales_query." ".$biomeasures_query." 
      GROUP BY B.idsubject, A.scans_scanner_idscanner,B.age, B.sex, B.education, B.project_idproject, B.group_idgroup, C.scales, D.biomeasures) AS innerTable ".$scans_query."";

     $result = mysqli_query($conn,$sql);

     if (mysqli_num_rows($result) > 0) {
      while ($res = mysqli_fetch_array($result)) {
        $msg.="<tr><td>".$res['idsubject']."</td><td>".$res['age']."</td><td>".$res['sex']."</td><td>".$res['ed']."</td><td>".$res['proj'].
        "</td><td>".$res['grp']."</td><td>".$res['scanner']."</td><td>".$res['scans']."</td><td>".$res['scales']."</td><td>".$res['biomeasures']."</td></tr>";
      }   

      $response = array(
        'status_response'  => 'success',
        'message_response' => $msg);
      echo json_encode($response);	
  
      } else {
      $response = array(
        'status_response'  => 'error',
        'message_response' => "No data found!");
      echo json_encode($response);  
    } 
  
 
  $conn->close();

}


?>