<?php 
		include("includes/header.php"); 
		include("includes/sidebar.php"); 
		include("../conn.php");
		$query = "SELECT * FROM students"; //You don't need a ; like you do in SQL
		$reslt = mysqli_query($conn,$query);
		if(isset($_POST['delete_id'])){ 
		$id = $_POST['delete_id'];
		$query = "DELETE FROM students WHERE id='".$id."'";		
		mysqli_query($conn, $query);
		 echo '<script>window.location.href="users.php";</script>';
		}
?>
<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
<h3>Students</h3>
<p>Your Students are listed below. Here you can see the list of Students. To create a new Students, click on &#39;New Students&#39; link to access the page.</p>
<hr />
<div class="row q-data"><div class="col-sm-12 col-md-12 col-lg-12"><div class="portlet-body">
<div class="row"><div class="col-md-12 text-right">
<div class="new-link"><a class="btn btn-success" href="new_student.php">
<i class="fa fa-plus add" data-toggle="tooltip"></i>New Student</a></div><ul class="pagination"></ul></div></div><div class="row">
<div class="col-sm-12 col-md-12 col-lg-12"><div class="row"><div class="col-md-12">

<div class="table-responsive">
<table class="table table-hover" id="selected-user-list"><thead><tr><th>ID</th><th>Full Name</th>
<th>Reg No.</th><th>Unit Name.</th><th>Password</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>

<?php
					while($row = mysqli_fetch_array($reslt)){   //Creates a loop to loop through results
							echo "<tr><td>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['regno'] . "</td><td>" . $row['unit'] . "</td><td>" . $row['pass'] . "</td><td>Student</td><td>Active</td>
							<td><div class='field-actions'><div class='btn-group'>
							<form action='users.php' method='post'>
							<button   name='delete_id' value=" .$row['id'] . " type='submit' class='btn btn-danger'  type='button'>Delete</button></div></div></td></form></tr>";  //$row['index'] the index here is a field name
						}
?>
</tbody></table>
</div><div class="row"><div class="col-md-12 text-right"></div></div></div></div></div></div></div></div></div></div></div></div></div></div>
<?php include("includes/footer.php"); ?>
</div>
</body></html>