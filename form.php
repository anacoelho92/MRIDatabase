<!-- PHP connection to database, necessary to list categories in dropdown menus -->
<?php
	require_once('db.php');

	//Project
	$sql_project = "SELECT * FROM project";
	$project_categories = $conn->query($sql_project);
	$project_categories_search = $conn->query($sql_project);

	// Group
	$sql_group = "SELECT * FROM MRIdb.group";
	$group_categories = $conn->query($sql_group);
	$group_categories_search = $conn->query($sql_group);

	// Scanner 
	$sql_scanner = "SELECT * FROM scanner";
	$scanner_categories = $conn->query($sql_scanner);
	$scanner_categories_scan = $conn->query($sql_scanner);
	$scanner_categories_search = $conn->query($sql_scanner);

	// Scans
	$sql_scans = "SELECT * FROM scans";
	$scans_categories = $conn->query($sql_scans);
	$scans_categories_search = $conn->query($sql_scans);

	// Scales
	$sql_scales = "SELECT * FROM scales";
	$scales_categories = $conn->query($sql_scales);
	$scales_categories_search = $conn->query($sql_scales);

	// Biological Measures
	$sql_biomeasures = "SELECT * FROM biological_measures";
	$biomeasures_categories = $conn->query($sql_biomeasures);
	$biomeasures_categories_search = $conn->query($sql_biomeasures);
?>


<!DOCTYPE html>
<html>
<head>
<title>MRI Database Neuroimaging@ICVS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> 

<!-- Bootstrap CSS 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->

<!-- Sweetalert 2 CSS -->
<link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">
  	
<style>
        input:invalid {
		  border: 1px solid red;
		}

		.error {
			color:  red;
			font-size: 20px;
		}
</style>

</head>
<body>

<div class="container">
<h2>ICVS Neuroimaging MRI Database</h2>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#hometab" role="tab" data-toggle="tab">Home</a></li>

  <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">New <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#subject" role="tab" data-toggle="tab">Subject</a></li>
                <li><a href="#project" role="tab" data-toggle="tab">Project</a></li>
                <li><a href="#group" role="tab" data-toggle="tab">Group</a></li>
                <li><a href="#scanner" role="tab" data-toggle="tab">Scanner</a></li>
                <li><a href="#scan" role="tab" data-toggle="tab">Scan</a></li>
                <li><a href="#scale" role="tab" data-toggle="tab">Scale</a></li>
                <li><a href="#biomeasure" role="tab" data-toggle="tab">Biological Measure</a></li>
            </ul>
  </li>  
  <li><a href="#searchTab" role="tab" data-toggle="tab">Search</a></li>
</ul>
</li>


