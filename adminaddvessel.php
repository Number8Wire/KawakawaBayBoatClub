<?php
	require_once ("auth.php");
	require 'db.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!-- Created on: 12/12/2009 -->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
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

	<?php
		$member_uid=$_POST['member_uid'];
		$member_id=$_POST['member_id'];
		if (!empty($_POST['vesselname'])) { $vessel_name=$_POST['vesselname']; } else { $vessel_name=NULL;  }
		$vessel_type=$_POST['vesseltype'];
		if (!empty($_POST['colour'])) { $vessel_colour=$_POST['colour']; } else { $vessel_colour=NULL;  }
		if (!empty($_POST['length'])) { $vessel_length=$_POST['length']; } else { $vessel_length=NULL;  }
		if (!empty($_POST['beam'])) { $vessel_beam=$_POST['beam']; } else { $vessel_beam=NULL;  }
		if (!empty($_POST['trailer'])) { $trailer_reg=$_POST['trailer']; } else { $trailer_reg=NULL;  }
		if (!empty($_POST['radio'])) { $radio_call=$_POST['radio']; } else { $radio_call=NULL;  }
		$motor_type=$_POST['motortype'];
		if (!empty($_POST['motorhp'])) { $motor_hp=$_POST['motorhp']; } else { $motor_hp=NULL;  }
