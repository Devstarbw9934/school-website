<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");
		$query = "SELECT * FROM subjects"; //You don't need a ; like you do in SQL
		$isarabic = 'n';
		$result = mysqli_query($conn,$query);

		function resizeImage($resourceType, $image_width, $image_height, $resizeWidth, $resizeHeight)
{
    $imageLayer = imagecreatetruecolor($resizeWidth, $resizeHeight);
    imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $image_width, $image_height);
    return $imageLayer;
}

  		if(isset($_POST['SubmitButton']) && !isset($_REQUEST['id'])){ 
			$isarabic = 'n';
			if(isset($_POST['is_arabic']) && $_POST['is_arabic'] == 'on') {
				$isarabic = 'y';
			}


			$fileOrder = explode('/', $_POST["fileOrder"]);
			$files = $_FILES["image"];
			$img_width = $_POST['img_width'];
			$img_height = $_POST['img_height'];
			$targetDirectory = "assets/images/";  // Specify the directory to save the uploaded file
			//for ($i = 0; $i < count($files["name"]); $i++) {
				$originalFileName = $files["name"]; // Get the original file name
				$extension = pathinfo($originalFileName, PATHINFO_EXTENSION); // Get the file extension
				$uniqueIdentifier = time() . '_' . mt_rand(1000, 9999);
				$newFileName = $uniqueIdentifier . '.' . $extension;
				$order = array_search($originalFileName, $fileOrder);
				$targetFile = $targetDirectory . $newFileName; // Get the file path	
				if (move_uploaded_file($files["tmp_name"], $targetFile)) {	
		$sql = 'INSERT INTO questions (subject, marks, question, image, opt1, opt2, opt3, opt4, ans, hint, is_arabic) VALUES ("$_POST[subject]", "$_POST[marks]", "$_POST[question]", "$newFileName", "$_POST[opt1]", "$_POST[opt2]", "$_POST[opt3]", "$_POST[opt4]", "$_POST[ans]", "$_POST[hint]", "$isarabic")';
		mysqli_query($conn, $sql);
		} else {
		echo '<script>console.log("Error uploading file.");</script>';
	}
//}
			//Now resizing of image

			$imageProcess = 0;
    if (is_array($_FILES))
    {
        $new_width = $_POST['img_width'];
        $new_height = $_POST['img_height'];
        $fileName = $targetFile;
		echo $fileName;
        $sourceProperties = getimagesize($fileName);
        $resizeFileName = time();
        $uploadPath = "assets/images/";
        $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadImageType = $sourceProperties[2];
        $sourceImageWidth = $sourceProperties[0];
        $sourceImageHeight = $sourceProperties[1];
        switch ($uploadImageType)
        {
            case IMAGETYPE_JPEG:
                $resourceType = imagecreatefromjpeg($fileName);
                $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                imagejpeg($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

            case IMAGETYPE_GIF:
                $resourceType = imagecreatefromgif($fileName);
                $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                imagegif($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

            case IMAGETYPE_PNG:
                $resourceType = imagecreatefrompng($fileName);
                $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                imagepng($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

            case IMAGETYPE_JPG:
                $resourceType = imagecreatefrompng($fileName);
                $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                imagepng($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

            default:
                $imageProcess = 0;
            break;
        }
        move_uploaded_file($fileName, $uploadPath . $resizeFileName . "." . $fileExt);
        $imageProcess = 1;
    }


		echo '<script>window.location.href="questions.php";</script>';
		}
		if(isset($_POST['SubmitButton']) && isset($_REQUEST['id'])){ 
			$id = $_REQUEST['id']; //get id 
			$isarabic = 'n';
			if(isset($_POST['is_arabic']) && $_POST['is_arabic'] == 'on') {
				$isarabic = 'y';
			}

			$question_statement = $_POST['question'];
			$textToStore = nl2br(htmlentities($question_statement, ENT_QUOTES, 'UTF-8'));	
			$fileOrder = explode('/', $_POST["fileOrder"]);
			$files = $_FILES["image"];
			$img_width = $_POST['img_width'];
			$img_height = $_POST['img_height'];
			$targetDirectory = "assets/images/";  // Specify the directory to save the uploaded file
			//for ($i = 0; $i < count($files["name"]); $i++) {
				$originalFileName = $files["name"]; // Get the original file name
				$extension = pathinfo($originalFileName, PATHINFO_EXTENSION); // Get the file extension
				$uniqueIdentifier = time() . '_' . mt_rand(1000, 9999);
				$newFileName = $uniqueIdentifier . '.' . $extension;
				$order = array_search($originalFileName, $fileOrder);
				$targetFile = $targetDirectory . $newFileName; // Get the file path	
				if (move_uploaded_file($files["tmp_name"], $targetFile)) {	

		$sql = "UPDATE questions SET subject='$_POST[subject]', marks='$_POST[marks]', question='$question_statement',image='$newFileName', opt1='$_POST[opt1]', opt2='$_POST[opt2]', opt3='$_POST[opt3]', opt4='$_POST[opt4]', ans='$_POST[ans]', hint='$_POST[hint]', is_arabic='$isarabic' WHERE id='$id'";
		mysqli_query($conn, $sql);
		mysqli_close($conn);
	} else {
		echo '<script>console.log("Error uploading file.");</script>';
	}

			//Now resizing of image

			$imageProcess = 0;
    if (is_array($_FILES))
    {
        $new_width = $_POST['img_width'];
        $new_height = $_POST['img_height'];
        $fileName = $targetFile;
		echo $fileName;
        $sourceProperties = getimagesize($fileName);
        $resizeFileName = time();
        $uploadPath = "assets/images/";
        $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadImageType = $sourceProperties[2];
        $sourceImageWidth = $sourceProperties[0];
        $sourceImageHeight = $sourceProperties[1];
        switch ($uploadImageType)
        {
            case IMAGETYPE_JPEG:
                $resourceType = imagecreatefromjpeg($fileName);
                $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                imagejpeg($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

            case IMAGETYPE_GIF:
                $resourceType = imagecreatefromgif($fileName);
                $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                imagegif($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

            case IMAGETYPE_PNG:
                $resourceType = imagecreatefrompng($fileName);
                $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                imagepng($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

            case IMAGETYPE_JPG:
                $resourceType = imagecreatefrompng($fileName);
                $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                imagepng($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
            break;

            default:
                $imageProcess = 0;
            break;
        }
        move_uploaded_file($fileName, $uploadPath . $resizeFileName . "." . $fileExt);
        $imageProcess = 1;
    }


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
		$query = "SELECT subject FROM tsubject where teacher='".$_SESSION["regno"]."'"; //You don't need a ; like you do in SQL
        $ret = mysqli_query($conn,$query);
        $tsubjects = [];
        if (mysqli_num_rows($ret) > 0) {
            while($row = mysqli_fetch_array($ret)){
                array_push($tsubjects, $row["subject"]);
            }
        }



?>
<style>
	.arabic {
		direction: rtl;
	}
</style>
<div class="content-main">
<?php
if (function_exists('gd_info')) {
    echo "GD extension is enabled";
} else {
    echo "GD extension is not enabled";
}
?>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12 col-md-12">
<h3>New Question</h3>
<p>This form helps you to create a question and find it easily from a pool name as a subject name.</p><hr />
<div class="row q-data">
<div class="col-sm-12 col-md-12">
<div class="portlet-body">
<form class="form-horizontal" id="new_question"  action="" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
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
						if (array_search($row['id'], $tsubjects)!==false) {	
							$selected = ($row['id']==$subject) ? ' selected="selected"' : '';
							echo "<option value=" . $row['id']  ." ".$selected.">" . $row['subject'] . "</option>"; 
						}
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
<input placeholder="Mark" value="<?php echo isset($marks) ? $marks: '' ;?>" class="form-control small text-wide-150" required="required" step="1" min="1" max="5" type="number" name="marks" id="question_mark" />
</div></div><br />
</div></div></div></div>
<div class="form-group">
<div class="col-md-2">
<label class="name-tag control-label" for="is_arabic">Is Arabic</label>
</div>
<div class="col-md-8" style="display:flex;align-items:center;height: 27px;">
<input class="bootstrap-switch" type="checkbox" name="is_arabic" id="is_arabic" <?php if ($isarabic == 'y') echo "checked='checked'"; ?>/>
</div></div><br />
<div class="row">
<div class="col-md-2">
<label class="name-tag control-label">Select an image file <span class="mandatory-fld">*</span></label>
</div><div class="col-md-8">
<input type="file" id="fileInput" placeholder="Image" multiple class="form-control" name="image">
<input type="hidden" name="fileOrder" id="fileOrder">
</div>
</div>
<br />
<div class="row">
<div class="col-md-5">
<div class="form-group">
<div class="col-md-5">
<label class="name-tag control-label" for="img_widht">Width</label>
</div>
<div class="col-md-6">
<input placeholder="Width" value="" class="form-control small text-wide-150" required="required" type="number" name="img_width" id="image_width" />
</div></div></div>
<div class="col-md-5">
<div class="form-group">
<div class="col-md-2">
<label class="name-tag control-label" for="img_height">Height</label>
</div>
<div class="col-md-8">
<input placeholder="Height" value="" class="form-control small text-wide-150" required="required" type="number" name="img_height" id="image_height" />
</div></div><br />
</div></div></div></div>
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
<textarea placeholder="Answer Option 1" cols="40" class="form-control ckbasic ans-fill" required="required" name="opt1" >
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
<br />
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
<label class="name-tag">الترجمة</label>
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
	$(document).on("change", "#is_arabic", function () {
		if ($(this).prop("checked")) {
			$("textarea").addClass("arabic");
		} else {
			$("textarea").removeClass("arabic");
		}
	});
</script>
</div></body></html>