<!-- Tab panes -->
<div class="tab-content">

  <!-- Home Tab Pane -->
  <div class="tab-pane active" id="hometab">Write something for home tab</div>
  <!-- -->

  <!-- Subject Tab Pane -->
  <div class="tab-pane" id="subject">
	<form method="post" action="./insertSubject.php" id="subjectForm">
		<br><p><span style="color:  red;">* required field</span></p>
		
		MRI ID: <input type="text" name="idsubject" required><span class="error"> * </span>
		<br><br>
		Age: <input type="number" name="age" required><span class="error"> * </span>
		<br><br>
		Sex:
		<input type="radio" id="female" name="sex" value=0>
		<label for="female">Female</label>
		<input type="radio" id="male" name="sex" value=1>
		<label for="male">Male</label>
		<span class="error"> * </span>
		<br><br>
		Education: <input type="number" name="education" required><span class="error"> * </span>
		<br><br>

		<!-- get options from database -->
		<label for="sub_project">Project:</label>
		<select name="sub_project" id="sub_project">
			<option disabled selected value> -- Select Project -- </option>
	  		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $project_categories,MYSQLI_ASSOC)):; 
            ?>
                <option value="<?php echo $category["idproject"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["idproject"];
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
		</select><span class="error"> * </span><br><br>

		<!-- get options from database -->
		<label for="sub_group">Group:</label>
		<select name="sub_group" id="sub_group">
			<option disabled selected value> -- Select Group -- </option>
	  		<!-- <option value="CTR">Control</option>
  			<option value="OCD">Obsessive Compulsive Disorder</option> -->
  			<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $group_categories,MYSQLI_ASSOC)):; 
            ?>
                <option value="<?php echo $category["idgroup"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["description"];
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
		</select><span class="error"> * </span><br><br>
		
		Age Onset: <input type="number" name="age_onset"><br><br>
		Medication: <input type="text" name="med"><br><br>

		<label for="idscanner">Scanner:</label>
		<select name="idscanner" id="idscanner">
			<!--<optgroup label="Select Scanner">-->
			<option disabled selected value> -- Select Scanner -- </option>
			<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $scanner_categories,MYSQLI_ASSOC)):; 
            ?>
                <option value="<?php echo $category["idscanner"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["name"]." ".$category["strength"]."T ".$category["coil"]."-channel coil";
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
		</select><br><br>

		<!-- get options from database -->

        <select name="scans[]"
                id="scan-list" multiple>
                <option disabled selected value> -- Select Scans -- </option>
            </select><br><br>

		<script>
			$(document).ready(function(){
				$('#idscanner').change(function(){
					var scanner_id = $(this).val();
					$.ajax({
						url:"get_scan.php",
						method:"POST",
						data:{scannerId:scanner_id},
						dataType:"text",
						success:function(data)
						{
							$('#scan-list').html(data);
						}
					});

				});
			});
		</script>

		<!-- get options from database -->
		Scales:
		<br>
		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $scales_categories,MYSQLI_ASSOC)):; 
            ?>
            	<input type="checkbox" id="<?php echo $category["idscales"];?>" name="scales[]" value="<?php echo $category["idscales"];?>">
				<label for="<?php echo $category["idscales"];?>"><?php echo $category["name"];?></label>
				<br>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
        <br>

		<!-- get options from database -->
		Biological Measures:
		<br>
		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $biomeasures_categories,MYSQLI_ASSOC)):; 
            ?>
            	<input type="checkbox" id="<?php echo $category["idbiological_measures"];?>" name="biomeasures[]" value="<?php echo $category["idbiological_measures"];?>">
				<label for="<?php echo $category["idbiological_measures"];?>"><?php echo $category["name"];?></label>
				<br>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
        <br>

		<input type="submit" name="Submit" id="btnSubmitSub">

	</form> 
  </div>
  <!-- -->

  <!-- Project Tab Pane -->
  <div class="tab-pane" id="project">
	<form method="post" action="./insertProject.php" id="projectForm">
		<br><p><span style="color:  red;">* required field</span></p>
		Project ID: <input type="text" name="idproject" required><span class="error"> * </span><br><br>
		Description: <input type="text" name="proj_description"><br><br>
		PI: <input type="text" name="pi" required><span class="error"> * </span><br><br>
		
		<input type="submit" name="Submit" id="btnSubmitProject">
	</form>
  </div>
  <!-- -->

  <!-- Group Tab Pane -->
  <div class="tab-pane" id="group">
  	<form method="post" action="./insertGroup.php" id="groupForm">
	  	<br><p><span style="color:  red;">* required field</span></p>
		Group ID: <input type="text" name="idgroup" required><span class="error"> * </span><br><br>
		Description: <input type="text" name="description" required><span class="error"> * </span><br><br>
		
		<input type="submit" name="Submit" id="btnSubmitGroup">
	</form>
  </div>  
  <!-- -->

  <!-- Scanner Tab Pane -->
  <div class="tab-pane" id="scanner">
	 <form method="post" action="./insertScanner.php" id="scannerForm">
	 	<br><p><span style="color:  red;">* required field</span></p>
		Scanner ID: <input type="text" name="idscanner" required><span class="error"> * </span><br><br>
		Name: <input type="text" name="scanner_name" required><span class="error"> * </span><br><br>
		Strength: <input type="number" step="0.1" min=0 name="strength" required><span class="error"> * </span><br><br>
		Coil: <input type="number" name="coil" required><span class="error"> * </span><br><br>
		
		<input type="submit" name="Submit" id="btnSubmitScanner">
	</form>
  </div>
  <!-- -->

  <!-- Scan Tab Pane -->
  <div class="tab-pane" id="scan">
	<form method="post" action="./insertScan.php" id="scanForm">
		<br><p><span style="color:  red;">* required field</span></p>
		Scan ID: <input type="text" name="idscans" required><span class="error"> * </span><br><br>
		Name: <input type="text" name="scan_name" required><span class="error"> * </span><br><br>
		Resolution: <input type="text" name="resolution" required><span class="error"> * </span><br><br>
		TR (ms): <input type="number" name="tr" required><span class="error"> * </span><br><br>
		Directions (for DWI): <input type="number" name="directions"><br><br>

		<!-- get options from database -->
		<label for="scan_idscanner">Scanner ID:</label>
		<select name="scan_idscanner" id="scan_idscanner">
			<option disabled selected value> -- Select Scanner -- </option>
			<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $scanner_categories_scan,MYSQLI_ASSOC)):; 
            ?>
                <option value="<?php echo $category["idscanner"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["name"]." ".$category["strength"]."T ".$category["coil"]."-channel coil";
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
		</select><span class="error"> * </span><br><br>
		<input type="submit" name="Submit" id="btnSubmitScan">
	</form>
  </div>
  <!-- -->

  <!-- Scale Tab Pane -->
  <div class="tab-pane" id="scale">
	<form method="post" action="./insertScale.php" id="scaleForm">
		<br><p><span style="color:  red;">* required field</span></p>
		Scale ID: <input type="text" name="idscale" required><span class="error"> * </span><br><br>
		Name: <input type="text" name="name" required><span class="error"> * </span><br><br>
		
		<input type="submit" name="Submit" id="btnSubmitScale">
	</form>
  </div>
  <!-- -->

  <!-- Biological Measure Tab Pane -->
  <div class="tab-pane" id="biomeasure">
	<form method="post" action="./insertBioMeasure.php" id="bioMeasureForm">
		<br><p><span style="color:  red;">* required field</span></p>
		Biological Measure ID: <input type="text" name="idbiomeasure" required><span class="error"> * </span><br><br>
		Name: <input type="text" name="name" required><span class="error"> * </span><br><br>

		<input type="submit" name="Submit" id="btnSubmitBioMeasure">
	</form>
  </div>
  <!-- -->