//		echo "member_uid=$member_uid, member_id=$member_id, vessel_name=$vessel_name, vessel_type=$vessel_type, vessel_colour=$vessel_colour, ";
//		echo "vessel_length=$vessel_length, vessel_beam=$vessel_beam, trailer_reg=$trailer_reg, radio_call=$radio_call, motor_type=$motor_type, motor_hp=$motor_hp.";

		// Create connection
		$conn = new mysqli($server, $username, $password, $database);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$query = "SELECT SQL_NO_CACHE first_name, last_name FROM members WHERE member_id =?";
		if ($stmt = $conn->prepare($query)) {
			/* bind statement variable */
			$stmt->bind_param('i', $member_id);
			/* execute statement */
			$stmt->execute();
			/* bind result variables */
			$stmt->bind_result($first_name, $last_name);
			/* fetch values */
			while ($stmt->fetch()) {
//				printf ("%s (%s)\n", $first_name, $last_name);
			}
			/* close statement */
			$stmt->close();
		}		

		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO vessels (member_uid, member_id, name, type, colour, length, beam, trailer_reg, radio_callsign, motor_type, motor_hp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
//		if (false===$stmt) {die('prepare() failed: ' . htmlspecialchars($mysqli->error));}
		$stmt->bind_param("iisssssssss", $member_uid, $member_id, $vessel_name, $vessel_type, $vessel_colour, $vessel_length, $vessel_beam, $trailer_reg, $radio_call, $motor_type, $motor_hp);
//		if (false===$stmt) {die('bind_param() failed: ' . htmlspecialchars($mysqli->error));}
		$stmt->execute();
//		if (false===$stmt) {die('execute() failed: ' . htmlspecialchars($mysqli->error));}
		
		// get the automatically generated unique id for this vessel
		$vid = mysqli_insert_id($conn);

		$stmt->close();
		$conn->close();		

/*		$link = @mysql_connect ($server, $username, $password)
		or die (mysql_error());
		
		if (!@mysql_select_db($database, $link)) {   // leave the database 
		                                           // name as anydb for now
		                                           
		     echo "<p>There has been an error. This is the error message:</p>";
		     echo "<p><strong>" . mysql_error() . "</strong></p>";
		     echo "Please Contant Your Systems Administrator with the details";
		     
		} 

		// get the member first and last names		
		$sql_query = "SELECT SQL_NO_CACHE first_name, last_name FROM members WHERE member_id =\"".$member_id."\"";
		
//		echo ($query);
				
		$result = mysql_query($sql_query, $link);
		if (!$result) {
		  echo("<p>Error performing query: " . mysql_error() . "</p>");
			mysql_close ($link);
		  exit();
		} 
		
		$row = mysql_fetch_row($result);
		
		$first_name = $row[0];
		$last_name = $row[1];
		
		//insert the vessel details into the vessel table
		$sql_query = "INSERT INTO vessels ";
		$sql_query .= "(member_uid, member_id, name, type, colour, length, beam, trailer_reg, radio_callsign, motor_type, motor_hp)";
		$sql_query .= "VALUES (";
		$sql_query .= "'$member_uid', ";
		$sql_query .= "'$member_id', ";
		$sql_query .= "'$vessel_name', ";
		$sql_query .= "'$vessel_type', ";
		$sql_query .= "'$vessel_colour', ";
		$sql_query .= "'$vessel_length', ";
		$sql_query .= "'$vessel_beam', ";
		$sql_query .= "'$trailer_reg', ";
		$sql_query .= "'$radio_call', ";
		$sql_query .= "'$motor_type', ";
		$sql_query .= "'$motor_hp')";

		$sql_result = mysql_query($sql_query, $link);
		if (!$sql_result) {
		  echo("<p>Could not insert the Vessel information: " . mysql_error() . "</p>");
			mysql_close ($link);
		  exit();
		} 
		
		// get the automatically generated unique id for this vessel
		$vid = mysql_insert_id();
		
		mysql_close($link);
		
//		echo("uid: ".$uid.", mid: ".$mid);
*/		
	?>

</head>
<body data-spy="scroll" data-target="#navbar">
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
					<li><a href="admin.php">Admin Home</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">News <span class="caret"</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="editnews.php">Edit News Items</a></li>
                            <li><a href="uploadnewsletter.php">Upload Newsletter</a></li>
                        </ul>
					</li>
					<li class="active dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Members <span class="caret"</span></a>
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

			<table align="center" width="800">	 
			
			<tr>
			
				<td align="left" width="40%">
					<a href="editmembers.php"><img src="images/return.png" alt="Return to Edit Active Members page" title="Return to Edit Active Members page" /></a>
				</td>
			
				<td align="left" width="60%">
					<h3>New Vessel Administration</h3>
				</td>
				
			</tr>
			
			<tr>
				<td align="left" colspan="2" width="70%">
					<p align="center">The new vessel has been added for <?php echo ("$first_name $last_name"); ?>:</p>
					<?php	
						$vessel = "<table align=\"center\" width=\"90%\" border=\"1\">";
						$vessel .= "<tr><td>Name:</td><td class=\"edit\" id=\"".$vid."|name\">".$vessel_name."</td></tr>\n";
						$vessel .= "<tr><td>Type:</td><td class=\"edit\" id=\"".$vid."|type\">".$vessel_type."</td></tr>\n";
						$vessel .= "<tr><td>Colour:</td><td class=\"edit\" id=\"".$vid."|colour\">".$vessel_colour."</td></tr>\n";
						$vessel .= "<tr><td>Length:</td><td class=\"edit\" id=\"".$vid."|length\">".$vessel_length."</td></tr>\n";
						$vessel .= "<tr><td>Beam:</td><td class=\"edit\" id=\"".$vid."|beam\">".$vessel_beam."</td></tr>\n";
						$vessel .= "<tr><td>Trailer Reg:</td><td class=\"edit\" id=\"".$vid."|trailer_reg\">".$trailer_reg."</td></tr>\n";
						$vessel .= "<tr><td>Radio Callsign:</td><td class=\"edit\" id=\"".$vid."|radio_callsign\">".$radio_call."</td></tr>\n";
						$vessel .= "<tr><td>Motor Type:</td><td class=\"edit\" id=\"".$vid."|motor_type\">".$motor_type."</td></tr>\n";
						$vessel .= "<tr><td>Motor HP:</td><td class=\"edit\" id=\"".$vid."|motor_hp\">".$motor_hp."</td></tr>\n";
						$vessel .= "</table>\n";
				
						echo $vessel;
					?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<hr width="800" align="center">
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<p class="footer" align="center"><a href="logout.php">Logout</a> | <a href="admin.php">Admin Home</a> | <a href="editnews.php">News</a> | <a href="editmembers.php">Members</a> | <a href="editgallery.php">Photo Gallery</a> | <a href="newsletter.php">News Letter</a></p>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<p class="footer"><a href="http://www.number8wire.co.nz" target="_blank" class="nulblack">Website by Number 8 Wire Design</a></p>
				</td>
			</tr>
			
			</table>   
		</div>
	</div>
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
	<script type="text/javascript" src="js/jquery.jeditable.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {
		$('.edit').editable('savevessel.php', {
			indicator : "<img src='images/loading.gif'>",
			cancel    : 'Cancel',
			submit    : 'OK',
			tooltip   : 'Click to edit...',
			placeholder : '-'
		});
    $('.edit_area').editable('savevessel.php', { 
        type      : 'textarea',
        cancel    : 'Cancel',
        submit    : 'OK',
        indicator : '<img src="images/loading.gif">',
        tooltip   : 'Click to edit...',
		placeholder : '-'
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
src="http://www.statcounter.com/counter/counter.js"></script>
<noscript><div class="statcounter"><a title="tumblr
visitor" href="http://statcounter.com/tumblr/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/7772754/0/1e02e638/1/"
alt="tumblr visitor"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

</body>
</html>
