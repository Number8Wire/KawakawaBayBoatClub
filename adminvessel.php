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
	
	$uid=$_POST['unique_id'];
	
	$link = @mysql_connect ($server, $username, $password)
	or die (mysql_error());
	
	if (!@mysql_select_db($database, $link)) {   // leave the database 
											   // name as anydb for now
											   
		 echo "<p>There has been an error. This is the error message:</p>";
		 echo "<p><strong>" . mysql_error() . "</strong></p>";
		 echo "Please Contant Your Systems Administrator with the details";
	} 
	
	$sql_query = "SELECT member_id, first_name, last_name FROM members WHERE unique_id=".$uid;
	
	//echo $sql_query;
	
	$result = mysql_query($sql_query, $link);
	if (!$result) {
	  echo("<p>Error performing query: " . mysql_error() . "</p>");
	//	echo $sql_query;
		mysql_close ($link);
	  exit();
	} 
	
	$row = mysql_fetch_row($result);
	$member_id = $row[0];
	$first = $row[1];
	$last = $row[2];
	
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
					<li><a href="weather.html">Weather</a></li>
					<li><a href="webcam.php">WebCam</a></li>
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
				<td align="center" colspan="2">
					<p>Fill in the form below to add a new vessel for <?php echo $first." ".$last; ?>:</p>
					<p class="red">fields marked with * must be filled in</p>
				</td>
			</tr>
			
			<tr>
				<td align="center" colspan="2">
					<table width="80%">
						<!-- heading row -->
						<tr><td class="memberform" align="center"><h4>Vessel Details:</h4></td></tr>
						<form name="vessel" action="adminaddvessel.php" method="post">
							<input type=hidden name="member_id" value="<?php echo $member_id; ?>" />
							<input type=hidden name="member_uid" value="<?php echo $uid; ?>" />
							<!-- Vessel details -->
							<tr><td class="memberform" align="right">Vessel Name: </td><td class="memberform" align="left"><input type="text" name="vesselname" /></td>
							<tr><td class="memberform" align="right">Type: </td><td class="memberform" align="left"><select name="vesseltype"><option value="power">Power</option><option name="sail">Sail</option></select></td>
							<tr><td class="memberform" align="right">Colour: </td><td class="memberform" align="left"><input type="text" name="colour" /></td>
							<tr><td class="memberform" align="right">Length: </td><td class="memberform" align="left"><input type="text" name="length" /></td>
							<tr><td class="memberform" align="right">Beam: </td><td class="memberform" align="left"><input type="text" name="beam" /></td>
							<tr><td class="memberform" align="right">Trailer Registration: </td><td class="memberform" align="left"><input type="text" name="trailer" /></td>
							<tr><td class="memberform" align="right">Radio Call Sign: </td><td class="memberform" align="left"><input type="text" name="radio" /></td>
							<tr><td class="memberform" align="right">Motor Type: </td><td class="memberform" align="left"><select name="motortype"><option value="outboard">Outboard</option><option name="inboard">Inboard</option></select></td>
							<tr><td class="memberform" align="right">Motor Horsepower: </td><td class="memberform" align="left"><input type="text" name="motorhp" /></td>
							<tr>
								<td align="center" colspan="3">
									<input type="submit" value="Submit" />
								</td>
							</tr>
						</form>
					</table>
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
