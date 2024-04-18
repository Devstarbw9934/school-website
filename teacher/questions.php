<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");
		$show=0;
		if(isset($_POST['SubmitButton'])){
			$show=1;
		$subject=$_POST['subject'];
		$query = "SELECT * FROM questions WHERE subject='$subject'"; //You don't need a ; like you do in SQL
		$result = mysqli_query($conn,$query);
		}
	
		if(isset($_POST['delete_id'])){ 
		$id = $_POST['delete_id'];
		$query = "delete from questions where ID = $id";		
		mysqli_query($conn, $query);
		 echo '<script>window.location.href="questions.php";</script>';
		}
		$i=0;
		$query = "SELECT * FROM subjects"; //You don't need a ; like you do in SQL
		$reslt = mysqli_query($conn,$query);
		$query = "SELECT subject FROM tsubject where teacher='".$_SESSION["regno"]."'"; //You don't need a ; like you do in SQL
        $ret = mysqli_query($conn,$query);
        $tsubjects = [];
        if (mysqli_num_rows($ret) > 0) {
            while($row = mysqli_fetch_array($ret)){
                array_push($tsubjects, $row["subject"]);
            }
        }
?>
<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
 <h3>Questions</h3><hr />
<form class="form-horizontal" id="new_exam"  action="" accept-charset="UTF-8" method="post">
<label class="col-md-2 control-label">Training <span class="mandatory-fld">*</span></label>
<div class="col-md-3"><input name="exam[batch_course_ids][]" type="hidden" value="" />
<select name="subject" id="exam_batch_course_ids_"  required  class="chosen-select form-control" >
<option disabled selected value="">- Select Training -</option>
<?php
					while($row = mysqli_fetch_array($reslt)){   //Creates a loop to loop through results
						if (array_search($row['id'], $tsubjects)!==false) {	
							echo "<option value=" . $row['id']  .">" . $row['subject'] . "</option>"; 
						}
					}
?>
</select></div>
<div class="row"><div class="col-md-12"><div class="btn-row">
<input  type="submit" value="Next" name="SubmitButton" class="btn green  vx-cust-btn btn-rgt"  ></div>
</div>
</div>
</form>
 <div class="row q-data"><div class="col-sm-12 col-md-12 col-lg-12"><div class="portlet-body">
<div class="row"><div class="col-md-12 text-right">
<div class="new-link"><a class="btn btn-success" href="new_question.php"><i class="fa fa-plus add" data-toggle="tooltip"></i>New Question</a></div>
</div></div><div class="row">
<div class="col-sm-12 col-md-12 col-lg-12"><div class="row">
<div class="col-md-12"><div class="table-responsive">
<table class="table table-hover sortable"><thead>
<tr>
<th>ID</th>
<th>Question</th>
<th>Marks</th>
<th>Training</th>
<th>Actions</th>
</tr></thead>
<tbody>
<?php
					 if($show==1)
					while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
							$i++;
							if ($row['is_arabic'] == 'n') {
								echo "<tr><td>" . $i . "</td><td>" . $row['question'] . "</td><td>" . $row['marks'] . "</td><td>";
								$querys ="select * from subjects where id ='".$row['subject']."'";
								$results = mysqli_query($conn,$querys);
								while($rows = mysqli_fetch_array($results)){
									echo $rows['subject'];
								}
								echo "</td><td><div class='field-actions'><div class='btn-group'>
								<form action='questions.php' method='post'>
								<a class='btn btn-primary' href='new_question.php?id=" .$row['id'] . "'><i class='fa fa-plus edit' data-toggle='tooltip'></i>Edit</a>
								<button   name='delete_id' value=" .$row['id'] . " type='submit' class='btn btn-danger'  type='button'>Delete</button></div></div></td></form></tr>";  //$row['index'] the index here is a field name
							} else {
								echo "<tr><td>" . $i . "</td><td style='direction:rtl;'>" . $row['question'] . "</td><td>" . $row['marks'] . "</td><td>";
								$querys ="select * from subjects where id ='".$row['subject']."'";
								$results = mysqli_query($conn,$querys);
								while($rows = mysqli_fetch_array($results)){
									echo $rows['subject'];
								}
								echo "</td><td><div class='field-actions'><div class='btn-group'>
								<form action='questions.php' method='post'>
								<a class='btn btn-primary' href='new_question.php?id=" .$row['id'] . "'><i class='fa fa-plus edit' data-toggle='tooltip'></i>Edit</a>
								<button   name='delete_id' value=" .$row['id'] . " type='submit' class='btn btn-danger'  type='button'>Delete</button></div></div></td></form></tr>";  //$row['index'] the index here is a field name
							}
						}
				?>
</tbody></table></div><div class="row"><div class="col-md-12 text-right"></div></div></div></div></div></div></div></div></div></div></div></div></div></div>
<?php include("includes/footer.php"); ?>
</div></body></html>