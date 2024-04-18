<?php 
		include("includes/header.php"); 
		include("includes/sidebar.php"); 
		include("../conn.php");
		$query = "SELECT * FROM classes"; //You don't need a ; like you do in SQL
		$result = mysqli_query($conn,$query);
		if(isset($_POST['delete_id'])){ 
		$id = $_POST['delete_id'];
		$query = "delete from classes where ID = $id";		
		mysqli_query($conn, $query);
		 echo '<script>window.location.href="courses.php";</script>';;
		}
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
<div class="container-fluid">
<div class="row">
<div class="col-sm-12 col-md-12">
<h3>Courses</h3>
<p>Below is the list of courses that you have created. Follow the links to find out more about each course and sub course.</p><hr />
<div class="row q-data">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body">
<div class="new-link">
<a class="btn btn-success" href="new_course.php"><i class="fa fa-plus add" data-toggle="tooltip"></i>New Course</a></div>
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body">
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="row">
<div class="col-md-12">
<div class="table-responsive">
<table class='table table-hover' id='selected-user-list' >
				<thead><tr><th>ID</th><th>Name</th><th>Training</th><th>Created At</th><th>Actions</th></tr></thead>
				<tbody>
				<?php
					while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
						if (array_search($row['subject'], $tsubjects)!==false) {	
							echo "<tr><td>" . $row['id'] . "</td><td>" . $row['class'] . "</td><td>";
							$querys ="select * from subjects where id ='".$row['subject']."'";
							$results = mysqli_query($conn,$querys);
							while($rows = mysqli_fetch_array($results)){
								echo $rows['subject'];
							}
							echo "</td><td>" . $row['date'] . "</td><td><div class='field-actions'><div class='btn-group'>
							<form action='courses.php' method='post'>
							<a class='btn btn-primary' href='new_course.php?id=" .$row['id'] . "'><i class='fa fa-plus edit' data-toggle='tooltip'></i>Edit</a>
							<button   name='delete_id' value=" .$row['id'] . " type='submit' class='btn btn-danger'  type='button'>Delete</button></div></div></td></form></tr>";  //$row['index'] the index here is a field name
						}
					}
				?>

</tbody>
</table>
</div>
<div class="text-right"></div></div></div></div></div></div></div></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include("includes/footer.php"); ?>
</div>
</body>
</html>