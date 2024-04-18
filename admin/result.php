<?php include("includes/header.php"); 
		include("includes/sidebar.php"); 
		$sid=$_SESSION['idhotel'];
		$show=0;
		include("../conn.php");
		if(isset($_POST['SubmitButton'])){
			$show=1;
		$class=$_POST['clas'];
		$subj=$_POST['subj'];
		$std=$_POST['std'];
		$query = "SELECT DISTINCT results.*,students.* FROM results 
		join students on students.name = results.sid
		WHERE results.class='$class' OR results.subject='$subj' OR results.sid='$std'"; //You don't need a ; like 
		$result = mysqli_query($conn,$query);
		}
		$query = "SELECT * FROM classes"; 
		$reslt = mysqli_query($conn,$query);
		
		$qry = "SELECT * FROM subjects"; 
		$res = mysqli_query($conn,$qry);
		
		$q = "SELECT * FROM students"; 
		$re = mysqli_query($conn,$q);
		
		?>
<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
<?php echo $sid ?>
<h3>Exam Results</h3><hr/>
<form class="form-horizontal" id="new_exam"  action="" accept-charset="UTF-8" method="post">
<div class="col-md-3">
<select name="subj" id="exam_batch_subj_ids_"   class="chosen-select form-control" >
<option  selected value="0">- Select Training -</option>
<?php
					while($r = mysqli_fetch_array($res)){   //Creates a loop to loop through results
							echo "<option value=" . $r['id'] .">" . $r['subject'] . "</option>"; 
						}
?>
</select></div>
<div class="col-md-3">
<select name="clas" id="exam_batch_course_ids_"   class="chosen-select form-control" >
<option selected value="">- Select Course -</option>
<?php
					while($row = mysqli_fetch_array($reslt)){   //Creates a loop to loop through results
							echo "<option value=" . $row['id'] .">" . $row['class'] . "</option>"; 
						}
?>
</select></div>
<div class="col-md-3">
<select name="std" id="exam_batch_std_ids_"   class="chosen-select form-control" >
<option  selected value="0">- Select Student -</option>
<?php
					while($r = mysqli_fetch_array($re)){   //Creates a loop to loop through results
							echo "<option value=" . $r['id'] .">" . $r['name'] . "</option>"; 
						}
?>
</select></div>
<div class="row">
<div class="col-md-12"><div class="btn-row">
<input  type="submit" value="Next" name="SubmitButton" class="btn green  vx-cust-btn btn-rgt"  ></div>
</div>
</div>
</form>
<div class="row"><div class="col-sm-12 col-md-12 col-lg-12"><div class="portlet-body">
<div class="row"><div class="col-sm-12 col-md-12 col-lg-12">
<div class="row">
<div class="col-md-12"><div class="btn-row">
<button  type="button" name="printButton" onclick="printDiv()" class="btn btn-info vx-cust-btn ">Print</button>
<button style="margin-left:30px;" type="button" name="printXLSBtn" onclick="exportToExcel()" class="btn btn-info vx-cust-btn ">Export XLS</button>
<a href="edit_result.php?class=<?php echo $class; ?>&subj=<?php echo $subj; ?>&std=<?php echo $std;?>"><button style="margin-left:30px;"  type="submit" name="editButton" class="btn btn-info vx-cust-btn ">Edit Result</button></a>

</div>
</div>
</div>
<div class="row">
<div class="col-md-12" id="printableTable">
<div class="table-responsive"><table id="exportTable" class="table table-hover sortable"><thead><tr><th>Mil No.</th><th>Student ID</th><th>Rank</th><th>Unit</th><th>Telephone</th><th>Exam Name</th><th>Training</th>
<th>Marks</th><th>Percentage</th><th>Status</th><th>Date</th></tr></thead>
<tbody>
<?php               if($show==1)

					while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
						
						if(($class == 0 ||  $row['class']== $class) && ($subj == 0 || $row['subject'] == $subj) && ($std == 0 || $row['id']==$std)){
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
							echo "</td><td>" . $row['marks'] . "</td>
							<td>" . $row['per'] . "</td><td>" . $row['status'] . "</td><td>" . $row['date'] . "</td></tr>";
						}
					}
				?>
</tbody></table></div>
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