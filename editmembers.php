<?php
	require_once ("auth.php");
	require 'db.php';

	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache'); 

	if(!isset ($_SESSION['reload']) && !($_SESSION['reload'] % 2)) {
		$_SESSION['reload'] = $_SESSION['reload'] + 1;
	    header('Location: http://www.kbbc.co.nz/editmembers.php?&reload=' . $_SESSION['reload'] . '&nocache=' . uniqid());
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
			$column = "last_name";
			$criteria = "LIKE";
			$text = '***';
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

		if ($column == "date_paid")
			{
			$date_value = explode("/", $text);
			$text = $date_value[2] . "-" . $date_value[1] . "-" . $date_value[0];
//			echo $text;
			}

		if ($criteria == "ALL") {
			ini_set('max_execution_time', 300); // Allow 5 minutes for execution
//			set_time_limit (0);
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members ORDER BY last_name ASC';
		}
		elseif ($column == "address" && $criteria == "LIKE") {
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members WHERE (address1 LIKE "%'.$text.'%" OR address2 LIKE "%'.$text.'%" OR address3 LIKE "%'.$text.'%") AND membership_status != "Deleted" ORDER BY last_name ASC';
		}
		elseif ($column == "address" && $criteria == "=") {
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members WHERE (address1 = "'.$text.'" OR address2 = "'.$text.'" OR address3 = "'.$text.'") AND membership_status != "Deleted" ORDER BY last_name ASC';
		}
		elseif ($column == "phone" && $criteria == "LIKE") {
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members WHERE (phone1 LIKE "%'.$text.'%" OR phone2 LIKE "%'.$text.'%" OR phone3 LIKE "%'.$text.'%") AND membership_status != "Deleted" ORDER BY last_name ASC';
		}
		elseif ($column == "phone" && $criteria == "=") {
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members WHERE (phone1 = "'.$text.'" OR phone2 = "'.$text.'" OR phone3 = "'.$text.'") AND membership_status != "Deleted" ORDER BY last_name ASC';
		}
		elseif ($column == "status" && $criteria == "LIKE") {
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members WHERE status LIKE "%'.$text.'%" AND membership_status != "Deleted" ORDER BY last_name ASC';
		}
		elseif ($column == "status" && $criteria == "=") {
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members WHERE status = "'.$text.'" AND membership_status != "Deleted" ORDER BY last_name ASC';
		}
		elseif ($column == "trailer_reg") {
			$query = 'SELECT SQL_NO_CACHE members.unique_id, members.member_id, members.first_name, members.middle_name, members.last_name, members.salutation, members.address1, members.address2, members.address3, members.phone1, members.phone2, members.phone3, members.email, members.status, DATE_FORMAT(members.date_paid, "%d/%m/%Y") AS date_pd, members.renewal_or_new, members.note FROM members INNER JOIN vessels ON members.member_id=vessels.member_id WHERE REPLACE (vessels.trailer_reg, " ", "") = REPLACE ("'.$text.'", " ", "") AND members.membership_status != "Deleted" ORDER BY last_name ASC';
		}
		elseif ($column == "boat_name") {
			$query = 'SELECT SQL_NO_CACHE members.unique_id, members.member_id, members.first_name, members.middle_name, members.last_name, members.salutation, members.address1, members.address2, members.address3, members.phone1, members.phone2, members.phone3, members.email, members.status, DATE_FORMAT(members.date_paid, "%d/%m/%Y") AS date_pd, members.renewal_or_new, members.note FROM members INNER JOIN vessels ON members.member_id=vessels.member_id WHERE REPLACE (vessels.name, " ", "") = REPLACE ("'.$text.'", " ", "") AND members.membership_status != "Deleted" ORDER BY last_name ASC';
		}
		elseif ($criteria == "LIKE") {
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members WHERE '.$column.' LIKE "%'.$text.'%" AND membership_status != "Deleted" ORDER BY last_name ASC';
		}
		else {
			$query = 'SELECT SQL_NO_CACHE unique_id, member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, DATE_FORMAT(date_paid, "%d/%m/%Y") AS date_pd, renewal_or_new, note FROM members WHERE '.$column.' '.$criteria.' "'.$text.'" AND membership_status != "Deleted" ORDER BY last_name ASC';
		}
		
//		echo ($query);
			
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
	<div class="admin-container">
		<div id="home" class="starter-template">
			<h3>Active Member Administration</h3>
			<form name="input" action="adminmembership.php" method="post"><input type="submit" value="Add Member" align="center"/></form>
			<p>Click on any member content below to change the item. Click 'Ok' to save changes or 'Cancel' to retain the original content.</p>
			<p>You can also click on the 'Edit' button to the left of each member to change the member's details.</p>
			<p>You can click on the blue and white column headers to sort the members by that field.</p>
			<p><b>Note: all date fields must be entered in the following format dd/mm/yyyy.</b></p>
			<hr width="90%">

			<table align="center" cellpadding="5"><tr>
			<td>List Members where their Last Name starts with:</td>
			<td><form name="A" action="#" method="get"><input type=hidden name="search_text" value="^[aA]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['A'].submit();return false;">A</a></form></td>
			<td><form name="B" action="#" method="get"><input type=hidden name="search_text" value="^[bB]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['B'].submit();return false;">B</a></form></td>
			<td><form name="C" action="#" method="get"><input type=hidden name="search_text" value="^[cC]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['C'].submit();return false;">C</a></form></td>
			<td><form name="D" action="#" method="get"><input type=hidden name="search_text" value="^[dD]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['D'].submit();return false;">D</a></form></td>
			<td><form name="E" action="#" method="get"><input type=hidden name="search_text" value="^[eE]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['E'].submit();return false;">E</a></form></td>
			<td><form name="F" action="#" method="get"><input type=hidden name="search_text" value="^[fF]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['F'].submit();return false;">F</a></form></td>
			<td><form name="G" action="#" method="get"><input type=hidden name="search_text" value="^[gG]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['G'].submit();return false;">G</a></form></td>
			<td><form name="H" action="#" method="get"><input type=hidden name="search_text" value="^[hH]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['H'].submit();return false;">H</a></form></td>
			<td><form name="I" action="#" method="get"><input type=hidden name="search_text" value="^[iI]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['I'].submit();return false;">I</a></form></td>
			<td><form name="J" action="#" method="get"><input type=hidden name="search_text" value="^[jJ]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['J'].submit();return false;">J</a></form></td>
			<td><form name="K" action="#" method="get"><input type=hidden name="search_text" value="^[kK]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['K'].submit();return false;">K</a></form></td>
			<td><form name="L" action="#" method="get"><input type=hidden name="search_text" value="^[lL]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['L'].submit();return false;">L</a></form></td>
			<td><form name="M" action="#" method="get"><input type=hidden name="search_text" value="^[mM]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['M'].submit();return false;">M</a></form></td>
			<td><form name="N" action="#" method="get"><input type=hidden name="search_text" value="^[nN]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['N'].submit();return false;">N</a></form></td>
			<td><form name="O" action="#" method="get"><input type=hidden name="search_text" value="^[oO]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['O'].submit();return false;">O</a></form></td>
			<td><form name="P" action="#" method="get"><input type=hidden name="search_text" value="^[pP]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['P'].submit();return false;">P</a></form></td>
			<td><form name="Q" action="#" method="get"><input type=hidden name="search_text" value="^[qQ]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['Q'].submit();return false;">Q</a></form></td>
			<td><form name="R" action="#" method="get"><input type=hidden name="search_text" value="^[rR]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['R'].submit();return false;">R</a></form></td>
			<td><form name="S" action="#" method="get"><input type=hidden name="search_text" value="^[sS]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['S'].submit();return false;">S</a></form></td>
			<td><form name="T" action="#" method="get"><input type=hidden name="search_text" value="^[tT]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['T'].submit();return false;">T</a></form></td>
			<td><form name="U" action="#" method="get"><input type=hidden name="search_text" value="^[uU]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['U'].submit();return false;">U</a></form></td>
			<td><form name="V" action="#" method="get"><input type=hidden name="search_text" value="^[vV]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['V'].submit();return false;">V</a></form></td>
			<td><form name="W" action="#" method="get"><input type=hidden name="search_text" value="^[wW]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['W'].submit();return false;">W</a></form></td>
			<td><form name="X" action="#" method="get"><input type=hidden name="search_text" value="^[xX]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['X'].submit();return false;">X</a></form></td>
			<td><form name="Y" action="#" method="get"><input type=hidden name="search_text" value="^[yY]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['Y'].submit();return false;">Y</a></form></td>
			<td><form name="Z" action="#" method="get"><input type=hidden name="search_text" value="^[zZ]" /><input type=hidden name="search_column" value="last_name" /><input type=hidden name="search_criteria" value="REGEXP" /><a href="#" onclick="document.forms['Z'].submit();return false;">Z</a></form></td>
			</tr></table>
	
			<hr width="90%">

			<p>Search for Members where:</p>
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
					<option value="member_id">Member ID</option>
				</select>
				Search Criteria: 
				<select name="search_criteria"  /> 
					<option value="=">exactly matches</option>
					<option value="LIKE">contains</option>
				</select> -->
				<?php echo $search_html; ?>
				Search Text: 
				<input type="text" name="search_text"  /> 
				<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
				<input type="submit" value="Search" align="center"/>
			</form>

			<hr width="90%">

			<div class="row">
				<div class="col-md-3 col-lg-3">
					<!-- get all pending members -->
					<form name="input" action="#" method="get">
					<input type="hidden" name="search_text" value="Pending" />
					<input type="hidden" name="search_column" value="status" />
					<input type="hidden" name="search_criteria" value="REGEXP" />
					<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
					<input type="submit" value="Get Pending Members" align="center"/>
					</form>
				</div>		
				<div class="col-md-3 col-lg-3">
					<!-- search on trailer registration -->
					<form name="input" action="#" method="get">
					<input type="text" name="search_text" />
					<input type="hidden" name="search_column" value="trailer_reg" />
					<input type="hidden" name="search_criteria" value="REGEXP" />
					<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
					<input type="submit" value="Trailer Rego Search" align="center"/>
					</form>
				</div>		
				<div class="col-md-3 col-lg-3">
					<!-- search on boat name -->
					<form name="input" action="#" method="get">
					<input type="text" name="search_text" />
					<input type="hidden" name="search_column" value="boat_name" />
					<input type="hidden" name="search_criteria" value="REGEXP" />
					<input type="hidden" name="nocache" value="<?php echo uniqid() ?>" />
					<input type="submit" value="Boat Name Search" align="center"/>
					</form>
				</div>		
				<div class="col-md-3 col-lg-3">
					<!-- export selected data -->
					<form name="input" action="memberdownload.php" method="get">
					<input type="hidden" name="query" value='<?php echo $query; ?>' />
					<input type="submit" value="Export Data" align="center"/>
					</form>
				</div>		
			</div>		

			<hr width="90%">

			<?php
				$result = mysql_query($query, $link);
				if (!$result) {
				  echo("<p>Error performing query: " . mysql_error() . "</p>");
					mysql_close ($link);
				  exit();
				} 
				
				$members = "<table class=\"sortable\" width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\"><tr><th class=\"small\">&nbsp</th><th class=\"small\">Date Paid</th><th class=\"small\">Renewal or New</th><th class=\"small\">Member ID</th><th class=\"small\">Status</th><th class=\"small\">Last Name</th><th class=\"small\">First Name</th><th class=\"small\">Middle Name</th><th class=\"small\">Salutation</th><th class=\"small\">Address 1</th><th class=\"small\">Address 2</th><th class=\"small\">Address 3</th><th class=\"small\">Phone 1</th><th class=\"small\">Phone 2</th><th class=\"small\">Phone 3</th><th class=\"small\">Email</th><th class=\"small\">Note</th></tr>\n";
				echo $members;
		
				$members = "<tr>\n";
				$members .= "<td>&nbsp</td>\n";
				// status date paid field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"date_paid\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// status renewal or new field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"renewal_or_new\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// member_id search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"member_id\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// status search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"status\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// last_name search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"last_name\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// first_name search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"first_name\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// middle_name search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"middle_name\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// salutation search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"salutation\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// address1 search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"address1\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// address2 search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"address2\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// address3 search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"address3\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// phone1 search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"phone1\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// phone2 search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"phone2\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// phone3 search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"phone3\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// email search field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"email\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				// status note field
				$members .= "<td><form name=\"input\" action=\"#\" method=\"get\"><input type=\"text\" name=\"search_text\"  /><input type=hidden name=\"search_column\" value=\"note\" /><input type=hidden name=\"search_criteria\" value=\"REGEXP\" /><input type=hidden name=\"nocache\" value=\"".uniqid()."\" /><input type=\"submit\" value=\"Go\" align=\"center\"/></form></td>\n";
				$members .= "</tr>\n";
				echo $members;
				$i=0;
		
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
					$date_paid = $row['date_pd'];
					$renewal_or_new = $row['renewal_or_new'];
					$note = $row['note'];
		
					$members = "<tr><td>";
					$members .= "<form name=\"input\" action=\"editmember.php\" method=\"get\">";
					$members .= "<input type=\"hidden\" name=\"unique_id\" value=\"".$uid."\" />";
					$members .= "<input type=\"hidden\" name=\"nocache\" value=\"".uniqid()."\" />";
					$members .= "<input class=\"small\" type=\"submit\" value=\"Edit\" align=\"center\"/>";
					$members .= "</form>\n";
					$members .= "<form name=\"input\" action=\"printmember.php\" method=\"get\">";
					$members .= "<input type=\"hidden\" name=\"unique_id\" value=\"".$uid."\" />";
					$members .= "<input type=\"hidden\" name=\"nocache\" value=\"".uniqid()."\" />";
					$members .= "<input class=\"small\" type=\"submit\" value=\"Details\" align=\"center\"/>";
					$members .= "</form>\n";
					$members .= "<form name=\"input\" action=\"editvessel.php\" method=\"get\">";
					$members .= "<input type=\"hidden\" name=\"unique_id\" value=\"".$uid."\" />";
					$members .= "<input type=\"hidden\" name=\"nocache\" value=\"".uniqid()."\" />";
					$members .= "<input  class=\"small\" type=\"submit\" value=\"Vessel\" align=\"center\"/>";
					$members .= "</form>\n";
					$members .= "</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|date_paid\">".$date_paid."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|renewal_or_new\">".$renewal_or_new."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|member_id\">".$mid."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|status\">".$status."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|last_name\">".$last."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|first_name\">".$first."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|middle_name\">".$middle."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|salutation\">".$salute."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|address1\">".$addr1."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|address2\">".$addr2."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|address3\">".$addr3."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|phone1\">".$ph1."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|phone2\">".$ph2."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|phone3\">".$ph3."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|email\">".$email."</td>\n";
					$members .= "<td class=\"edit\" id=\"".$uid."|note\">".$note."</td></tr>\n";
					echo $members;
					}	
					
				$members = "</table></form>\n";
				mysql_close ($link);
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