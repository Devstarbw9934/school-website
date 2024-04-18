<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");
		$id=$_SESSION['id'];
		$query = "SELECT * FROM exams"; //You don't need a ; like you do in SQL
		$result = mysqli_query($conn,$query);	
?>
<meta content="width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=yes" name="viewport" />
<div class="content-main"><div class="container-fluid">
<div class="row">
<div class="col-sm-12 col-md-12">
<center><h3>Exams</h3><h3>الإختبارات</h3><p>Below is the list of the exams you can take.</p><p>بالأسفل قائمة الإختبارات التي يمكنك إنجازها</p></h3><p>Rotate the tablet to be able to click the button</p><p>ضع التابلت بالوضعية الأفقية لتتمكن من ضغط زر البدء</p></center>
<div class="row q-data">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body">
<hr />
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="row"><div class="col-md-12">
<div class="table-responsive">
<table class="table table-hover sortable">
<thead><tr>
<th>Name</th>
<th>Course</th>
<th>Time</th>
<th>Actions</th>
</tr></thead>
<tbody>
<?php
					while($row = mysqli_fetch_array($result)){
						$tid=$row['id'];
						// $sql = "SELECT tid FROM results where tid='$tid'"; //You don't need a ; like you do in SQL
						$sql = "SELECT tid FROM results"; //You don't need a ; like you do in SQL
						 $res = mysqli_query($conn,$sql);
						 if ($res->num_rows > 0) {
							// The result has rows, so there are values
							$rex = mysqli_fetch_row($res);
							 if($row['id']!=$rex[0])//result is not match the exam
							{
							echo "<tr><td hidden>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>";
							$querys ="select * from classes where id ='".$row['class']."'";
							$results = mysqli_query($conn,$querys);
							while($rows = mysqli_fetch_array($results)){
								echo $rows['class'];
							}
							echo "</td><td><div class='field-actions'><div class='btn-group'>
							<form action='video_course.php' method='GET'>
							<button name='e' value=" .$row['id'] . " type='submit' class='btn btn-success'  type='button'>Attempt اختبر</button></td></form></div></div>
							</td></tr>";  //$row['index'] the index here is a field name
							}
						} else {
							echo "<tr><td hidden>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>";
							$querys ="select * from classes where id ='".$row['class']."'";
							$results = mysqli_query($conn,$querys);
							while($rows = mysqli_fetch_array($results)){
								echo $rows['class'];
							}
							echo "</td><td><div class='field-actions'><div class='btn-group'>
							<form action='video_course.php' method='GET'>
							<button name='e' value=" .$row['id'] . " type='submit' class='btn btn-success'  type='button'>Attempt</button></td></form></div></div>
							</td></tr>";  //$row['index'] the index here is a field name
						}
					
					}
				?>

</tbody>


</table></div><div class="text-right"></div></div></div></div></div></div></div>
<div class="row"><div class="col-md-12">
<div class="btn-row">
<a href="dashboard.php" class="btn default vx-cust-btn" >Back</a>
</div></div></div>
</div></div></div></div></div></div>

<?php include("includes/footer.php"); ?></div>

<script> 
	</script>

</body></html>