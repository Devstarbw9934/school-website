<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");
		$query = "SELECT * FROM subjects"; //You don't need a ; like you do in SQL
		$result = mysqli_query($conn,$query);
  		if(isset($_POST['SubmitButton']) && !isset($_REQUEST['id'])){ 
			$isarabic = 'n';
			if(isset($_POST['is_arabic']) && $_POST['is_arabic'] == 'on') {
				$isarabic = 'y';
			}
		$sql = "INSERT INTO questions (subject, marks, question, opt1, opt2, opt3, opt4, ans, hint, is_arabic) VALUES ('$_POST[subject]', '$_POST[marks]', '$_POST[question]', '$_POST[opt1]', '$_POST[opt2]', '$_POST[opt3]', '$_POST[opt4]', '$_POST[ans]', '$_POST[hint]', '$isarabic')";
		mysqli_query($conn, $sql);
		echo '<script>window.location.href="questions.php";</script>';
		}	
		if(isset($_POST['SubmitButton']) && isset($_REQUEST['id'])){ 
			$id = $_REQUEST['id']; //get id 
			$isarabic = 'n';
			if(isset($_POST['is_arabic']) && $_POST['is_arabic'] == 'on') {
				$isarabic = 'y';
			}
		$sql = "UPDATE questions SET subject='$_POST[subject]', marks='$_POST[marks]', question='$_POST[question]', opt1='$_POST[opt1]', opt2='$_POST[opt2]', opt3='$_POST[opt3]', opt4='$_POST[opt4]', ans='$_POST[ans]', hint='$_POST[hint]', is_arabic='$isarabic' WHERE id='$id'";
		mysqli_query($conn, $sql);
		mysqli_close($conn);
		echo '<script>window.location.href="questions.php";</script>';
		}
		if(isset($_REQUEST['id']) && !isset($_POST['SubmitButton'])){ //check if id was received and form was not submitted
			
			$id = $_REQUEST['id']; //get id 
			$date = date ("Y-m-d H:i:s");
			$sql = "SELECT * FROM questions WHERE id='$id'";
			$res = mysqli_query($conn, $sql);
			if ($res->num_rows > 0) {
				while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$subject = $row['subject'];
					$marks = $row['marks'];
					$question = $row['question'];
					$opt1 = $row['opt1'];
					$opt2 = $row['opt2'];
					$opt3 = $row['opt3'];
					$opt4 = $row['opt4'];
					$ans = $row['ans'];
					$hint = $row['hint'];
					$is_arabic = $row['is_arabic'];
			}			
		}   
		
		}	
?>
<style>
	.arabic {
		direction: rtl;
	}
</style>
<div class="content-main">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12 col-md-12">
<h3>New Question</h3>
<p>This form helps you to create a question and find it easily from a pool name as a subject name.</p><hr />
<div class="row q-data">
<div class="col-sm-12 col-md-12">
<div class="portlet-body">
<form class="form-horizontal" id="new_question"  action="" accept-charset="UTF-8" method="post">
<div class="row">
<div class="col-md-12">
<div class="row">
<div class="col-md-5">
<div class="form-group">
<div class="col-md-5">
<label class="name-tag control-label" >Trainings</label></div>
<div class="col-md-6">
<select class="form-control" required name="subject" >
<option disabled selected value="">- Select -</option>
<?php
					while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
							$subjectname = $row['subject'];
							$selected = ($row['id']==$subject) ? ' selected="selected"' : '';
							echo "<option value=" . $row['id']  ." ".$selected.">" . $subjectname . "</option>"; 
						}
				?>
