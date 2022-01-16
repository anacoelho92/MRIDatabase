<?php
    require_once('db.php');
    $output='';
    $sql = "SELECT * FROM scans WHERE scanner_idscanner = '".$_POST["scannerId"]."'";
    $result = mysqli_query($conn,$sql);

    $output = '<option disabled selected value> -- Select Scans -- </option>';
    while($row = mysqli_fetch_array($result)){
        $output .= '<option value="'.$row["idscans"].'">'.$row["name"].'</option>';

    }

    echo $output;
?>
