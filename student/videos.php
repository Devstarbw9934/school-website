<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");
    $show=0;
    $proceed="0";
		$id=$_SESSION['id'];
    if(isset($_POST['SubmitButton']) && isset($_POST['clas'])){
      $proceed="1";
      $show=1;
      $clas=$_POST['clas'];
      $query = "SELECT * FROM videos WHERE class = '$clas' ORDER BY `order`, id"; //You don't need a ; like you do in SQL
      $result = mysqli_query($conn,$query);
    }
    $courses = [];
    $videos = [];
    $query = "SELECT * FROM classes"; //You don't need a ; like you do in SQL
    $relt = mysqli_query($conn,$query);
    while($row = mysqli_fetch_array($relt)){
      array_push($courses, $row);
    }
    $query = "SELECT id, video, name, subject, class FROM videos ORDER BY id, `order`"; //You don't need a ; like you do in SQL
    $resultvv = mysqli_query($conn,$query);
    while($row = mysqli_fetch_array($resultvv)){
      array_push($videos, array(
        'id' => $row['id'],
        'video' => $row['video'],
        'name' => $row['name'],
        'class' => $row['class']
      ));
    }
?>
<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
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
  .close {
    padding: 19px 20px;
    position: absolute;
    right: 0;
    top: 0;
  }
</style>
<div class="content-main"><div class="container-fluid">
<div class="row">
<div class="col-sm-12 col-md-12">
<h3>Video Courses</h3>
<p>You can watch video courses here </p>
<p><b>Note: </b>You must watch all video courses to take an exam.</p>

<form class="form-horizontal" id="new_exam"  action="" accept-charset="UTF-8" method="post">
<label class="col-md-2 control-label">Course <span class="mandatory-fld">*</span></label>
<div class="col-md-3">
<select name="clas" id="exam_batch_class_ids_"  required  class="chosen-select form-control" >
<option disabled selected value="">- Select Course -</option>
<?php
					foreach($courses as $x => $row) {   //Creates a loop to loop through results
            echo "<option value=" . $row['id'] .">" . $row['class'] . "</option>"; 
          }
?>
</select></div>
<div class="row"><div class="col-md-12"><div class="btn-row">
<input  type="submit" value="Next" name="SubmitButton" class="btn green  vx-cust-btn btn-rgt"  ></div>
</div>
</div>
</form>


<div class="row q-data">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body">
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="row"><div class="col-md-12">
<div class="table-responsive">
<table class="table table-hover sortable">
<thead><tr>
<th>ID</th>
<th>Name</th>
<th>Course</th>
<th>Viewed</th>
</tr></thead>
<tbody>
<?php
  if($show==1) {
    if ($result->num_rows > 0) {
      $i=0;
      // The result has rows, so there are values
      while($rex = mysqli_fetch_array($result)){
        $queryV = "SELECT * FROM stuvideos where vid='".$rex["id"]."' AND sid='$id'";
        $resV = mysqli_query($conn,$queryV);
        $i++;
        echo "<tr><td>" . $i . "</td>
        <td>" . $rex['name'] . " <button class='view-btn btn btn-info' data-id='".$rex['id'] ."' data-class='".$rex['class'] ."' data-video='../teacher/assets/videos/". $rex['video'] ."'><i class='fa fa-eye' style='margin-right:0;'/></button></td>
        <td>";
        $querys ="select * from subjects where id ='".$rex['subject']."'";
        $results = mysqli_query($conn,$querys);
        while($rows = mysqli_fetch_array($results)){
          echo $rows['subject'];
        }
        echo "</td><td id='status-".$rex["id"]."'>";
        if ($resV->num_rows > 0) {
          echo "<i class='fa fa-check' style='color:green;' />";
        } else {
          echo "<i class='fa fa-times' />";
          $proceed="0";
        }
        echo "</td></tr>";
      }
    }    
  }
?>

</tbody>
<input type="hidden" name="video_viewed" id="video-id" />

</table></div><div class="text-right"></div></div></div></div></div></div></div>
<div class="row"><div class="col-md-12">
<div class="btn-row">

<a href="exam.php" class="btn btn-success vx-cust-btn">Take an exam</a>

</div></div></div>
</div></div></div></div></div></div>

<?php include("includes/footer.php"); ?></div>

