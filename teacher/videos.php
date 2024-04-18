<?php 
        include("includes/header.php");
        include("includes/sidebar.php"); 
        include("../conn.php");
        $show=0;
        if(isset($_POST['SubmitButton']) && isset($_POST['clas']) && isset($_POST['subject'])){
            $show=1;
			  $clas=$_POST['clas'];
        $subject=$_POST['subject'];
        $query = "SELECT * FROM videos WHERE subject='$subject' AND class = '$clas' ORDER BY `order`, id"; //You don't need a ; like you do in SQL
        $result = mysqli_query($conn,$query);
        }
    
        if(isset($_POST['delete_id'])){ 
        $id = $_POST['delete_id'];
        $query = "delete from videos where id = $id";        
        mysqli_query($conn, $query);
         echo '<script>window.location.href="videos.php";</script>';
        }
        $i=0;
        $query = "SELECT * FROM subjects"; //You don't need a ; like you do in SQL
        $reslt = mysqli_query($conn,$query);
        $query = "SELECT * FROM classes"; //You don't need a ; like you do in SQL
        $relt = mysqli_query($conn,$query);
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
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8);
  }

  .modal-content {
    top: 50%;
    width: 80%;
    max-width: 800px;
    position: relative;
    left: 50%;
    transform: translate(-50%, -50%);
  }

</style>
<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
 <h3>Videos</h3><hr />
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
<label class="col-md-2 control-label">Course <span class="mandatory-fld">*</span></label>
<div class="col-md-3">
<select name="clas" id="exam_batch_class_ids_"  required  class="chosen-select form-control" >
<option disabled selected value="">- Select Course -</option>
<?php
					while($row = mysqli_fetch_array($relt)){   //Creates a loop to loop through results
            if (array_search($row['subject'], $tsubjects)!==false) {
              echo "<option value=" . $row['id'] .">" . $row['class'] . "</option>";
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
<div class="new-link"><a class="btn btn-success" href="new_video.php"><i class="fa fa-plus add" data-toggle="tooltip"></i>New Video</a></div>
</div></div><div class="row">
<div class="col-sm-12 col-md-12 col-lg-12"><div class="row">
<div class="col-md-12"><div class="table-responsive">
<table class="table table-hover sortable"><thead>
<tr>
<th>ID</th>
<th>Video</th>
<th>Training</th>
<th>Actions</th>
</tr></thead>
<tbody>
<?php
                     if($show==1)
                    while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                            $i++;
                            echo "<tr><td>" . $i . "</td><td>" . $row['name'] . " <button class='view-btn btn btn-info' data-id='".$row['id'] ."' data-video='assets/videos/". $row['video'] ."'><i class='fa fa-eye' style='margin-right:0;'/></button></td><td>";
                            $querys ="select * from subjects where id ='".$row['subject']."'";
                            $results = mysqli_query($conn,$querys);
                            while($rows = mysqli_fetch_array($results)){
                              echo $rows['subject'];
                            }
                            echo "</td><td><div class='field-actions'><div class='btn-group'>
                            <form action='videos.php' method='post'>
                            <a class='btn btn-primary' href='new_video.php?id=" .$row['id'] . "'><i class='fa fa-plus edit' data-toggle='tooltip'></i>Edit</a>
                            <button   name='delete_id' value=" .$row['id'] . " type='submit' class='btn btn-danger'  type='button'>Delete</button></div></div></td></form></tr>";  //$row['index'] the index here is a field name
                        }
                ?>
</tbody></table></div><div class="row"><div class="col-md-12 text-right"></div></div></div></div></div></div></div></div></div></div></div></div></div></div>
<?php include("includes/footer.php"); ?>
</div>
<div id="videoModal" class="modal">
  <div class="modal-content">
    <span style="padding: 10px 20px;" class="close">&times;</span>
    <video style="padding:15px;" id="modalVideo" controls>
      <source src="" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
</div>

<script>
  var modal = document.getElementById("videoModal");

  var modalVideo = document.getElementById("modalVideo");

  var viewButtons = document.getElementsByClassName("view-btn");

  var closeBtn = document.getElementsByClassName("close")[0];

  for (var i = 0; i < viewButtons.length; i++) {
    viewButtons[i].addEventListener("click", function() {
      var videoSrc = this.getAttribute("data-video");
      modalVideo.src = videoSrc; // Set the video source

      modal.style.display = "block"; // Open the modal
    });
  }

  // Close the modal when the close button is clicked
  closeBtn.addEventListener("click", function() {
    modal.style.display = "none";
    modalVideo.pause(); // Pause the video
  });
</script>
</body></html>