<?php
	require_once ("auth.php");
	require 'db.php';
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
     $('.edit').editable('savevessel.php', {
         indicator : '<img src="images/loading.gif">',
         cancel    : 'Cancel',
         submit    : 'OK',
         tooltip   : 'Click to edit...',
				 placeholder : '-',
				 callback  : function(value, settings) {
				 								window.location.reload(true); 
										}
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

	<?php
		if (!empty($_GET)) {
			$column = $_GET['search_column']; // the database table field to search on
			$criteria = $_GET['search_criteria']; // the search criteris - 'LIKE' or '="
			$text = $_GET['search_text']; // the text to search for
		}
		else {
			$column = "last_name";
			$criteria = "=";
			$text = '***';
		}
		
		$link = @mysql_connect ($server, $username, $password)
		or die (mysql_error());
		
		if (!@mysql_select_db($database, $link)) {   // leave the database 
		                                           // name as anydb for now
		                                           
		     echo "<p>There has been an error. This is the error message:</p>";
		     echo "<p><strong>" . mysql_error() . "</strong></p>";
		     echo "Please Contant Your Systems Administrator with the details";
		     
		} 

		if ($column == 'last_name' || empty($column)) {
			if ($criteria =="LIKE") {
				$query = "SELECT members.member_id, members.first_name, members.last_name, vessels.unique_id, vessels.name, vessels.type, vessels.colour, vessels.length, vessels.beam, vessels.trailer_reg, vessels.radio_callsign, vessels.motor_type, vessels.motor_hp FROM members LEFT JOIN vessels ON members.member_id = vessels.member_id WHERE members.".$column." ".$criteria." \"%".$text."%\" ORDER BY last_name ASC";
			}
			else {
				$query = "SELECT members.member_id, members.first_name, members.last_name, vessels.unique_id, vessels.name, vessels.type, vessels.colour, vessels.length, vessels.beam, vessels.trailer_reg, vessels.radio_callsign, vessels.motor_type, vessels.motor_hp FROM members LEFT JOIN vessels ON members.member_id = vessels.member_id WHERE members.".$column." ".$criteria." \"".$text."\" ORDER BY last_name ASC";
			}
		}
		elseif ($criteria == "LIKE") {
			$query = "SELECT members.member_id, members.first_name, members.last_name, vessels.unique_id, vessels.name, vessels.type, vessels.colour, vessels.length, vessels.beam, vessels.trailer_reg, vessels.radio_callsign, vessels.motor_type, vessels.motor_hp FROM members LEFT JOIN vessels ON members.member_id = vessels.member_id WHERE vessels.".$column." LIKE \"%".$text."%\" ORDER BY last_name ASC";
		}
		else {
			$query = "SELECT members.member_id, members.first_name, members.last_name, vessels.unique_id, vessels.name, vessels.type, vessels.colour, vessels.length, vessels.beam, vessels.trailer_reg, vessels.radio_callsign, vessels.motor_type, vessels.motor_hp FROM members LEFT JOIN vessels ON members.member_id = vessels.member_id WHERE vessels.".$column." = \"".$text."\" ORDER BY last_name ASC";
		}
		
//		echo ($query);
				
		$result = mysql_query($query, $link);
		if (!$result) {
		  echo("<p>Error performing query, $sql_query: " . mysql_error() . "</p>");
		  exit();
		} 
		
		$vessels = "<table class=\"sortable\" width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\"><tr><th class=\"small\">Member First Name</th><th class=\"small\">Member Last Name</th><th class=\"small\">Vessel Name</th><th class=\"small\">Type</th><th class=\"small\">Colour</th><th class=\"small\">Length</th><th class=\"small\">Beam</th><th class=\"small\">Trailer Reg</th><th class=\"small\">Radio Callsign</th><th class=\"small\">Motor Type</th><th class=\"small\">Motor HP</th></tr>\n";
		while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
			$mid = $row['member_id'];
			if ($mid == 0) { continue; }
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$vuid = $row['unique_id'];
			$vessel_name = $row['name'];
			$type = $row['type'];
			$colour = $row['colour'];
			$length = $row['length'];
			$beam = $row['beam'];
			$trailer_reg = $row['trailer_reg'];
			$radio_callsign = $row['radio_callsign'];
			$motor_type = $row['motor_type'];
			$motor_hp = $row['motor_hp'];

			$vessels .= "<tr><td>".$first_name."</td>\n";
			$vessels .= "<td>".$last_name."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|name\">".$vessel_name."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|type\">".$type."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|colour\">".$colour."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|length\">".$length."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|beam\">".$beam."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|trailer_reg\">".$trailer_reg."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|radio_callsign\">".$radio_callsign."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|motor_type\">".$motor_type."</td>\n";
			$vessels .= "<td class=\"edit\" id=\"".$vuid."|motor_hp\">".$motor_hp."</td>\n";
			$vessels .= "<td><form name=\"input\" action=\"editvessel.php\" method=\"get\"><input type=\"hidden\" name=\"unique_id\" value=\"".$vuid."\" /><p><input type=\"submit\" value=\"Edit\" align=\"center\"/></p></form></td></tr>\n";
		}	
		$vessels .= "</table>\n";
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
					<li class="active"><a href="editgallery.php">Photo Gallery</a></li>
					<li><a href="weatheradmin.html">Weather</a></li>
					<li><a href="webcamadmin.php">WebCam</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div> <!--/.nav-collapse -->
			</div> <!--/.nav-collapse -->
		</div>
	</nav>

    <!-- Home Page
    ================================================== -->
	<div class="container">
		<div id="home" class="starter-template">
			<img src="images/KBBC-Ramp-2.jpg" class="img-responsive center-block" alt="Kawakawa Bay Boat Club" border="0">
			<h3>Vessel Administration</h3>
			<form name="input" action="adminaddvessel.php" method="post"><input type="submit" value="Add Vessel" align="center"/></form>
			<p>Click on any vessel content below to change the item. Click 'Ok' to save changes or 'Cancel' to retain the original content.</p>
			<p>You can also click on the 'Edit' button on the right to edit the vessel details.</p>
			<hr width="90%">
			<table align="center" cellpadding="5"><tr>
			<td>List Vessels where Member Last Name starts with:</td>
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
			<p>Search for Vessels where:</p>
			<form name="input" action="#" method="get">
				Column: 
				<select name="search_column"  /> 
					<option value="name" selected="selected">Vessel Name</option>
					<option value="type">Vessel Type</option>
					<option value="colour">Vessel Colour</option>
					<option value="trailer_reg">Vessel Trailer Reg</option>
					<option value="radio_callsign">Vessel Radio Callsign</option>
					<option value="motor_type">Vessel Motor Type</option>
					<option value="motor_hp">Vessel Motor HP</option>
					<option value="last_name">Member Last Name</option>
				</select>
				Search Criteria: 
				<select name="search_criteria"  /> 
					<option value="=">exactly matches</option>
					<option value="LIKE">contains</option>
				</select>
				Search Text: 
				<input type="text" name="search_text"  /> 
				<input type="submit" value="Search" align="center"/>
			</form>
			<hr width="90%">
			<?php
			  echo $vessels;
			?>
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