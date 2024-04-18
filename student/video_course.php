<?php 
		include("includes/header.php");
		include("includes/sidebar.php"); 
		include("../conn.php");
		$proceed = 0;
		$eid = $_GET["e"];
		$id = $_SESSION['id'];
		$query = "SELECT * FROM svideos where eid='$eid'"; //You don't need a ; like you do in SQL
		$result = mysqli_query($conn,$query);
    $videos = [];
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
<p>You can watch a video courses about the exam here </p>
<p><b>Note: </b>If no video appears here, just click attempt</p>
<p>هنا يمكنك مشاهدة الفيديوهات الخاصة بالإختبار </p>
<p><b>ملاحظة:  </b>إذا لم تشاهد أي فيديوهات ظاهرة فقط استمر واضغط زر اختبر</p>
<div class="row q-data">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="portlet-body">
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="row"><div class="col-md-12">
<div class="table-responsive">
<table class="table table-hover sortable">
<thead><tr>
<th>Name</th>
<th>Training</th>
<th>Viewed</th>
</tr></thead>
<tbody>
<?php
					while($row = mysqli_fetch_array($result)){
						$vid=$row['vid'];
						$sql = "SELECT * FROM videos where id='$vid'"; //You don't need a ; like you do in SQL
						 $res = mysqli_query($conn,$sql);
						 if ($res->num_rows > 0) {
							// The result has rows, so there are values
							while($rex = mysqli_fetch_array($res)){
                array_push($videos, array(
                  'id' => $rex['id'],
                  'video' => $rex['video'],
                  'name' => $rex['name'],
                  'class' => $rex['class']
                ));
								$queryV = "SELECT * FROM stuvideos where vid='".$rex["id"]."' AND sid='$id'";
								$resV = mysqli_query($conn,$queryV);
								echo "<tr><td hidden>" . $rex['id'] . "</td>
								<td>" . $rex['name'] . " <button class='view-btn btn btn-info' data-class='".$rex['class'] ."' data-id='".$rex['id'] ."' data-video='../teacher/assets/videos/". $rex['video'] ."'><i class='fa fa-eye' style='margin-right:0;'/></button></td>
								<td>";
                $querys ="select * from subjects where id ='".$rex['subject']."'";
                $results = mysqli_query($conn,$querys);
                while($rows = mysqli_fetch_array($results)){
                  echo $rows['subject'];
                }
                echo "</td><td id='status-".$rex["id"]."'>";
								if ($resV->num_rows > 0) {
									echo "<i class='fa fa-check' style='color:green;' />";
									$proceed++;
								} else {
									echo "<i class='fa fa-times' />";
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
<a href="exam.php" class="btn default vx-cust-btn" >Back</a>

<a id="attemptExam" href="preview_exam.php?q=<?php echo $eid; ?>" <?php if ($proceed != count($videos)) { ?> style="display:none;" <?php } ?> class="btn btn-success vx-cust-btn" >Attempt اختبر</a>

</div></div></div>
</div></div></div></div></div></div>

<?php include("includes/footer.php"); ?></div>

<div id="videoModal" class="modal">
  <div class="modal-content">
    <h4 style="margin: 0;padding: 20px 15px 0;">Video Course</h4>
    <span class="close" id="closeModalBtn">&times;</span>
    <hr/>
    <div class="help-block with-errors" id="course-error"></div>
    <video style="padding:15px;" id="modalVideo" controls>
      <source src="" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <button style="margin-left:15px; margin-bottom:20px;" id="closeModalBtn2" type="button" class="btn btn-default">Close</button>
    <button style="margin: 0 15px 20px auto;" id ="nextVideoModalBtn" type="button" class="btn btn-success">Next</button>
  </div>
</div>

<script>
  var modal = document.getElementById("videoModal");
  var videos = <?php echo json_encode($videos); ?>;
  var viewed = <?php echo $proceed; ?>;
  var modalVideo = document.getElementById("modalVideo");

  var viewButtons = document.getElementsByClassName("view-btn");

  var closeBtn = document.getElementById("closeModalBtn");
  var closeBtn2 = document.getElementById("closeModalBtn2");
  var nextVideoModalBtn = document.getElementById("nextVideoModalBtn");

  var videoIdInput = document.getElementById("video-id");
  var nextVideo = 1;

  for (var i = 0; i < viewButtons.length; i++) {
    viewButtons[i].addEventListener("click", function() {
      var videoSrc = this.getAttribute("data-video");
      var videoId = this.getAttribute("data-id")
      modalVideo.src = videoSrc; // Set the video source
      nextVideo = videos.indexOf(videos.filter(item => item.id === videoId)[0]) + 1;
      if (nextVideo === videos.length) {
        $(nextVideoModalBtn).hide();
      } else {
        $(nextVideoModalBtn).show();
      }
      modalVideo.src = videoSrc; // Set the video source
      $("#video-id").val(videoId);
      modal.style.display = "block"; // Open the modal
    });
  }
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
              if (response == "OK") {
                viewed++;
                if (viewed == videos.length) {
                  $("#attemptExam").show();
                }
              }
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
      var videoItem = videos[nextVideo];
      $("#video-id").val(videoItem.id);
      modalVideo.src = "../teacher/assets/videos/" + videoItem.video; // Set the video source
      if (videos[nextVideo + 1]) {
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
    modal.style.display = "none";
    modalVideo.pause(); // Pause the video
  });
  closeBtn2.addEventListener("click", function() {
    $("#videoModal").hide();
    modalVideo.pause(); // Pause the video
  });
</script>
</body></html>