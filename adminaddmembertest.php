<?php
  require_once ("auth.php");
  require 'dbtest.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!-- Created on: 12/12/2009 -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Kawakawa Bay Boat Club</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Number 8 Wire Design Ltd">
	<meta name="generator" content="AceHTML Freeware">
  
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
  
    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">
    <link href="css/login-modal.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
    <link href="css/styles.css" rel="stylesheet">

	<link rel="shortcut icon" href="kbbc.ico" type="image/x-icon" />

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.jeditable.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
     $('.edit').editable('savemember.php', {
         indicator : "<img src='images/loading.gif'>",
         cancel    : 'Cancel',
// 				 loadurl	 : 'cleandata.php',
         submit    : 'OK',
         tooltip   : 'Click to edit...',
				 placeholder : '-'
     });
     $('.edit_area').editable('savemember.php', { 
         type      : 'textarea',
// 				 loadurl	 : 'cleandata.php',
         cancel    : 'Cancel',
         submit    : 'OK',
         indicator : '<img src="images/loading.gif">',
         tooltip   : 'Click to edit...',
				 placeholder : '-'
     });
	 });	
 	</script>

	<?php
		$first_name="Tim";
		$middle_name="Test";
		$last_name="Seabrook";
		$salutation="Mr"; $salutation = $salutation . " " . $first_name[0];
		$address1="532 Ness";
		$address2="";
		$address3="";
		$homeph="092928989";
		$businessph="";
		$mobileph="";
		$email="tim@number8wire.co.nz";

		if (isset ($_POST['vesselname'])) { $vessel_name=$_POST['vesselname']; } else { $vesselname=""; }
		if (isset ($_POST['vesseltype'])) { $vessel_type=$_POST['vesseltype']; } else { $vessel_type=""; }
		if (isset ($_POST['colour'])) { $vessel_colour=$_POST['colour']; } else { $vessel_colour=""; }
		if ($_POST['length']!="") { $vessel_length=$_POST['length']; } else { $vessel_length=0;}
		if ($_POST['beam']!="") { $vessel_beam=$_POST['beam']; } else { $vessel_beam=0; }
		if (isset ($_POST['trailer'])) { $trailer_reg=$_POST['trailer']; } else { $trailer_reg=""; }
		if (isset ($_POST['radio'])) { $radio_call=$_POST['radio']; } else { $radio_call=""; }
		if (isset ($_POST['motortype'])) { $motor_type=$_POST['motortype']; } else { $motor_type=""; }
		if ($_POST['motorhp']!="") { $motor_hp=$_POST['motorhp']; } else { $motor_hp=0; }

		// Create connection
		$conn = new mysqli($server, $username, $password, $database);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$query_getmissingnumber = "SELECT l.member_id + 1 AS START FROM members as l LEFT OUTER JOIN members AS r ON l.member_id + 1 = r.member_id WHERE r.member_id is NULL";
		
		if ($stmt = $conn->prepare($query_getmissingnumber)) {
			/* execute statement */
			$stmt->execute();
			/* bind result variables */
			$result = $stmt->store_result();
			$stmt->bind_result($lowest);
			/* fetch values */
			while ($stmt->fetch()) {
				//echo("</p>lowest - ".$lowest.".</p>");
			}
			/* close statement */
			$stmt->close();
		}
		else {
		  echo("<p>Error performing query to get lowest missing Member Number: " . $conn->error . "</p>");
		  $stmt->close();
		  exit();
		} 
		
		$new_member_id = strval($lowest);
    
    if (empty($new_member_id)) {
      //echo("<p>new_member_id is empty</p>");
      // get highest member_id
      $conn = new mysqli($server, $username, $password, $database);
      $con = mysqli_connect($server, $username, $password) or die($connect_error);
      mysqli_select_db($con, $database) or die($connect_error);
      $result = mysqli_query($con, "SELECT MAX(CAST(member_id AS UNSIGNED)) + 1 AS highest_id FROM members");
      while ($row = mysqli_fetch_assoc($result)) {
        $highest = $row['highest_id'];             
      }
      //echo("</p>highest - ".$highest.".</p>");
      $new_member_id = $highest;
      mysqli_free_result($result);
      mysqli_close($con); 
    }
		
		$year = date("Y");
		$month = date("n");
		
		if ($month > 9) {$year++;}

		//insert member data into the member table
		$sql_query = "INSERT into members ";
		$sql_query .= "(member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, membership_status, date_paid, renewal_or_new, application_date)";
		$sql_query .= "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),?,NOW())";
		//echo("<p>sql_query to insert member - ".$sql_query.".</p>");

		if ($stmt = $conn->prepare($sql_query)) {
		  /* Binds variables to prepared statement
		  i    corresponding variable has type integer
		  d    corresponding variable has type double
		  s    corresponding variable has type string
		  b    corresponding variable is a blob and will be sent in packets */
		  $member_status="Active";
		  $new = "N";
		  $stmt->bind_param('sssssssssssssss',$new_member_id, $first_name, $middle_name, $last_name, $salutation, $address1, $address2, $address3, $homeph, $businessph, $mobileph, $email, $year, $member_status, $new);
		  //echo('<p> insert variables - sssssssssssssss - '.$new_member_id.','.$first_name.','.$middle_name.','.$last_name.','.$salutation.','.$address1.','.$address2.','.$address3.','.$homeph.','.$businessph.','.$mobileph.','.$email.','.$year.','.$member_status.','.$new.'.</p>');
		  /* execute statement */
		  $stmt->execute();
		  // get the automatically generated unique id for this vessel
		  $new_member_uid = mysqli_insert_id($conn);
			//echo("<p>new_member_uid - ".$new_member_uid.".</p>");
		  $stmt->close();
		}
		else {
		  echo("<p>Error inserting Member: " . $conn->error . "</p>");
		  $stmt->close();
		  exit();
		} 

		//insert the vessel details into the vessel table
		$sql_query = "INSERT INTO vessels ";
		$sql_query .= "(member_uid, member_id, name, type, colour, length, beam, trailer_reg, radio_callsign, motor_type, motor_hp)";
		$sql_query .= "VALUES (?,?,?,?,?,?,?,?,?,?,?)";

		if ($stmt = $conn->prepare($sql_query)) {
		  /* Binds variables to prepared statement
		  i    corresponding variable has type integer
		  d    corresponding variable has type double
		  s    corresponding variable has type string
		  b    corresponding variable is a blob and will be sent in packets */
		  $stmt->bind_param('issssssssss',$new_member_uid, $new_member_id, $vessel_name, $vessel_type, $vessel_colour, $vessel_length, $vessel_beam, $trailer_reg, $radio_call, $motor_type, $motor_hp);
		  /* execute statement */
		  $stmt->execute();
		  $stmt->close();
		}
		else {
		  echo("<p>Error inserting Vessel: " . $conn->error . "</p>");
		  $stmt->close();
		  exit();
		} 

		//get the details for the new member		
		$sql_query = "SELECT unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, '%d/%m/%Y') AS date_pd, renewal_or_new, note FROM members WHERE member_id = ?";
		//echo("sql_query to get member details - ".$sql_query.".");
		if ($stmt = $conn->prepare($sql_query)) {
		  /* Binds variables to prepared statement
		  i    corresponding variable has type integer
		  d    corresponding variable has type double
		  s    corresponding variable has type string
		  b    corresponding variable is a blob and will be sent in packets */
		  $stmt->bind_param('s',$new_member_id);
		  /* execute statement */
		  $stmt->execute();
		  $stmt->store_result();
			//echo("stmt->num_rows - ".$stmt->num_rows.".");
		  if($stmt->num_rows === 0) exit('Error - No rows for new member!');
		  $stmt->bind_result($uid, $mid, $first, $middle, $last, $salute, $addr1, $addr2, $addr3, $ph1, $ph2, $ph3, $email, $status, $date_paid, $renewal_or_new, $note);
		  $stmt->fetch();
		  $stmt->close();
		}
		else {
		  echo("<p>Error getting new Member: " . $conn->error . "</p>");
		  $stmt->close();
		  exit();
		} 
		
		$memberTitle = "<h3>Member ".$mid." - ".$first." ".$last."</h3>";
		$member = "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Member ID:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$mid."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Vessel Name:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$vessel_name."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Salutation:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$salute."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Vessel Type:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$vessel_type."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">First Name:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$first."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Vessel Colour:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$vessel_colour."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Middle Name:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$middle."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Vessel Length:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$vessel_length."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Last Name:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$last."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Vessel Beam:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$vessel_beam."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Address 1:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$addr1."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Trailer Reg:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$trailer_reg."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Address 2:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$addr2."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Radio Call:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$radio_call."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Address 3:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$addr3."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Motor Type:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$motor_type."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Phone 1:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$ph1."</td>\n";
		$member .= "<td align=\"right\" class=\"padding_right_10\" width=\"25%\">Motor HP:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$motor_hp."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Phone 2:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$ph2."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Phone 3:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$ph3."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Email:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$email."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Status:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$status."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Date Paid:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$date_paid."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Renewal or New:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$renewal_or_new."</td></tr>\n";
		$member .= "<tr><td align=\"right\" class=\"padding_right_10\" width=\"25%\">Note:&nbsp</td><td  align=\"left\" class=\"padding_left_10\" width=\"25%\">".$note."</td></tr>\n";
