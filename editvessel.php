<?php
	require_once ("auth.php");
	require 'db.php';

	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
  header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', false);
  header('Pragma: no-cache'); 
	$_SESSION['reload'] = $_SESSION['reload'] + 1;
// 	Print_r ($_SESSION);
// 	echo "session[reload] = " . $_SESSION['reload'];

  if(!isset ($_SESSION['reload']) && !($_SESSION['reload'] % 2)) {
		$_SESSION['reload'] = $_SESSION['reload'] + 1;
		$uid = $_GET['unique_id'];
    header('Location: http://www.kbbc.co.nz/editvessel.php?unique_id=' . $uid . '&reload=' . $_SESSION['reload'] . '&nocache=' . uniqid());
  	#header('Refresh: 0');
  }
	else {
		$_SESSION['reload'] = $_SESSION['reload'] + 1;
//		echo "session[reload] = " . $_SESSION['reload'];
	}
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
		$uid = $_GET['unique_id']; // the unique ID of the member 
		
		$link = @mysql_connect ($server, $username, $password)
		or die (mysql_error());
		
		if (!@mysql_select_db($database, $link)) {   // leave the database 
		                                           // name as anydb for now
		                                           
		     echo "<p>There has been an error. This is the error message:</p>";
		     echo "<p><strong>" . mysql_error() . "</strong></p>";
		     echo "Please Contant Your Systems Administrator with the details";
		     
		} 

		$query = "SELECT member_id from members WHERE unique_id = \"".$uid."\"";
		$result = mysql_query($query, $link);
		if (!$result) {
		  echo("<p>Error performing query: " . mysql_error() . "</p>");
			mysql_close ($link);
		  exit();
		} 
		
		$row = mysql_fetch_array($result, MYSQL_BOTH);
		$mid = $row['member_id'];

		$query = "SELECT * from vessels WHERE member_id = \"".$mid."\"";
		$result = mysql_query($query, $link);
		if (!$result) {
		  echo("<p>Error performing query: " . mysql_error() . "</p>");
			mysql_close ($link);
		  exit();
		} 
		
		$numRows = mysql_num_rows($result);
		if ($numRows > 0) {
			$query = "SELECT members.member_id, members.first_name, members.last_name, vessels.unique_id, vessels.name, vessels.type, vessels.colour, vessels.length, vessels.beam, vessels.trailer_reg, vessels.radio_callsign, vessels.motor_type, vessels.motor_hp FROM members LEFT JOIN vessels ON members.member_id = vessels.member_id WHERE members.unique_id = \"".$uid."\"";
			$result = mysql_query($query, $link);
			if (!$result) {
			  echo("<p>Error performing query: " . mysql_error() . "</p>");
				mysql_close ($link);
			  exit();
			} 
			
			$firstRow = 1;
			while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	
				$mid = $row['member_id'];
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$vid = $row['unique_id'];
				$vessel_name = $row['name'];
				$type = $row['type'];
				$colour = $row['colour'];
				$length = $row['length'];
				$beam = $row['beam'];
				$trailer_reg = $row['trailer_reg'];
				$radio_callsign = $row['radio_callsign'];
				$motor_type = $row['motor_type'];
				$motor_hp = $row['motor_hp'];
				
				if ($firstRow) {
					$firstRow = 0;
					$vessel = "<h3>Vessels owned by Member ".$mid." - ".$first_name." ".$last_name."</h3>";
					}
	
				$vessel .= "<table align=\"center\" width=\"90%\" border=\"1\">";
				$vessel .= "<tr><td>Name:</td><td class=\"edit\" id=\"".$vid."|name\">".$vessel_name."</td></tr>\n";
				$vessel .= "<tr><td>Type:</td><td class=\"edit\" id=\"".$vid."|type\">".$type."</td></tr>\n";
				$vessel .= "<tr><td>Colour:</td><td class=\"edit\" id=\"".$vid."|colour\">".$colour."</td></tr>\n";
				$vessel .= "<tr><td>Length:</td><td class=\"edit\" id=\"".$vid."|length\">".$length."</td></tr>\n";
				$vessel .= "<tr><td>Beam:</td><td class=\"edit\" id=\"".$vid."|beam\">".$beam."</td></tr>\n";
				$vessel .= "<tr><td>Trailer Reg:</td><td class=\"edit\" id=\"".$vid."|trailer_reg\">".$trailer_reg."</td></tr>\n";
				$vessel .= "<tr><td>Radio Callsign:</td><td class=\"edit\" id=\"".$vid."|radio_callsign\">".$radio_callsign."</td></tr>\n";
				$vessel .= "<tr><td>Motor Type:</td><td class=\"edit\" id=\"".$vid."|motor_type\">".$motor_type."</td></tr>\n";
				$vessel .= "<tr><td>Motor HP:</td><td class=\"edit\" id=\"".$vid."|motor_hp\">".$motor_hp."</td></tr>\n";
				$vessel .= "</table>\n";
				$vessel .= "<p><form name=\"input\" action=\"deletevessel.php\" method=\"get\"><input type=\"hidden\" name=\"unique_id\" value=\"". $vid ."\" /><input type=\"hidden\" name=\"member_unique_id\" value=\"". $uid ."\" /><input type=\"hidden\" name=\"member_id\" value=\"". $mid ."\" /><p><input type=\"submit\" value=\"Delete\" align=\"center\"/></p></form></p>\n";
			}
		}
		else {
		$vessel = "<h3>There are no Vessels registered for Member ".$mid."</h3>";
		}
		
		mysql_close ($link);
		
	?>

	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-30177148-1']);
		_gaq.push(['_trackPageview']);
		
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	
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

			<table align="center" width="800" border="0">	 
				<tr>
					<td align="left" width="40%">
						<a href="editmembers.php"><img src="images/return.png" alt="Return to Edit Active Members page" title="Return to Edit Active Members page" /></a>
					</td>
					<td align="left" width="60%">
						<h3>Vessel Administration</h3>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<form name="input" action="adminvessel.php" method="post">
						<input type="hidden" name="unique_id" value="<?php echo $uid; ?>" />
						<input type="submit" value="Add Vessel for this Member" align="center" />
						</form>
				
						<form name="input" action="editmember.php" method="get">
						<input type="hidden" name="unique_id" value="<?php echo $uid ?>" />
						<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
						<div class="myButton"><input type="submit" value="Edit Member" align="center"/></div>
						</form>
				
						<p>Click on any vessel content below to change the item. Click 'Ok' to save changes or 'Cancel' to retain the original content.</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<hr width="90%">
					</td>
				</tr>
				<tr>
					<td align="center" valign="top" colspan="2">
						<?php
						  echo $vessel;
						?>
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
         indicator : '<img src="images/loading.gif">',
//				 loadurl	 : 'cleandata.php',
         cancel    : 'Cancel',
         submit    : 'OK',
         tooltip   : 'Click to edit...',
				 select		 : true,
				 placeholder : '-'
     });
     $('.edit_area').editable('savevessel.php', { 
         type      : 'textarea',
//				 loadurl	 : 'cleandata.php',
         cancel    : 'Cancel',
         submit    : 'OK',
         indicator : '<img src="images/loading.gif">',
         tooltip   : 'Click to edit...',
				 select		 : true,
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
