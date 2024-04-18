<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");
		$query = "SELECT * FROM subjects"; //You don't need a ; like you do in SQL
		$result = mysqli_query($conn,$query);
		$query = "SELECT * FROM classes"; //You don't need a ; like you do in SQL
		$reslt = mysqli_query($conn,$query);
		$query = "SELECT subject FROM tsubject where teacher='".$_SESSION["regno"]."'"; //You don't need a ; like you do in SQL
        $ret = mysqli_query($conn,$query);
        $tsubjects = [];
        if (mysqli_num_rows($ret) > 0) {
            while($row = mysqli_fetch_array($ret)){
                array_push($tsubjects, $row["subject"]);
            }
        }
		if(isset($_POST['clas']) && isset($_POST['subject']) && !isset($_REQUEST['id'])){ 
			$fileOrder = explode('/', $_POST["fileOrder"]);
			$files = $_FILES["video"];
			$clas = $_POST['clas'];
			$targetDirectory = "assets/videos/";  // Specify the directory to save the uploaded file
			for ($i = 0; $i < count($files["name"]); $i++) {
				$originalFileName = $files["name"][$i]; // Get the original file name
				$extension = pathinfo($originalFileName, PATHINFO_EXTENSION); // Get the file extension
				$uniqueIdentifier = time() . '_' . mt_rand(1000, 9999);
				$newFileName = $uniqueIdentifier . '.' . $extension;
				$order = array_search($originalFileName, $fileOrder);
				$targetFile = $targetDirectory . $newFileName; // Get the file path
				if (move_uploaded_file($files["tmp_name"][$i], $targetFile)) {
					$sql = "INSERT INTO videos (subject, name, video, class, `order`) VALUES ('".$_POST['subject']."', '".$_POST['name']."', '$newFileName', '$clas', '$order')";
					mysqli_query($conn, $sql);
				} else {
					echo '<script>console.log("Error uploading file.");</script>';
				}
			}
			echo '<script>window.location.href="videos.php";</script>';
		}

		if(isset($_POST['clas']) && isset($_POST['subject']) && isset($_REQUEST['id'])){ 
			
			$fileOrder = explode('/', $_POST["fileOrder"]);
			$files = $_FILES["video"];
			$clas = $_POST['clas'];
			$id = $_REQUEST['id'];	
			$targetDirectory = "assets/videos/";  // Specify the directory to save the uploaded file
			for ($i = 0; $i < count($files["name"]); $i++) {
				$originalFileName = $files["name"][$i]; // Get the original file name
				$extension = pathinfo($originalFileName, PATHINFO_EXTENSION); // Get the file extension
				$uniqueIdentifier = time() . '_' . mt_rand(1000, 9999);
				$newFileName = $uniqueIdentifier . '.' . $extension;
				$order = array_search($originalFileName, $fileOrder);
				$targetFile = $targetDirectory . $newFileName; // Get the file path
				if (move_uploaded_file($files["tmp_name"][$i], $targetFile)) {
					$sql = "UPDATE videos SET subject='$_POST[subject]', name='$_POST[name]', video='$newFileName', class='$clas', `order`='$order' WHERE id='$id'";
					mysqli_query($conn, $sql);
				} else {
					echo '<script>console.log("Error uploading file.");</script>';
				}
			}
			echo '<script>window.location.href="videos.php";</script>';
		}

		if(isset($_REQUEST['id']) && !isset($_POST['SubmitButton'])){ 
			$id = $_REQUEST['id']; //get id 
			$sql = "SELECT * FROM videos WHERE id='$id'";
			$res = mysqli_query($conn, $sql);
			if ($res->num_rows > 0) {
				while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$name = $row['name'];
					$subject = $row['subject'];
					$class = $row['class'];
			}			
		}   

		}
