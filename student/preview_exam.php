<?php   
		session_start();
		include("../conn.php");
		$id=$_GET["q"];
		$proceed="1";
		$queryV = "SELECT * FROM svideos where eid='$id'"; //You don't need a ; like you do in SQL
		$resultV = mysqli_query($conn,$queryV);
		while($row = mysqli_fetch_array($resultV)){
			$vid=$row['vid'];
			$sql = "SELECT * FROM videos where id='$vid'"; //You don't need a ; like you do in SQL
			 $res = mysqli_query($conn,$sql);
			 if ($res->num_rows > 0) {
				// The result has rows, so there are values
				while($rex = mysqli_fetch_array($res)){
					$queryV = "SELECT * FROM stuvideos where vid='".$rex["id"]."' AND sid='".$_SESSION["id"]."'";
					$resV = mysqli_query($conn,$queryV);
					if ($resV->num_rows < 1) {
						echo "<script>window.location.href='video_course.php?e=".$id."';</script>";
					}
				}
			}
		}
		$result = mysqli_query($conn,"SELECT  id,name,subject,class,ins FROM exams WHERE id=$id;");
		
		$row = mysqli_fetch_row($result);
		$subject='';
		$querys ="select * from subjects where id ='".$row[2]."'";
		$results = mysqli_query($conn,$querys);
		while($rows = mysqli_fetch_array($results)){
			$subject= $rows['subject'];
		}
		$eid=$row[0];
		$name=$row[1];
		$class=$row[3];
		$ins=$row[4];
		$query = "SELECT * FROM squestions WHERE eid='$eid'"; 
		$reslt = mysqli_query($conn,$query);
		echo "<input  hidden id='demo' value='" . $id . "' />" ;
		$_SESSION["min"] = 10;
		$_SESSION["sec"] = 00;	
		$_SESSION['fresh']=0;
		$mark=0;
			$query = "SELECT * FROM squestions WHERE eid='$eid'"; 
		   $rest = mysqli_query($conn,$query);
		   while($row = mysqli_fetch_array($rest)){   //Creates a loop to loop through results
					       $qid=$row['qid'];
							$reslt = mysqli_query($conn,"SELECT  marks FROM questions WHERE id=$qid;");
							$rows = mysqli_fetch_row($reslt);	
							$mark=$mark+(int)$rows[0];
							
						}
						
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CBQS</title>
		<meta charset="utf-8"> 
		<meta content="IE=edge" http-equiv="X-UA-Compatible" />
		<meta content="VirtualX is fully automated system which can significantly help your organization to improve the efficiency when it comes to conducting online examinations." name="description" />
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
		<meta content="telephone=no" name="format-detection" />
		<meta content="date=no" name="format-detection" />
		<meta content="address=no" name="format-detection" />
		<meta content="email=no" name="format-detection" />
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/fav.ico" id="favicon" />
		<link rel="stylesheet" media="all" href="assets/css/style.css" />
		<script src="assets/js/demo.js"></script>
		<link rel="stylesheet" href="center/css/font-awesome.min.css">
		<meta name="action-cable-url" content="/cable" />
	</head>
<body>
<div class="content-main"><div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-12">

<div class="row q-data"><div class="col-sm-12 col-md-12 col-lg-12"><div class="portlet-body">
<div class="row"><div class="col-sm-12 col-md-12 col-lg-12">

<div class="row"><div class="col-md-12">

<div class="tab-content tab-content-cust">
<h3 class="text-break">Start Exam</h3>
<p>Best of Luck!</p>
<p><b>Note: </b>Once you Clicked on start then you can not Refresh or Close the page during exam time.</p>
<b>ملاحظة: </b>مجرد أن تضغط زر البدء لا يمكنك الخروج من الاختبار أو إعادة تنشيط الصفحة لأنها قد تختفي</p>
<hr />
<div class="tab-pane fade in active overview-styles" id="overview">
<div class="row overview-mob"><div class="col-sm-6">
<div class="row"><div class="col-xs-6 font-bold">Name :</div><div class="col-xs-6"><?php echo $name; ?></div></div>
<div class="row"><div class="col-xs-6 font-bold">Duration :</div><div class="col-xs-6">00:10:00</div></div>
<div class="row"><div class="col-xs-6 font-bold">Total mark :</div><div class="col-xs-6"><?php echo $mark; 
																							$_SESSION['total']=$mark;
																							?></div></div>
<div class="row"><div class="col-xs-6 font-bold">Batch Courses :</div><div class="col-xs-6"><?php echo $class; ?><br /></div></div>
</div>
<div class="col-sm-6">
<div class="row"><div class="col-xs-6 font-bold">Code :</div><div class="col-xs-6"><?php echo $eid; ?></div></div>
<div class="row"><div class="col-xs-6 font-bold">Training :</div><div class="col-xs-6"><?php echo $subject; ?></div></div>
<div class="row"><div class="col-xs-6 font-bold">Percentage :</div><div class="col-xs-6">50%</div></div>
<div class="row"><div class="col-xs-6 font-bold">Created By :</div><div class="col-xs-6">AMTC</div></div>
</div>
</div>
<div class="row"><div class="col-xs-3 font-bold">Instructions :</div>
<div class="col-xs-9"><p><?php echo $ins; ?></p></div>

</div>
</div>

</div></div></div>
<br><button onClick="myFunction();" class="btn btn-success" name="start">Start إبدأ</button>
</div></div></div></div></div></div>

</div></div></div>
<script>function myFunction() {
	var a="test.php?q=";
	var b=document.getElementById("demo").value;
	var a=a+b;
	window.open(a, "myWindow", "width=1200,height=600");
	window.location.href="dashboard.php";
	}
</script>

</body></html>