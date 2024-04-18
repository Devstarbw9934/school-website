<?php 
        include("includes/header.php");
        include("includes/sidebar.php"); 
        include("../conn.php");
        $tid=$_SESSION['id'];
        $query = "SELECT * FROM subjects"; //You don't need a ; like you do in SQL
        $result = mysqli_query($conn,$query);
        $query = "SELECT * FROM classes"; //You don't need a ; like you do in SQL
        $reslt = mysqli_query($conn,$query);
        $query = "SELECT subject FROM tsubject where teacher='".$_SESSION["regno"]."'"; //You don't need a ; like you do in SQL
        $relt = mysqli_query($conn,$query);
        $tsubjects = [];
        if (mysqli_num_rows($relt) > 0) {
            while($row = mysqli_fetch_array($relt)){
                array_push($tsubjects, $row["subject"]);
            }
        }
        if(isset($_POST['SubmitButton']) && !isset($_REQUEST['id'])){ //check if form was submitted		
            $name=$_POST['name'];
            $subject=$_POST['subject'];
            $clas=$_POST['clas'];
            $time=$_POST['time'];
            //echo '<script>alert("'.$time.'")</script>';
            $ins=$_POST['instruction'];
            $sql = "INSERT INTO exams (tid, name, subject, class,ttime, ins) VALUES ('$tid','$name', '$subject', '$clas','$time', '$ins')";
            mysqli_query($conn, $sql);
            echo '<script>window.location.href="assign_video.php";</script>';
        }    

        if(isset($_POST['SubmitButton']) && isset($_REQUEST['id'])){ //check if form was submitted
            $id = $_REQUEST['id']; //get id 
            $name=$_POST['name'];
            $subject=$_POST['subject'];
            $clas=$_POST['clas'];
            $time=$_POST['time'];
            //echo '<script>alert("'.$time.'")</script>';
            $ins=$_POST['instruction'];
            $sql = "UPDATE exams SET tid='$tid', name='$name', subject='$subject', class='$clas', ttime='$time', ins='$ins' WHERE id='$id'";
            mysqli_query($conn, $sql);
            echo '<script>window.location.href="assign_video.php";</script>';
        }  
        
        if(isset($_REQUEST['id']) && !isset($_POST['SubmitButton'])){ //check if id was received and form was not submitted
            $id = $_REQUEST['id']; //get id 
			$date = date ("Y-m-d H:i:s");
			$sql = "SELECT * FROM exams WHERE id='$id'";
			$res = mysqli_query($conn, $sql);
			if ($res->num_rows > 0) {
				while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$name = $row['name'];
					$subject = $row['subject'];
                    $class =  $row['class'];
                    $ttime = $row['ttime'];
                    $ins = $row['ins'];
			}			
		}   
		
        }
        
?>
<div class="content-main" >
<div class="container-fluid">
<div class="row">
<div class="col-sm-12 col-md-12">
<h3>New Exam</h3><p>Exam creation are in three steps, in which assign students and  questions  are in different steps.</p><hr />
<div class="row q-data"><div class="col-sm-12 col-md-12 col-lg-9"><div class="portlet-body"><div class="row">
<div class="col-sm-12 col-md-12 col-lg-12"><div class="row"><div class="col-md-6 text-right"></div></div>
<div class="form-body">
<div class="step-nav">

<form class="form-horizontal" id="new_exam"  action="" accept-charset="UTF-8" method="post">
<ul class="nav nav-wizard nav-wizard-backnav">
<li class="active"><a href="#">Create Exam</a></li>
<li class="not-active"><a href="#">Assign Videos</a></li>
<li class="not-active"><a href="#">Assign Questions</a></li>
</ul><div class="tab-content" id="myTabContent"><div class="tab-pane fade active in" id="step1">
<div class="form-body"><br />
<div class="form-group">
<label class="col-md-3 control-label">Name <span class="mandatory-fld">*</span></label>
<div class="col-md-3">
<input class="form-control" placeholder="Name" value="<?php echo isset($name) ? $name: '' ;?>" required="required" maxlength="50" size="50" type="text" name="name" id="exam_name" /></div>

<label class="col-md-2 control-label">Time <span class="mandatory-fld">*</span></label>
<div class="col-md-3">
<select name="time" id=""  required  class="chosen-select form-control" >
<option disabled selected value="">- Select Time -</option>
<?php $selected = ($ttime==10) ? ' selected="selected"' : ''; ?>
<option value="10" <?php echo $selected;?>>10 Mint</option>
<?php $selected = ($ttime==20) ? ' selected="selected"' : ''; ?>
<option value="20" <?php echo $selected;?>>20 Mint</option>
<?php $selected = ($ttime==30) ? ' selected="selected"' : ''; ?>
<option value="30" <?php echo $selected;?>>30 Mint</option>
</select>
</div>

</div><br>
<div class="form-group">
<label class="col-md-3 control-label">Training <span class="mandatory-fld">*</span></label>
<div class="col-md-3">
<input name="exam[batch_course_ids][]" type="hidden" value="" />
<select name="subject" id="exam_batch_course_ids_"  required  class="chosen-select form-control" >
<option disabled selected value="">- Select Training -</option>
<?php
                    while($row = $result->fetch_assoc()){   //Creates a loop to loop through results
                            if (array_search($row['id'], $tsubjects) !==false) {
                                $selected = ($row['id']==$subject) ? ' selected="selected"' : '';
                                echo "<option value=" . $row['id']  ." ".$selected.">" . $row['subject'] . "</option>";
                            }
                        }
?>
</select>
</div>
<label class="col-md-2 control-label">Course <span class="mandatory-fld">*</span></label>
<div class="col-md-3"><input name="exam[batch_course_ids][]" type="hidden" value="" />
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
</select></div></div><br>
<div class="form-group"><label class="col-md-3 control-label">Instructions <span class="mandatory-fld">*</span></label>
<div class="col-md-8">
<textarea class="form-control exam-instruction" required id="instructions" rows="2" cols="" max="50" min="10" placeholder="Instructions" name="instruction">
<?php echo isset($ins) ? $ins: '' ;?>
</textarea></div>
</div><br>
<div class="row"><div class="col-md-12"><div class="btn-row">
<input  type="submit" value="Next" name="SubmitButton" class="btn green  vx-cust-btn btn-rgt"  ></div>
<a class="btn default vx-cust-btn" href="exams.php">Back</a>
</div>
</div>
</div></div></div></div></form></div></div></div></div></div>


</div>


</div></div></div>
</div>




</div>


</div>

<?php include("includes/footer.php"); ?>
</div>

</body></html>