</select>
</div></div></div>
<div class="col-md-5">
<div class="form-group">
<div class="col-md-2">
<label class="name-tag control-label" for="question_mark">Marks</label>
</div>
<div class="col-md-8">
<input placeholder="Mark"  value="<?php echo isset($marks) ? $marks: '' ;?>" class="form-control small text-wide-150" required="required" step="1" min="1" max="5" type="number" name="marks" id="question_mark" />
</div></div><br />
</div></div></div></div>
<div class="form-group">
<div class="col-md-2">
<label class="name-tag control-label" for="is_arabic">Is Arabic</label>
</div>
<div class="col-md-8" style="display:flex;align-items:center;height: 27px;">
<input class="bootstrap-switch" type="checkbox" name="is_arabic" id="is_arabic" <?php if(isset($is_arabic)) if($is_arabic == 'y') echo "checked = 'checked'"; ?>/>
</div></div><br />
<div class="row">
<div class="col-md-2">
<label class="name-tag" for="question_question_languages_attributes_0_description">Description</label>
<a data-target="#editor-help-modal" data-toggle="modal" class="q-type-icon" href="#">
<i class="fa fa-exclamation-circle blue fa-1x" data-placement="right" data-toggle="tooltip" data-original-title="Question Here"></i></a>
</div>
<div class="col-md-9">
<textarea rows="10" cols="80" class="form-control" id="question-description" name="question">
<?php echo isset($question) ? $question: '' ;?>
</textarea>
</div>
</div>
<br />
<div class="row">
<div class="col-md-12">
<div class="row">
<div class="col-md-2">
<label class="name-tag control-label" for="question_exam_mode_id">Answer Options</label></div>
<div class="col-md-5">
<div class="form-group">
<div class="col-md-9">
<textarea placeholder="Answer Option 1"  cols="40" class="form-control ckbasic ans-fill" required="required" name="opt1" >
<?php echo isset($opt1) ? $opt1: '' ;?>
</textarea>
</div></div>
</div>
<div class="col-md-5">
<div class="form-group ">
<div class="col-md-9">
<textarea placeholder="Answer Option 2" cols="40" class="form-control ckbasic ans-fill" required="required" name="opt2" >
<?php echo isset($opt2) ? $opt2: '' ;?>
</textarea></div></div><br />
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-5">
<div class="form-group">
<div class="col-md-9">
<textarea placeholder="Answer Option 3" cols="40" class="form-control ckbasic ans-fill" required="required" name="opt3" >
<?php echo isset($opt3) ? $opt3: '' ;?>
</textarea>
</div></div>
</div>
<div class="col-md-5">
<div class="form-group ">
<div class="col-md-9">
<textarea placeholder="Answer Option 4" cols="40" class="form-control ckbasic ans-fill" required="required" name="opt4">
<?php echo isset($opt4) ? $opt4: '' ;?>
</textarea></div></div><br />
</div>
</div>
<br />
<div class="row">
<div class="col-md-2">
<label class="name-tag">Correct Answer</label>
</div><div class="col-md-8">
<textarea placeholder="ans" rows="3" class="form-control" name="ans"><?php echo isset($ans) ? $ans: '' ;?>
</textarea>
</div>
</div>
<br />
<div class="row">
<div class="col-md-2">
<label class="name-tag">Hint</label>
</div><div class="col-md-8">
<textarea placeholder="Hint" rows="3" class="form-control" name="hint"><?php echo isset($hint) ? $hint: '' ;?>
</textarea>
</div>
</div>
<br />
<div class="row">
<div class="col-md-10">
<div class="btn-row">
	<?php if(isset($_REQUEST['id'])) $button = "Update"; else $button="Create";?>
<input type="submit" name="SubmitButton" value="<?php echo $button;?>" class="btn green question-submit-btn vx-cust-btn btn-rgt" data-disable-with="Create" />
<a class="btn default vx-cust-btn" href="questions.php">Back</a>
</div></div></div><br/><br/>
</form></div></div></div></div></div></div></div></div>

<?php include("includes/footer.php"); ?>
<script>
	$(document).ready(function() {
		$("#is_arabic").prop("checked") == true ? $("textarea").addClass("arabic"): $("textarea").removeClass("arabic");
		$(document).on("change", "#is_arabic", function () {
			if ($(this).prop("checked")) {
				$("textarea").addClass("arabic");
			} else {
				$("textarea").removeClass("arabic");
			}
		});
	});
</script>

</div></body></html>