//		echo("uid: ".$uid.", mid: ".$mid);
		
	?>

</head>
<body data-spy="scroll" data-target="#navbar">
  
  <?php include_once("googleAnalyticsTracking.php") ?>

    <nav class="navbar navbar-kbbc navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Kawakawa Bay Boat Club</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="admin.php">Admin Home</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">News <span class="caret"</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="editnews.php">Edit News Items</a></li>
                            <li><a href="uploadnewsletter.php">Upload Newsletter</a></li>
                        </ul>
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Members <span class="caret"</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="editmembers.php">Edit Active Members</a></li>
                            <li><a href="editdeletedmembers.php">Edit Deleted Members</a></li>
                            <li><a href="membermailmergeall.php">Member Mail Merge (All)</a></li>
                            <li><a href="membermailmergefinancial.php">Member Mail Merge (Financial)</a></li>
                            <li><a href="memberdownload.php">Member Database Download</a></li>
                            <li><a href="uploadmembershipform.php">Upload Membership Form</a></li>
                            <li><a href="memberstats.php">Member Statistics</a></li>
                        </ul>
					</li>
<!--					<li><a href="editvessels.php">Vessels</a></li> -->
					<li><a href="editgallery.php">Photo Gallery</a></li>
					<li><a href="weatheradmin.html">Weather</a></li>
					<li><a href="webcamadmin.php">WebCam</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div> <!--/.nav-collapse -->
		</div>
	</nav>

    <!-- Home Page
    ================================================== -->
	<div class="container">
		<div id="home" class="starter-template">
			<img src="images/KBBC-Ramp-2.jpg" class="img-responsive center-block" alt="Kawakawa Bay Boat Club" border="0">
			<h3>New Member Administration</h3>
			<p align="center">The new member has been added:</p>
			<hr width="50%">
			<?php echo $memberTitle; ?>
			<table border="0" width="90%">
			<?php echo $member; ?>
			<tr>
			  <td colspan="2">
				<form name="input" action="editmember.php" method="get">
				<input type="hidden" name="unique_id" value="<?php echo $uid ?>" />
				<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
				<div class="myButton"><input type="submit" value="Edit Member" align="center"/></div>
				</form>
			  </td>
			  <td colspan="2">
				<form name="input" action="editvessel.php" method="get">
				<input type="hidden" name="unique_id" value="<?php echo $uid ?>" />
				<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
				<div class="myButton"><input type="submit" value="Edit Vessel" align="center"/></div>
			  </td>
			</tr>
			</table>
			<hr width="50%">
		</div>
	</div><!-- /.container -->

    <!-- Footer
    ================================================== -->
	<div id="footer" class="container">
		<div class="footer navbar-bottom">
			<hr class="black">
			<p align="center"><a href="logout.php">Logout</a> | <a href="admin.php">Admin Home</a> | <a href="editnews.php">News</a> | <a href="editmembers.php">Members</a> | <a href="editvessels.php">Vessels</a> | <a href="editgallery.php">Photo Gallery</a> | <a href="newsletter.php">News Letter</a> | <i class="fa fa-copyright"></i> Number 8 Wire Design</p>
		</div>
	</div><!-- /.container -->

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery-1.12.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="js/ie10-viewport-bug-workaround.js"></script>

    <script>
	    $(document).ready(function(){
	    	$(document).on('click','.signin-tab',function(e){
	    		 e.preventDefault();
	    		 $('#signin-taba').tab('show');
	    	});

			$("#contact-submit").click(function(){
				$.ajax({
					type: "POST",
					url: "contact email send.php", //process to mail
					data: $('form.contact').serialize(),
					success: function(msg){
						$("#thanks").html(msg) //populate thank you
						$("#contact-form-content").modal('hide'); //hide popup  
						$("#thanks-content").modal('show'); //show thank you
					},
					error: function(){
						alert("failure");
					}
				});
			});
	    });	
    </script>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
	var sc_project=7772754; 
	var sc_invisible=1; 
	var sc_security="1e02e638"; 
</script>
<script type="text/javascript"
	src="http://www.statcounter.com/counter/counter.js">
</script>
<noscript><div class="statcounter"><a title="tumblr
visitor" href="http://statcounter.com/tumblr/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/7772754/0/1e02e638/1/"
alt="tumblr visitor"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

</body>
</html>