<div id="videoModal" class="modal">
  <div class="modal-content">
    <h4 style="margin: 0;padding: 20px 15px 0;">Video Course</h4>
    <span class="close" id="closeModalBtn">&times;</span>
    <hr/>
    <label class="col-md-2 control-label" style="margin-top: 7px;">Course <span class="mandatory-fld">*</span></label>
    <div class="col-md-3">
    <select name="modal_class" id="exam_batch_class_ids_modal_" class="chosen-select form-control" >
    <option disabled selected value="">- Select Course -</option>
    <?php
              foreach($courses as $x => $row) { //Creates a loop to loop through results
                echo "<option value=" . $row['id'] .">" . $row['class'] . "</option>"; 
              }
    ?>
    </select>
    <div class="help-block with-errors" id="course-error"></div>
    </div>
    <video style="padding:15px;" id="modalVideo" controls>
      <source src="" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <button style="margin-left:15px; margin-bottom:20px;" id="closeModalBtn2" type="button" class="btn btn-default">Close</button>
    <button style="margin: 0 15px 20px auto;" id ="nextVideoModalBtn" type="button" class="btn btn-success">Next</button>
  </div>
</div>

<script>
  var videos = <?php echo json_encode($videos); ?>;

  var modal = document.getElementById("videoModal");

  var modalVideo = document.getElementById("modalVideo");

  var viewButtons = document.getElementsByClassName("view-btn");

  var nextVideoModalBtn = document.getElementById("nextVideoModalBtn");
  var closeBtn = document.getElementById("closeModalBtn");
  var closeBtn2 = document.getElementById("closeModalBtn2");
  var nextVideo = 1;
  var initailClass = '';
  var videoIdInput = document.getElementById("video-id");
  for (var i = 0; i < viewButtons.length; i++) {
    viewButtons[i].addEventListener("click", function() {
      var videoSrc = this.getAttribute("data-video");
      var videoId = this.getAttribute("data-id");
      initailClass = this.getAttribute("data-class");
      nextVideo = videos.filter(item => item.class === initailClass).indexOf(videos.filter(item => item.id === videoId)[0]) + 1;
      if (nextVideo === videos.filter(item => item.class === initailClass).length) {
        $(nextVideoModalBtn).hide();
      } else {
        $(nextVideoModalBtn).show();
      }
      modalVideo.src = videoSrc; // Set the video source
      $("#video-id").val(videoId);
      $("#videoModal").show(); // Open the modal
    });
  }
  $(document).on('change','#exam_batch_class_ids_modal_', function () {
    modalVideo.pause();
    if (videos.filter(item=>item.class===$(this).val()).length) {
      $(nextVideoModalBtn).show();
      initailClass = $(this).val();
      $("#video-id").val(videos.filter(item=>item.class===$(this).val())[0].id);
      nextVideo = 1;
      modalVideo.src = "../teacher/assets/videos/" + videos.filter(item=>item.class===$(this).val())[0].video; // Set the video source
    } else {
      $("#course-error").text("No videos!");
      $(nextVideoModalBtn).hide();
      setTimeout(() => {
        $("#course-error").text("");
      }, 5000);
    }
  });
  modalVideo.addEventListener("timeupdate", function() {
    var percentageWatched = (modalVideo.currentTime / modalVideo.duration) * 100;
    if (percentageWatched >= 100) {
      // User has watched at least 100% of the video
      $.ajax({
        url: 'video_view.php',
        method: 'POST',
        data: {
            video: $("#video-id").val(),
        },
        success: function(response) {
            // Handle the successful response here
            $("#status-" + $("#video-id").val()).html("<i class='fa fa-check' style='color:green;' />");
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.log(error);
        }
      });
    }
  });

  nextVideoModalBtn.addEventListener("click", function() {
    if (nextVideo && nextVideo > 0) {
      var videoItem = videos.filter(item=>item.class===initailClass)[nextVideo];
      $("#video-id").val(videoItem.id)
      modalVideo.src = "../teacher/assets/videos/" + videoItem.video; // Set the video source
      if (videos.filter(item=>item.class===initailClass)[nextVideo + 1]) {
        nextVideo += 1;
        $(nextVideoModalBtn).show();
      } else {
        $(nextVideoModalBtn).hide();
        nextVideo = false;
      }
    } else {
      $("#course-error").text("No videos!");
      $(nextVideoModalBtn).hide();
      setTimeout(() => {
        $("#course-error").text("");
      }, 5000);
    }
  });
  // Close the modal when the close button is clicked
  closeBtn.addEventListener("click", function() {
    $("#videoModal").hide();
    modalVideo.pause(); // Pause the video
  });
  closeBtn2.addEventListener("click", function() {
    $("#videoModal").hide();
    modalVideo.pause(); // Pause the video
  });
</script>
</body></html>