<?php include("includes/header.php"); 
		include("includes/sidebar.php"); 
		$sid=$_SESSION['idhotel'];
		$show=0;
		include("../conn.php");
		if(isset($_REQUEST['class']) && isset($_REQUEST['subj']) && isset($_REQUEST['std'])){

		//$update_query =  "UPDATE results SET marks='40', per='40' WHERE class='2' AND subject='2' AND sid='student'";	
		//echo $update_query;
		//$result = mysqli_query($conn,$update_query);	
		//echo $result;


			$show=1;
		$class=$_REQUEST['class'];
        
		$subj=$_REQUEST['subj'];
        
		$std=$_REQUEST['std'];
        
		$query = "SELECT results.*,students.* FROM results 
		join students on students.name = results.sid
		WHERE results.class='$class' OR results.subject='$subj' OR results.sid='$std'"; //You don't need a ; like 
        $result = mysqli_query($conn,$query);
        
		}

        if(isset($_POST['SubmitButton']) &&  isset($_REQUEST['class']) && isset($_REQUEST['subj']) && isset($_REQUEST['std'])){
			$show=1;
		$class=$_REQUEST['class'];
		$subj=$_REQUEST['subj'];
		$std=$_REQUEST['std'];
		$query = "SELECT results.*,students.* FROM results 
		join students on students.name = results.sid
		WHERE results.class='$class' OR results.subject='$subj' OR results.sid='$std'"; //You don't need a ; like 
        $result = mysqli_query($conn,$query);
		$count = 0;
        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
            $class=$_REQUEST['class'];
		    $subj=$_REQUEST['subj'];
		    $std=$_REQUEST['std'];
			$row_sid = $row['sid'];
			$row_id = $row['id'];
			if(($class == 0 ||  $row['class']== $class) && ($subj == 0 || $row['subject'] == $subj) && ($std == 0 || $row['id']==$std)){
				$stdmarks = $_POST['stdmarks'];
				
				$stdmarks_val = $stdmarks[$count];
				
				if($stdmarks_val == "")
				{
					$stdmarks_val = 0;
				}
            	$stdper = $_POST['stdper'];
				
				
				$stdper_val = $stdper[$count];
				
				if($stdper_val == "")
				{
					$stdper_val = 0;
				}
				$count = $count + 1;
			
				$update_query = "UPDATE results SET marks='$stdmarks_val', per='$stdper_val' WHERE class = '$class' AND subject = '$subj' AND sid='$row_sid'";
			
			    $rst = mysqli_query($conn, $update_query);
				
				
				

			}

        }

		//mysqli_close($conn);
        //echo '<script>window.location.href="result.php";</script>';    

		}

		$query = "SELECT * FROM classes"; 
		$reslt = mysqli_query($conn,$query);
		
		$qry = "SELECT * FROM subjects"; 
		$res = mysqli_query($conn,$qry);
		
		$q = "SELECT * FROM students"; 
		$re = mysqli_query($conn,$q);
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
<h3>Exam Results</h3><hr/>
<form class="form-horizontal" id="new_exam"  action="" accept-charset="UTF-8" method="post">
<div class="col-md-3">
<select name="subj" id="exam_batch_subj_ids_"   class="chosen-select form-control" >
<option  selected value="0">- Select Training -</option>
<?php

					while($r = mysqli_fetch_array($res)){   //Creates a loop to loop through results
                        
						//if (array_search($r['id'], $tsubjects)!==false) {	
                            $selected = ($r['id']==$class) ? ' selected="selected"' : '';
							echo "<option value=" . $r['id'] ." ".$selected.">" . $r['subject'] . "</option>"; 
						//}
					}
?>
</select></div>
<div class="col-md-3">
<select name="clas" id="exam_batch_course_ids_"   class="chosen-select form-control" >
<option selected value="">- Select Course -</option>
<?php
					while($row = mysqli_fetch_array($reslt)){   //Creates a loop to loop through results
						//if (array_search($row['subject'], $tsubjects)!==false) {
                            $selected = ($row['id']==$subj) ? ' selected="selected"' : '';	
							echo "<option value=" . $row['id'] ." ".$selected.">" . $row['class'] . "</option>";
						//}
					}
?>
</select></div>
<div class="col-md-3">
<select name="std" id="exam_batch_std_ids_"   class="chosen-select form-control" >
<option  selected value="0">- Select Student -</option>
<?php
					while($r = mysqli_fetch_array($re)){   //Creates a loop to loop through results
                        $selected = ($r['id']==$std) ? ' selected="selected"' : '';	
							echo "<option value=" . $r['id'] ." ".$selected.">" . $r['name'] . "</option>"; 
						}
?>
</select></div>
<div class="row">
<div class="col-md-12"><div class="btn-row">
<input  type="submit" value="Next" name="NextButton" class="btn green  vx-cust-btn btn-rgt"  >
<a class="btn default vx-cust-btn" href="result.php">Back</a>
</div>
</div>
</div>
</form>

<form class="form-horizontal" id="edit_result"  action="" accept-charset="UTF-8" method="post">
<div class="row">
<div class="col-md-12" id="printableTable">
<div class="table-responsive"><table id="exportTable" class="table table-hover sortable"><thead><tr><th>Mil No.</th><th>Student ID</th><th>Rank</th><th>Unit</th><th>Telephone</th><th>Exam Name</th><th>Training</th>
<th>Marks</th><th>Percentage</th><th>Status</th></tr></thead>
<tbody>
<?php               if($show==1)
					while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results

						if(($class == 0 ||  $row['class']== $class) && ($subj == 0 || $row['subject'] == $subj) && ($std == 0 || $row['id']==$std))
							{
							echo "<tr><td>" . $row['regno'] . "</td><td>" . $row['sid'] . "</td>
							<td>" . $row['rank'] . "</td>
							<td>" . $row['unit'] . "</td>
							<td>" . $row['telephone'] . "</td>
							<td>" . $row['tname'] . "</td><td>";
							$querys ="select * from subjects where id ='".$row['subject']."'";
							$results = mysqli_query($conn,$querys);
							while($rows = mysqli_fetch_array($results)){
								echo $rows['subject'];
							}
                            
							echo "</td><td><input name=\"stdmarks[]\" type=\"number\" class=\"form-control small text-wide-150\" value=" . $row['marks'] . "></td>
							<td><input name=\"stdper[]\" type=\"number\" class=\"form-control small text-wide-150\" value=" . $row['per'] . "></td><td>" . $row['status'] . "</td></tr>";
							}
						}
				?>
</tbody></table>
<div class="row">
<div class="col-md-12"><div class="btn-row">
<input  type="submit" value="Submit" name="SubmitButton" class="btn green  vx-cust-btn btn-rgt"  >
</div>
</div>

</div>


</form>
<div class="text-right"></div></div></div></div></div></div></div></div></div></div></div></div></div>
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
<script>
	    function printDiv() {
         window.frames["print_frame"].document.body.innerHTML = document.getElementById("printableTable").innerHTML;
         window.frames["print_frame"].window.focus();
         window.frames["print_frame"].window.print();
       }

</script>
<?php include("includes/footer.php"); ?>
</div>
<script type="text/javascript" src="../assets/js/xlsx.full.min.js"></script>
<script>
	function exportToExcel() {
		const type="xlsx";
		var data = document.getElementById('exportTable');
		var excelFile = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
		XLSX.write(excelFile, { bookType: type, bookSST: true, type: 'base64' });
		XLSX.writeFile(excelFile, 'Export.' + type);
	}
</script>
</body></html>