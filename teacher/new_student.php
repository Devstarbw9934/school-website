<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");

		
		if(isset($_POST['SubmitButton']) && !isset($_REQUEST['id'])){ //check if form was submitted		
			echo "insert";
			extract($_POST);
			$sql = "INSERT INTO students(`regno`, `rank`, `name`, `telephone`, `unit`, `pass`) VALUES ('$_POST[regno]', '$_POST[rank]','$_POST[full_name]', '$_POST[telephone]','$_POST[unit]', '$_POST[password]')";
			mysqli_query($conn, $sql);
			echo '<script>window.location.href="students.php";</script>';
		}  	
		
		if(isset($_POST['SubmitButton']) && isset($_REQUEST['id'])){ //check if id was received	and form was submitted
			echo "update";
			extract($_POST);
			$id = $_REQUEST['id'];
			$sql = "UPDATE students SET regno='$_POST[regno]', rank='$_POST[rank]', name='$_POST[full_name]', telephone='$_POST[telephone]', unit='$_POST[unit]', pass='$_POST[password]' WHERE id='$id'";
			mysqli_query($conn, $sql);
			echo '<script>window.location.href="students.php";</script>';
		}  	

		if(isset($_REQUEST['id']) && !isset($_POST['SubmitButton'])){ //check if id was received and form was not submitted
			$id = $_REQUEST['id']; //get id 
			$sql = "SELECT * FROM students WHERE id='$id'";
			$res = mysqli_query($conn, $sql);
			if ($res->num_rows > 0) {
				while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$regno = $row['regno'];
					$rank = $row['rank'];
					$name = $row['name'];
					$telephone = $row['telephone'];
					$unit = $row['unit'];
					$pass = $row['pass'];

			}
			
		
		}
	}	
		
?>

<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
<h3>New Student</h3>
<p>You can create a Student by filling the fields in form below. <?php echo isset($_REQUEST['id']); ?></p><hr />
<div class="row q-data"><div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body"><div class="row"><div class="col-sm-12 col-md-12 col-lg-12">
<form class="form-horizontal" id="new_user"  action="" accept-charset="UTF-8" method="post">
<div class="form-body">
<div class="form-group">
<label class="col-sm-3 control-label" for="user_full_name">Full Name</label>
<div class="col-sm-6">
<input placeholder="Full Name" value="<?php echo isset($name) ? $name: '' ;?>" class="form-control" required="required" maxlength="30" size="50" type="text" name="full_name" id="user_full_name" />
<div class="help-block with-errors"></div>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_username">Registration No.</label>
<div class="col-sm-6">
<input placeholder="Registration No." value="<?php echo isset($regno) ? $regno: '' ;?>" class="form-control" required="required" maxlength="30" size="50" type="text"name="regno" id="user_username" />
<div class="help-block with-errors"></div>
</div>
</div>
<div class="form-group" id="unitName">
<label class="col-sm-3 control-label" for="unit_name">Unit Name.</label>
<div class="col-sm-6">
<input placeholder="Unit Name." value="<?php echo isset($unit) ? $unit: '' ;?>" required="required" class="form-control" maxlength="30" size="50" type="text"name="unit" id="unit_name" />
<div class="help-block with-errors"></div>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_email">Password</label>
<div class="col-sm-6">
<input placeholder="Password" value="<?php echo isset($pass) ? $pass: '' ;?>" class="form-control" required="required" type="password" name="password" id="user_password" />
<div class="help-block with-errors"></div>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label" for="user_rank">Rank</label>
<div class="col-sm-6">
<input placeholder="Rank" value="<?php echo isset($rank) ? $rank: '' ;?>" class="form-control" required="required" type="text" name="rank" id="user_rank" />
<div class="help-block with-errors"></div>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label" for="telephone">Telephone</label>
<div class="col-sm-6">
<input placeholder="Telephone" value="<?php echo isset($telephone) ? $telephone: '' ;?>" class="form-control" required="required" type="text" name="telephone" id="telephone" />
<div class="help-block with-errors"></div>
</div>
</div>

</div>
<hr />
<div class="row">
<div class="col-md-9">
<div class="btn-row">
<input type="submit" name="SubmitButton" value="Submit"  class="btn green vx-cust-btn btn-rgt" />
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