<!-- Search Tab Pane -->
<div class="tab-pane" id="searchTab">
	<br>
	<form method="post" action="./searchSubject.php" id="searchSubForm">
		MRI ID: <input type="text" name="idsubject_search">
		Age range: Min <input type="number" name="ageMin_search" style="width: 4em"> Max <input type="number" name="ageMax_search" style="width: 4em">
		Sex:
		<input type="checkbox" id="female" name="sex_search" value=0>
		<label for="female">Female</label>
		<input type="checkbox" id="male" name="sex_search" value=1>
		<label for="male">Male</label>
		Education: Min <input type="number" name="educationMin_search" style="width: 4em"> Max <input type="number" name="educationMax_search" style="width: 4em"><br><br>
		Project: 
		<select name="project_search[]" multiple>
		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $project_categories_search,MYSQLI_ASSOC)):; 
            ?>
				<option value="<?php echo $category["idproject"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["idproject"];
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
        </select>

		Group: 
		<select name="group_search[]" multiple>
		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $group_categories_search,MYSQLI_ASSOC)):; 
            ?>
				<option value="<?php echo $category["idgroup"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["description"];
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
        </select><br><br>

		Scanner:
		<select name="scanner_search[]" multiple>
		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $scanner_categories_search,MYSQLI_ASSOC)):; 
            ?>
            	<option value="<?php echo $category["idscanner"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["name"]." ".$category["strength"]."T ".$category["coil"]."-channel coil";
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
        </select>

		Scans:
		<select name="scans_search[]" multiple>
		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $scans_categories_search,MYSQLI_ASSOC)):; 
            ?>
				<option value="<?php echo $category["idscans"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["name"];
                        // To show the category name to the user
                    ?>
                </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
        </select><br><br>

		Scales:
		<select name="scanner_search[]" multiple>
		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $scales_categories_search,MYSQLI_ASSOC)):; 
            ?>
				<option value="<?php echo $category["idscales"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["name"];
                        // To show the category name to the user
                    ?>
                </option>

            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
        </select>

		Biological Measures:
		<select name="scanner_search[]" multiple>
		<?php 
                // use a while loop to fetch data 
                // from the $all_categories variable 
                // and individually display as an option
                while ($category = mysqli_fetch_array(
                        $biomeasures_categories_search,MYSQLI_ASSOC)):; 
            ?>
				<option value="<?php echo $category["idbiological_measures"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $category["name"];
                        // To show the category name to the user
                    ?>
                </option>

            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
        </select><br><br>
		<input type="submit" name="search" value="Search" id="btnSubjectSearch">
	</form>
	<br><br>
	<div id="search_result"></div>

</div>

</div>


<!-- -->

<!-- Must put our javascript files here to fast the page loading -->
	
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Bootstrap JS
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<!-- Sweetalert2 JS -->
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Page Script -->
<script src="assets/js/scripts.js"></script>

</body>


</html>