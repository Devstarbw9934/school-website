<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");

		if(isset($_POST['SubmitButton'])){ //check if form was submitted	

			$sql = "INSERT INTO students (name, regno, pass, unit) VALUES ('$_POST[full_name]', '$_POST[regno]', '$_POST[password]', '$_POST[unit]')";
			mysqli_query($conn, $sql);
			echo '<script>window.location.href="students.php";</script>';
		}  		
		
		
?>
<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
<h3>New Student</h3>
<p>You can create a Student by filling the fields in form below.</p><hr />
<div class="row q-data"><div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body"><div class="row"><div class="col-sm-12 col-md-12 col-lg-12">
<form class="form-horizontal" id="new_user"  action="new_student.php" accept-charset="UTF-8" method="post">
<div class="form-body">
<div class="form-group">
<label class="col-sm-3 control-label" for="user_full_name">Full Name</label>
<div class="col-sm-6">
<input placeholder="Full Name" class="form-control" required="required" maxlength="30" size="50" type="text" name="full_name" id="user_full_name" />
<div class="help-block with-errors"></div>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_username">Registration No.</label>
<div class="col-sm-6">
<input placeholder="Registration No." class="form-control" required="required" maxlength="30" size="50" type="text"name="regno" id="user_username" />
<div class="help-block with-errors"></div>
</div>
</div>
<div class="form-group" id="unitName">
<label class="col-sm-3 control-label" for="unit_name">Unit Name.</label>
<div class="col-sm-6">
<input placeholder="Unit Name." required="required" class="form-control" maxlength="30" size="50" type="text"name="unit" id="unit_name" />
<div class="help-block with-errors"></div>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_email">Password</label>
<div class="col-sm-6">
<input placeholder="Password" class="form-control" required="required" type="password" name="password" id="user_password" />
<div class="help-block with-errors"></div>
</div>
</div>

</div>
<hr />
<div class="row">
<div class="col-md-9">
<div class="btn-row">
<input type="submit" name="SubmitButton"  class="btn green vx-cust-btn btn-rgt" />
<a class="btn default vx-cust-btn" href="students.php">Back</a><br><br>
</div>
</div>
</div>
</form>
</div>
</div>
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