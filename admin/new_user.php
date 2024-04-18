<?php 
        include("includes/header.php");
        include("includes/sidebar.php"); 
        include("../conn.php");
        $query = "SELECT * FROM subjects"; //You don't need a ; like you do in SQL
        $result = mysqli_query($conn,$query);
        $sql = "SELECT * FROM classes"; //You don't need a ; like you do in SQL
        $reslt = mysqli_query($conn,$sql);
        
        if(isset($_POST['SubmitButton']) && !isset($_REQUEST['id'])){ //check if form was submitted 
        extract($_POST);   
            if($_POST['role']=="student"){
                $sql = "INSERT INTO students( `regno`, `rank`, `name`, `telephone`, `unit`, `pass`)VALUES ('".$_POST['regno']."', '".$_POST['rank']."','".$_POST['full_name']."', '".$_POST['telephone']."','".$_POST['unit']."', '".$_POST['password']."')";
                mysqli_query($conn, $sql);
            }
            if($_POST['role']!="student"){
                $sql = "INSERT INTO user (`regno`, `rank`, `name`, `unit`, `telephone`, `pass`, `role`) VALUES ('".$_POST['regno']."', '".$_POST['rank']."','".$_POST['full_name']."', '".$_POST['unit']."', '".$_POST['telephone']."','".$_POST['password']."', '".$_POST['role']."')";
                mysqli_query($conn, $sql);
                if($_POST['role']=="teacher"){
                    $values = $_POST['subjects'];
                    foreach ($values as $names)
                    {
                        $sql = "INSERT INTO tsubject (teacher, subject) VALUES ('".$_POST["regno"]."', '".$names."')";
                        mysqli_query($conn, $sql);
                    }
                }
            }
            echo '<script>window.location.href="users.php";</script>';
        } 


        if(isset($_POST['SubmitButton']) && isset($_REQUEST['id'])){ //check if id was received	and form was submitted
			
			$id = $_REQUEST['id']; //get id 
			extract($_POST);   
            $rank = $_POST['rank'];
            $telephone = $_POST['telephone'];
            $unit = $_POST['unit'];

            if($_POST['role']=="student"){

                $sql = "UPDATE students SET regno='$_POST[regno]', rank='$rank', name='$_POST[full_name]', telephone='$telephone', unit='$_POST[unit]', pass='$_POST[password]' WHERE id='$id'";
                mysqli_query($conn, $sql);
            }
            if($_POST['role']!="student"){
                $sql = "UPDATE user SET regno='$_POST[regno]', rank='$rank', name='$_POST[full_name]', unit='$unit', telephone='$telephone', pass='$_POST[password]', role='$_POST[role]' WHERE id='$id'";
                mysqli_query($conn, $sql);
                if($_POST['role']=="teacher"){
                    $values = $_POST['subjects'];
                    foreach ($values as $names)
                    {
                        $sql = "INSERT INTO tsubject (teacher, subject) VALUES ('".$_POST["regno"]."', '".$names."')";
                        mysqli_query($conn, $sql);
                    }
                }
            }
            echo '<script>window.location.href="users.php";</script>';
		
		}
        
        if(isset($_REQUEST['id']) && !isset($_POST['SubmitButton'])){ //check if id was received and form was not submitted
			$tab = $_REQUEST['tab'];
            if($tab == 1){
			$id = $_REQUEST['id']; //get id 
			$date = date ("Y-m-d H:i:s");
			$sql = "SELECT * FROM user WHERE id='$id'";
			$res = mysqli_query($conn, $sql);
			if ($res->num_rows > 0) {
				while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$name = $row['name'];
					$regno = $row['regno'];
                    $pass = $row['pass'];
                    $role = $row['role'];
                    $unit = $row['unit'];
                    $rank = $row['rank'];
                    $telephone = $row['telephone'];
			}			
		}   
		
		}

        if($tab == 2){
			$id = $_REQUEST['id']; //get id 
			$date = date ("Y-m-d H:i:s");
			$sql = "SELECT * FROM students WHERE id='$id'";
			$res = mysqli_query($conn, $sql);
			if ($res->num_rows > 0) {
				while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$name = $row['name'];
					$regno = $row['regno'];
                    $pass = $row['pass'];
                    $role = "student";
                    $unit = $row['unit'];
                    $rank = $row['rank'];
                    $telephone = $row['telephone'];
			}			
		}   
		
		}
    }

?>
<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
<h3>New User</h3>
<p>You can create a user by filling the fields in form below.</p><hr />
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
<label class="col-sm-3 control-label" for="user_username">Unit Name.</label>
<div class="col-sm-6">
<input placeholder="Unit Name." value="<?php echo isset($unit) ? $unit: '' ;?>" class="form-control" maxlength="30" size="50" type="text"name="unit" id="unit_name" />
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

<div class="form-group course-update">
<label class="col-sm-3 control-label" for="user_role">Role</label>
<div class="col-sm-6">
<select required="required" class="form-control" name="role" onchange="getval(this);">
<?php $selected = ("student"==$role) ? ' selected="selected"' : ''; ?>
<option  value="student" <?php echo $selected?>>Student</option>
<?php $selected = ("teacher"==$role) ? ' selected="selected"' : ''; ?>
<option value="teacher" <?php echo $selected?>>Teacher</option>
<?php $selected = ("admin"==$role) ? ' selected="selected"' : ''; ?>
<option value="admin" <?php echo $selected?>>Admin</option>
</select>
<script>
function getval(sel)
{
    if(sel.value!="student") {
        document.getElementById("unitName").style.display = 'none';
    }
    if(sel.value!="teacher") {
        document.getElementById("abc2").style.display = 'none';
    }
    if(sel.value=="teacher") {
        document.getElementById("abc2").style.display = '';
    }
    if(sel.value=="student") {
        document.getElementById("unitName").style.display = '';
    }
}
</script>
<div class="help-block with-errors"></div>
</div>
</div>

<div class="form-group course-update-remove" id="abc2" style="display:none;">
<label class="col-sm-3 control-label">Trainings</label>
<div class="col-sm-6">
    <link href="assets/css/jquery.css" rel="stylesheet" type="text/css">
<select name="subjects[]" class=" form-control" multiple="multiple" class="4colactive">
       <?php
                    while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                            echo "<option value=" . $row['id']  .">" . $row['subject'] . "</option>"; 
                        }
                ?>
    </select>
<script src="assets/js/jquery.js"></script>
<script>
$('select[multiple]').multiselect({
    columns: 3,
    placeholder: 'Select options'
});
</script>
</div>
</div>
</div>
<hr />
<div class="row">
<div class="col-md-9">
<div class="btn-row">
<input type="submit" name="SubmitButton"  class="btn green vx-cust-btn btn-rgt" />
<a class="btn default vx-cust-btn" href="/en/admin/users">Back</a><br><br>
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