?>
<div class="content-main">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12 col-md-12">
<h3>New Video</h3>
<p>This form helps you to upload a video and find it easily from a pool name as a subject name.</p><hr />
<div class="row q-data">
<div class="col-sm-12 col-md-12">
<div class="portlet-body">
<form class="form-horizontal" id="new_video" enctype="multipart/form-data"  action="" accept-charset="UTF-8" method="post">
<div class="row">
<div class="col-md-12">
<div class="row">

<div class="col-md-6">
<div class="form-group">

<div class="col-md-4">
<label class="name-tag control-label" >Trainings <span class="mandatory-fld">*</span></label></div>

<div class="col-md-6">
<select class="form-control" required name="subject" >
<option disabled selected value="">- Select -</option>
<?php
					while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
						if (array_search($row['id'], $tsubjects)!==false) {	
							$selected = ($row['id']==$subject) ? ' selected="selected"' : '';
							echo "<option value=" . $row['id']  ." ".$selected.">" . $row['subject'] . "</option>"; 
						}
					}
				?>
</select>
</div>

</div></div>
</div>

<div class="row">
<div class="col-md-6">
<div class="form-group">
<div class="col-md-4">
<label class="name-tag  control-label">Course <span class="mandatory-fld">*</span></label></div>
<div class="col-md-6">
<select name="clas" id="exam_batch_course_ids_"  required  class="chosen-select form-control" >
<option disabled selected value="">- Select Course -</option>
<?php
					while($row = mysqli_fetch_array($reslt)){   //Creates a loop to loop through results
						if (array_search($row['subject'], $tsubjects)!==false) {
							$selected = ($row['id']==$class) ? ' selected="selected"' : '';
							echo "<option value=" . $row['id'] ." ".$selected.">" . $row['class'] . "</option>"; 
						}
					}
?>
</select></div>
</div></div>
</div>


<div class="row">
<div class="col-md-12">
<div class="form-group">
<div class="col-md-2">
<label class="name-tag  control-label">Video Order </label></div>
<div class="col-md-10">
	<div id="sortable" class="sortable">
	</div>
</div>
</div></div>
</div>


</div></div>

<div class="row">
<div class="col-md-2">
<label class="name-tag control-label">Video Name <span class="mandatory-fld">*</span></label>
</div><div class="col-md-8">
<input type="text" placeholder="Video Name" value="<?php echo isset($name) ? $name: '' ;?>" class="form-control" name="name">
</div>
</div>
<br />
<div class="row">
<div class="col-md-2">
<label class="name-tag control-label">Select a video file <span class="mandatory-fld">*</span></label>
</div><div class="col-md-8">
<input type="file" id="fileInput" accept="video/mp4" placeholder="Video" multiple class="form-control" name="video[]">
<input type="hidden" name="fileOrder" id="fileOrder">
</div>
</div>
<br />
<div class="row">
<div class="col-md-10">
<div class="btn-row">
	<?php if(isset($_REQUEST['id'])) $button = "Update"; else $button="Create";?>
<input type="submit" name="SubmitButton" value="<?php echo $button;?>" class="btn green question-submit-btn vx-cust-btn btn-rgt" data-disable-with="Create" />
<a class="btn default vx-cust-btn" href="videos.php">Back</a>
</div></div></div><br/><br/>
</form></div></div></div></div></div></div></div></div>

<?php include("includes/footer.php"); ?>
<script>

	$( function() {
		$( "#sortable" ).sortable();
	} );
	$("#fileInput").change(function() {
		var files = $(this)[0].files;
		$( "#sortable" ).html('');

		// Display the names of selected files
		for (var i = 0; i < files.length; i++) {
			$( "#sortable" ).append("<span style='white-space: nowrap;'>"+ files[i].name +"</span>")
		}
		$( "#sortable" ).sortable();
	});
	$("#new_video").submit(async function(event) {
  		event.preventDefault(); // Prevent the default form submission
		let fileOrder = [];
		await $("#sortable span").each(function () {
			fileOrder.push($(this).text());
		});
		$("#fileOrder").val(fileOrder.join('/'));
		$("#new_video").unbind('submit').submit();
	});
  </script>
</div></body></html>