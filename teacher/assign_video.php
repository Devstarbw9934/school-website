<?php     include("includes/header.php");
        include("includes/sidebar.php");  
        include("../conn.php");
        $result = mysqli_query($conn,"SELECT  MAX(id) FROM exams");
        $row = mysqli_fetch_row($result);
        $eid=$row[0];
        $result = mysqli_query($conn,"SELECT subject, class FROM exams where id='$eid'");
        $row = mysqli_fetch_row($result);
        $subject=$row[0];
        $class=$row[1];
        $query = "SELECT * FROM videos WHERE subject='$subject' AND class = '$class' ORDER BY `order`, id"; 
        $reslt = mysqli_query($conn,$query);
           if(isset($_POST['Submit'])){
            if (isset($_POST['video_ids'])) {
                $values = $_POST['video_ids'];         
                foreach ($values as $vid)
                {   
                    $sql = "INSERT INTO svideos (eid, vid) VALUES ('$eid', '$vid')";
                    $result = mysqli_query($conn,$sql);
                    }
            }
            echo '<script>window.location.href="assign_question.php";</script>';
         }
?>




<div id="phase2" class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">
<div class="alert alert-dismissible fade in alert-info fade-out-alert">
<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>Exam step 1 updated successfully!</div>
<div class="row q-data"><div class="col-sm-12 col-md-12 col-lg-9">
<div class="portlet-body"><div class="row"><div class="col-sm-12 col-md-12 col-lg-12">
<ul class="nav nav-wizard nav-wizard-backnav col-md-8" style="float:left;">
<li class="not-active"><a href="#">Create Exam</a></li>
<li class="active"><a href="#">Assign Videos</a></li>
<li class="not-active"><a href="#">Assign Questions</a></li>
</ul>
<hr>
<div class="form-body"><div class="step-nav"><div class="tab-content" id="myTabContent">
<div class="tab-pane fade active in" id="step1">
<div class="row"><div class="col-md-6"><h4>Select Videos</h4></div>

<div class="col-md-6 text-right"></div>
</div>
<form class="form-horizontal" id="new_question"  action="" accept-charset="UTF-8" method="post">
<div class="row"><div class="col-md-12"><div class="table-responsive">
<div class="sort_paginate_ajax">
<table class="table table-hover" id="selected-question">
<thead>
<tr>
<th>Video</th>
<th>Training</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php
                    while($row = mysqli_fetch_array($reslt)){   //Creates a loop to loop through results
                            echo "<tr><td>" . $row['name'] . "</td><td>";
                            $querys ="select * from subjects where id ='".$row['subject']."'";
                            $results = mysqli_query($conn,$querys);
                            while($rows = mysqli_fetch_array($results)){
                                    echo $rows['subject'];
                            }
                            echo "</td>
                            <td><div class='field-actions'><div class='btn-group'>
                            <td><input type='checkbox' name='video_ids[]' id='" . $row['id'] ."' value=" . $row['id'] ."  /></td>
                            </tr>"; 
                        }
                ?>



</tbody>
</table><div class="text-right"></div></div></div></div></div>

<div class="row"><div class="col-md-6"><h4>Assigned Videos</h4></div><div class="col-md-6 text-right"></div></div>
<div class="row assign-scroll">
<div class="col-md-12">
<div class="table-responsive">
<table class="table table-hover" id="allocated-question">
<thead><tr><th>Video</th><th>Training</th><th>Actions</th></tr></thead>
<tbody>
<tr class="no-question-found">
<td class="text-center" colspan="6">No videos found.</td>
</tr>
</tbody>
</table></div></div></div><hr />
<div class="row"><div class="col-md-12">
<div class="btn-row">
<button name="Submit" class="btn green  vx-cust-btn btn-rgt"  >Next</button>
</div></div></div>
</div></div></div></div></div></div></div></div></div></div></div></div></div>
</form>







</div>


</div>

<?php include("includes/footer.php"); ?>
</div>
</body></html>