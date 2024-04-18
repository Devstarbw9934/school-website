<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		if(isset($_POST['SubmitButton']) && !isset($_REQUEST['id'])){ //check if form was submitted		
		$input = $_POST['inputText']; //get input text
		include("../conn.php");
		$date = date ("Y-m-d H:i:s");
		$sql = "INSERT INTO subjects (subject, date) VALUES ('$input', '$date')";
		mysqli_query($conn, $sql);
		mysqli_close($conn);
		}
		if(isset($_POST['SubmitButton']) && isset($_REQUEST['id'])){ //check if form was submitted
			$id = $_REQUEST['id'];		
			$input = $_POST['inputText']; //get input text
			include("../conn.php");
			$date = date ("Y-m-d H:i:s");
			$sql = "UPDATE subjects SET subject='$input', date='$date' WHERE id='$id'";
			mysqli_query($conn, $sql);
			mysqli_close($conn);
			echo '<script>window.location.href="subjects.php";</script>';
			}  


		if(isset($_REQUEST['id']) && !isset($_POST['SubmitButton'])){ //check if id was received and form was not submitted
			
				$id = $_REQUEST['id']; //get id 
				include("../conn.php");
				$date = date ("Y-m-d H:i:s");
				$sql = "SELECT * FROM subjects WHERE id='$id'";
				$res = mysqli_query($conn, $sql);
				if ($res->num_rows > 0) {
					while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
						$subject = $row['subject'];
				}			
			}   
			
		}			
?>
<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
<h3>New Training</h3><hr /><p>You can create a subject by filling the below form.</p>
<div class="row q-data">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body">
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<form class="form-horizontal" id="new_subject" action="" accept-charset="UTF-8" method="post">
<div class="form-group">
<label class="col-sm-3 control-label" for="subject_name">Name</label>
<div class="col-sm-6">
<input placeholder="Training Name" value="<?php echo isset($subject) ? $subject: '' ;?>" class="form-control" required="required" maxlength="50" size="50" type="text" name="inputText" id="course_name" />
<div class="help-block with-errors"></div>
</div>
</div><hr />
<div class="row"><div class="col-md-12">
<div class="btn-row">
<input type="submit" name="SubmitButton" value="Submit" class="btn green vx-cust-btn btn-rgt"  />
<a class="btn default vx-cust-btn" href="subjects.php">Back</a></div></div></div>
</form></div></div></div></div></div>
</div></div></div></div></div>
<?php include("includes/footer.php"); ?>
</div>
</body></html>