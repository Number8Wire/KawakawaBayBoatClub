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
//	echo "session[reload] = " . $_SESSION['reload'];

  if(!isset ($_SESSION['reload']) && !($_SESSION['reload'] % 2)) {
		$_SESSION['reload'] = $_SESSION['reload'] + 1;
		$uid = $_GET['unique_id'];
    header('Location: http://www.kbbc.co.nz/editmember.php?unique_id=' . $uid . '&reload=' . $_SESSION['reload'] . '&nocache=' . uniqid());
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
		$uid = $_GET['unique_id']; // the unique ID of the member to edit
		
		$link = @mysql_connect ($server, $username, $password)
		or die (mysql_error());
		
		if (!@mysql_select_db($database, $link)) {   
//		if (!@mysql_select_db("tim_kbbc", $link)) {   
		                                           
		     echo "<p>There has been an error. This is the error message:</p>";
		     echo "<p><strong>" . mysql_error() . "</strong></p>";
		     echo "Please Contant Your Systems Administrator with the details";
		     
		} 

		$query = "SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, '%d/%m/%Y') AS date_pd, renewal_or_new, note FROM members WHERE unique_id =\"".$uid."\"";
		
//		echo ($query);
				
		$result = mysql_query($query, $link);
		if (!$result) {
		  echo("<p>Error performing query: " . mysql_error() . "</p>");
			mysql_close ($link);
		  exit();
		} 
		
		$row = mysql_fetch_array($result, MYSQL_BOTH);
		
		$uid = $row['unique_id'];
		$mid = $row['member_id'];
		$first = $row['first_name'];
		$middle = $row['middle_name'];
		$last = $row['last_name'];
		$salute = $row['salutation'];
		$addr1 = $row['address1'];
		$addr2 = $row['address2'];
		$addr3 = $row['address3'];
		$ph1 = $row['phone1'];
		$ph2 = $row['phone2'];
		$ph3 = $row['phone3'];
		$email = $row['email'];
		$status = $row['status'];
		$date_paid = $row['date_pd'];
		$renewal_or_new = $row['renewal_or_new'];
		$note = $row['note'];

		$member = "<h3>Member ".$mid." - ".$first." ".$last."</h3>";
		$member .= "<table align=\"center\" width=\"90%\" border=\"1\">";
		$member .= "<tr><td>Member ID</td><td class=\"edit\" id=\"".$uid."|member_id\">".$mid."</td></tr>\n";
		$member .= "<tr><td>Salutation</td><td class=\"edit\" id=\"".$uid."|salutation\">".$salute."</td></tr>\n";
		$member .= "<tr><td>First Name</td><td class=\"edit\" id=\"".$uid."|first_name\">".$first."</td></tr>\n";
		$member .= "<tr><td>Middle Name</td><td class=\"edit\" id=\"".$uid."|middle_name\">".$middle."</td></tr>\n";
		$member .= "<tr><td>Last Name</td><td class=\"edit\" id=\"".$uid."|last_name\">".$last."</td></tr>\n";
		$member .= "<tr><td>Address 1</td><td class=\"edit\" id=\"".$uid."|address1\">".$addr1."</td></tr>\n";
		$member .= "<tr><td>Address 2</td><td class=\"edit\" id=\"".$uid."|address2\">".$addr2."</td></tr>\n";
		$member .= "<tr><td>Address 3</td><td class=\"edit\" id=\"".$uid."|address3\">".$addr3."</td></tr>\n";
		$member .= "<tr><td>Phone 1</td><td class=\"edit\" id=\"".$uid."|phone1\">".$ph1."</td></tr>\n";
		$member .= "<tr><td>Phone 2</td><td class=\"edit\" id=\"".$uid."|phone2\">".$ph2."</td></tr>\n";
		$member .= "<tr><td>Phone 3</td><td class=\"edit\" id=\"".$uid."|phone3\">".$ph3."</td></tr>\n";
		$member .= "<tr><td>Email</td><td class=\"edit\" id=\"".$uid."|email\">".$email."</td></tr>\n";
		$member .= "<tr><td>Status</td><td class=\"edit\" id=\"".$uid."|status\">".$status."</td></tr>\n";
		$member .= "<tr><td>Date Paid</td><td class=\"edit\" id=\"".$uid."|date_paid\">".$date_paid."</td></tr>\n";
		$member .= "<tr><td>Renewal or New</td><td class=\"edit\" id=\"".$uid."|renewal_or_new\">".$renewal_or_new."</td></tr>\n";
		$member .= "<tr><td>Note</td><td class=\"edit\" id=\"".$uid."|note\">".$note."</td></tr>\n";
		$member .= "</table>\n";
		
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
					<td align="left" width="45%">
						<a href="editmembers.php"><img src="images/return.png" alt="Return to Edit Active Members page" title="Return to Edit Active Members page" /></a>
					</td>
					<td align="left" width="55%">
						<h3>Edit Member</h3>
					</td>
				</tr>
				<tr>
				<td colspan="2">
					<form name="input" action="editvessel.php" method="get">
					<input type="hidden" name="unique_id" value="<?php echo $uid ?>" />
					<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
					<div class="myButton"><input type="submit" value="Edit Vessel" align="center"/></div>
					</form>
			
					<p>Click on any member content below to change the item. Click 'Ok' to save changes or 'Cancel' to retain the original content.</p>
					<p>Click on the 'Delete' button at the bottom of the page to delete the member</p>
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
						  echo $member;
						?>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<hr width="800" align="center">
					</td>
				</tr>
		
				<tr>
					<td align="center" valign="top" colspan="2">
						<form name="input" action="deletemember.php" method="get"><input type="hidden" name="unique_id" value="<?php echo $uid; ?>" /><p><input type="submit" value="Delete" align="center"/></p></form>
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

			$('.edit').editable('savemember.php', {
	//				 loadurl	 : 'cleandata.php',
				indicator : "<img src='images/loading.gif'>",
				cancel    : 'Cancel',
				submit    : 'OK',
				tooltip   : 'Click to edit...',
					select		 : true,
					placeholder : '-'
			});
			$('.edit_area').editable('savemember.php', { 
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
