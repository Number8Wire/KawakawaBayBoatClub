<?php
	require_once ("auth.php");
	require 'db.php';

	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache'); 
	$_SESSION['reload'] = $_SESSION['reload'] + 1;

  if(!isset ($_SESSION['reload']) && !($_SESSION['reload'] % 2)) {
		$_SESSION['reload'] = $_SESSION['reload'] + 1;
    header('Location: http://www.kbbc.co.nz/editdeletedmembers.php?&reload=' . $_SESSION['reload'] . '&nocache=' . uniqid());
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
	<link href="css/popupmenu.css" rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" href="kbbc.ico" type="image/x-icon" />

	<?php
		if (!empty($_GET)) {
			$column = $_GET['search_column']; // the database table field to search on
			$criteria = $_GET['search_criteria']; // the search criteris - 'LIKE' or '="
			$text = $_GET['search_text']; // the text to search for
		}
		else {
			$column = "";
			$criteria = "";
			$text = "";
		}
		
		// create form for search criteria
		$search_html = "<select name=\"search_column\"  />";
		$search_html .= "<option value=\"last_name\""; if ($column == "last_name") { $search_html .= " selected=\"selected\""; } $search_html .= ">Last Name</option>\n";
		$search_html .= "<option value=\"first_name\""; if ($column == "first_name") { $search_html .= " selected=\"selected\""; } $search_html .= ">First Name</option>\n";
		$search_html .= "<option value=\"middle_name\""; if ($column == "middle_name") { $search_html .= " selected=\"selected\""; } $search_html .= ">Middle Name</option>\n";
		$search_html .= "<option value=\"address\""; if ($column == "address") { $search_html .= " selected=\"selected\""; } $search_html .= ">Address</option>\n";
		$search_html .= "<option value=\"phone\""; if ($column == "phone") { $search_html .= " selected=\"selected\""; } $search_html .= ">Phone</option>\n";
		$search_html .= "<option value=\"email\""; if ($column == "email") { $search_html .= " selected=\"selected\""; } $search_html .= ">Email</option>\n";
		$search_html .= "<option value=\"status\""; if ($column == "status") { $search_html .= " selected=\"selected\""; } $search_html .= ">Status</option>\n";
		$search_html .= "<option value=\"member_id\""; if ($column == "member_id") { $search_html .= " selected=\"selected\""; } $search_html .= ">Member ID</option>\n";
		$search_html .= "</select>\n";
		$search_html .= "Search Criteria: \n";
		$search_html .= "<select name=\"search_criteria\"  /> \n";
		$search_html .= "<option value=\"LIKE\""; if ($criteria == "LIKE") { $search_html .= " selected=\"selected\""; } $search_html .= ">contains</option>\n";
		$search_html .= "<option value=\"=\""; if ($criteria == "=") { $search_html .= " selected=\"selected\""; } $search_html .= ">exactly matches</option>\n";
		$search_html .= "</select>\n";

		$link = @mysql_connect ($server, $username, $password)
		or die (mysql_error());
		
		if (!@mysql_select_db($database, $link)) {   // leave the database 
		                                           // name as anydb for now
		                                           
		     echo "<p>There has been an error. This is the error message:</p>";
		     echo "<p><strong>" . mysql_error() . "</strong></p>";
		     echo "Please Contant Your Systems Administrator with the details";
		     
		} 

		if ($column == 'ALL' || empty($column)) {
			$query = "SELECT * FROM members WHERE membership_status = \"Deleted\" ORDER BY member_id ASC";
		}
		elseif ($column == "address" && $criteria == "LIKE") {
			$query = "SELECT * FROM members WHERE (address1 LIKE \"%".$text."%\" OR address2 LIKE \"%".$text."%\" OR address3 LIKE \"%".$text."%\") AND stamembership_tus = \"Deleted\" ORDER BY member_id ASC";
		}
		elseif ($column == "address" && $criteria == "=") {
			$query = "SELECT * FROM members WHERE (address1 = \"".$text."\" OR address2 = \"".$text."\" OR address3 = \"".$text."\") AND membership_status = \"Deleted\" ORDER BY member_id ASC";
		}
		elseif ($column == "phone" && $criteria == "LIKE") {
			$query = "SELECT * FROM members WHERE (phone1 LIKE \"%".$text."%\" OR phone2 LIKE \"%".$text."%\" OR phone3 LIKE \"%".$text."%\") AND membership_status = \"Deleted\" ORDER BY member_id ASC";
		}
		elseif ($column == "phone" && $criteria == "=") {
			$query = "SELECT * FROM members WHERE (phone1 = \"".$text."\" OR phone2 = \"".$text."\" OR phone3 = \"".$text."\") AND membership_status = \"Deleted\" ORDER BY member_id ASC";
		}
		elseif ($criteria == "LIKE") {
			$query = "SELECT * FROM members WHERE ".$column." LIKE \"%".$text."%\" AND membership_status = \"Deleted\" ORDER BY member_id ASC";
		}
		else {
			$query = "SELECT * FROM members WHERE ".$column." ".$criteria." \"".$text."\" AND membership_status = \"Deleted\" ORDER BY member_id ASC";
		}
				
		$result = mysql_query($query, $link);
		if (!$result) {
		  echo("<p>Error performing query: " . mysql_error() . "</p>");
			mysql_close ($link);
		  exit();
		} 
		
		$members = "<table class=\"sortable\" width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\"><tr><th class=\"small\">Member ID</th><th class=\"small\">Salutation</th><th class=\"small\">First Name</th><th class=\"small\">Middle Name</th><th class=\"small\">Last Name</th><th class=\"small\">Address 1</th><th class=\"small\">Address 2</th><th class=\"small\">Address 3</th><th class=\"small\">Phone 1</th><th class=\"small\">Phone 2</th><th class=\"small\">Phone 3</th><th class=\"small\">Email</th><th class=\"small\">Status</th><th class=\"small\">Membership Status</th></tr>\n";
		while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
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
			$membership_status = $row['membership_status'];

			$members .= "<tr><td>".$mid."</td><td>".$salute."</td><td>".$first."</td><td>".$middle."</td><td>".$last."</td><td>".$addr1."</td><td>".$addr2."</td><td>".$addr3."</td><td>".$ph1."</td><td>".$ph2."</td><td>".$ph3."</td><td>".$email."</td><td>".$status."</td><td>".$membership_status."</td><td>";
			$members .= "<form name=\"input\" action=\"activatemember.php\" method=\"get\"><input type=\"hidden\" name=\"unique_id\" value=\"".$uid."\" /><p><input type=\"submit\" value=\"Activate\" align=\"center\"/></p></form>";
			$members .= "<form name=\"input\" action=\"deletememberpermanently.php\" method=\"get\"><input type=\"hidden\" name=\"unique_id\" value=\"".$uid."\" /><p><input type=\"submit\" value=\"Delete Permanently\" align=\"center\"/></p></form>";
			$members .= "</td></tr>\n";
		}	
		$members .= "</table>\n";
		
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
			<h3>Deleted Member Administration</h3>
			<p>Click on any member content below to change the item. Click 'Ok' to save changes or 'Cancel' to retain the original content.</p>
			<p>To re-activate a member click on the 'Activate' button to the right of each member.</p>
			<a href="editmembers.php"><img src="images/return.png" alt="Return to Edit Active Members page" title="Return to Edit Active Members page" /></a>
			<hr width="90%">
			<p>Search for Deleted Members where:</p>
			<form name="input" action="#" method="get">
				Column: 
	<!--			<select name="search_column"  /> 
					<option value="first_name">First Name</option>
					<option value="middle_name">Middle Name</option>
					<option value="last_name" selected="selected">Last Name</option>
					<option value="address">Address</option>
					<option value="phone">Phone</option>
					<option value="email">Email</option>
					<option value="status">Status</option>
				</select>
				Search Criteria: 
				<select name="search_criteria"  /> 
					<option value="=">exactly matches</option>
					<option value="LIKE">contains</option>
				</select> -->
				<?php echo $search_html; ?>
				<p>Search Text: </p>
				<input type="text" name="search_text"  /> 
				<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
				<input type="submit" value="Search" align="center"/>
			</form>

			<form name="clearfilters" action="#" method="get">
				<input type=hidden name="search_column" value="ALL" /> 
				<input type=hidden name="search_criteria" value="" /> 
				<input type=hidden name="search_text" value="" /> 
				<input type="submit" value="Show All" align="center"/>
			</form>

			<hr width="90%">

			<?php
			  echo $members;
			?>

			<hr width="800" align="center">
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