<?php 
		include("includes/header.php"); 
		include("includes/sidebar.php"); 		
		include("../conn.php");
		if(isset($_POST['SubmitButton']) && !isset($_REQUEST['id'])){ //check if form was submitted		
			$input = $_POST['inputText']; //get input text
			$subject = $_POST['subject']; //get input text
			$date = date ("Y-m-d H:i:s");
			$sql = "INSERT INTO classes (class, date, subject) VALUES ('$input', '$date', '$subject')";
			mysqli_query($conn, $sql);
			mysqli_close($conn);
			echo '<script>window.location.href="courses.php";</script>';
		}

		if(isset($_POST['SubmitButton']) && isset($_REQUEST['id'])){ //check if form was submitted	
			$id = $_REQUEST['id'];	
			$input = $_POST['inputText']; //get input text
			$subject = $_POST['subject']; //get input text
			$date = date ("Y-m-d H:i:s");
			$sql = "UPDATE classes SET class='$input', date='$date', subject='$subject' WHERE id='$id'";
			mysqli_query($conn, $sql);
			mysqli_close($conn);
			echo '<script>window.location.href="courses.php";</script>';
		}

		if(isset($_REQUEST['id']) && !isset($_POST['SubmitButton'])){ //check if id was received and form was not submitted
			
			$id = $_REQUEST['id']; //get id 
			$date = date ("Y-m-d H:i:s");
			$sql = "SELECT * FROM classes WHERE id='$id'";
			$res = mysqli_query($conn, $sql);
			if ($res->num_rows > 0) {
				while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$input = $row['class'];
					$subject = $row['subject'];
			}			
		}   
		
		}
		
		
		$query = "SELECT * FROM subjects"; //You don't need a ; like you do in SQL
		$result = mysqli_query($conn,$query);
		$query = "SELECT subject FROM tsubject where teacher='".$_SESSION["regno"]."'"; //You don't need a ; like you do in SQL
        $ret = mysqli_query($conn,$query);
        $tsubjects = [];
        if (mysqli_num_rows($ret) > 0) {
            while($row = mysqli_fetch_array($ret)){
                array_push($tsubjects, $row["subject"]);
            }
        }
?>
<div class="content-main">
<div class="container-fluid"><div class="row">
<div class="col-sm-12 col-md-12">
<h3>New Course</h3><hr />
<p>A course is the entire program of studies required to complete a degree. Courses are usually on a time constraint. This is the page where you can create a course by providing a name of it.</p>
<div class="row q-data">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body">
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<form class="form-horizontal" id="new_course" action="" accept-charset="UTF-8" method="post">
<div class="form-group">
<label class="col-sm-3 control-label" for="course_name">Name</label>
<div class="col-sm-6">
<input placeholder="Course Name" value="<?php echo isset($input) ? $input: '' ;?>" class="form-control" required="required" maxlength="50" size="50" type="text" name="inputText" id="course_name" />
<div class="help-block with-errors"></div>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="course_name">Training</label>
<div class="col-sm-6">
<select class="form-control" required name="subject" >
<option disabled selected value="">- Select -</option>
<?php
					while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
						if (array_search($row['id'], $tsubjects)!==false) {	
							$subjectname = $row['id'];

							$selected = ($row['id']==$subject) ? ' selected="selected"' : '';
							echo "<option value=" . $row['id']  ." ".$selected.">" . $row['subject'] . "</option>"; 
						}
					}
				?>
</select>
</div>
</div>

<hr />
<div class="row"><div class="col-md-12">
<div class="btn-row">
<input type="submit" name="SubmitButton" value="Submit" class="btn green vx-cust-btn btn-rgt"  />
<a class="btn default vx-cust-btn" href="courses.php">Back</a></div></div></div>
</form></div></div></div></div></div></div></div></div></div></div>
<?php include("includes/footer.php"); ?>
</div>
</body></html>