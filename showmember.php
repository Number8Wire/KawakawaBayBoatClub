<?php
	require_once ("auth.php");
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
  
  <link rel="stylesheet" type="text/css" href="styles/styles.css">
  <link rel="stylesheet" type="text/css" href="styles/chromestyle.css" />
	<link rel="stylesheet" type="text/css" href="styles/popupmenu.css" />

	<script src="scripts/sorttable.js"></script>
	
  <script type="text/javascript" src="scripts/chrome.js">
  /***********************************************
  * Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
  * This notice MUST stay intact for legal use
  * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
  ***********************************************/
  </script>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<!--	use the declaration below for wamp testing offline  -->
<!--	<script type="text/javascript" src="scripts/jquery-1.4.js"></script> -->

	<script type="text/javascript" src="scripts/popupmenu.js">
	/***********************************************
	* Flex Level Popup Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
	* This notice MUST stay intact for legal use
	* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
	***********************************************/
	</script>

	<?php
		$uid = $_GET['unique_id']; // the ID of the member
		
		$server = "localhost:3306"; // this is the server address and port
		$username = "kbbcadmn"; // change this to your mysql username
		$password = "k55c@dm1n"; // change this to your mysql password
		
//		$username = "root"; // change this to your mysql username
//		$password = ""; // change this to your mysql password
		
		$link = @mysql_connect ($server, $username, $password)
		or die (mysql_error());
		
		if (!@mysql_select_db($database, $link)) {   // leave the database 
		                                           // name as anydb for now
		                                           
		     echo "<p>There has been an error. This is the error message:</p>";
		     echo "<p><strong>" . mysql_error() . "</strong></p>";
		     echo "Please Contant Your Systems Administrator with the details";
		     
		} 

		$query = "SELECT * FROM members WHERE unique_id = ".$uid." ORDER BY member_id ASC";
		
//		echo ($query);
				
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

			$members .= "<tr><td>".$mid."</td><td>".$salute."</td><td>".$first."</td><td>".$middle."</td><td>".$last."</td><td>".$addr1."</td><td>".$addr2."</td><td>".$addr3."</td><td>".$ph1."</td><td>".$ph2."</td><td>".$ph3."</td><td>".$email."</td><td>".$status."</td><td>".$membership_status."</td></tr>\n";
		}	
		$members .= "</table>\n";
		
		mysql_close ($link);
	?>
	
</head>
<body>

<?php include_once("googleAnalyticsTracking.php") ?>

<table width="800" align="center">
								 
<tr><td align="center">
<img src="images/KBBC-Ramp-2.jpg" width="800" height="150" alt="" border="0">
<script type="text/javascript" src="scripts/chromemenu2.js"></script>

<script type="text/javascript">cssdropdown.startchrome("chromemenu2")</script>
</td></tr>

<noscript>
	<tr><td><p>JavaScript is turned off in your web browser.<br>Turn it on to take full advantage of this site, then refresh the page.</p></td></tr>
	<tr><td><p>This is the website for the Kawakawa Bay Boat Club, New Zealand.</p></td></tr>
</noscript>

</table>
 
<table align="center" width="800" border="0">	 

<tr>

	<td align="center">
		<h3>Member Administration</h3>
	</td>
	
</tr>

<tr>
	<td>
		<hr width="90%">
	</td>
</tr>

<tr>
	<td align="center" valign="top">
		<?php
	      echo $members;
		?>
	</td>
</tr>

<tr>
	<td>
		<hr width="800" align="center">
	</td>
</tr>

<tr>
	<td>
		<p class="footer" align="center"><a href="logout.php">Logout</a> | <a href="admin.php">Admin Home</a> | <a href="editnews.php" data-popupmenu="news_popupmenu">News</a> | <a href="editmembers.php" data-popupmenu="members_popupmenu">Members</a> | <a href="editgallery.php">Photo Gallery</a> | <a href="newsletter.php">News Letter</a></p>
	</td>
</tr>

<tr>
	<td>
		<p class="footer"><a href="http://www.number8wire.co.nz" target="_blank" class="nulblack">Website by Number 8 Wire Design</a></p>
	</td>
</tr>

</table>   

<!--HTML for News popup Menu-->
<ul id="news_popupmenu" class="jqpopupmenu_news">
	<li><a href="editnews.php">Edit News Items</a></li>
	<li><a href="uploadnewsletter.php">Upload Newsletter</a></li>
</ul>

<!--HTML for Members popup Menu-->
<ul id="members_popupmenu" class="jqpopupmenu_member">
	<li><a href="editmembers.php">Edit Active Members</a></li>
	<li><a href="editdeletedmembers.php">Edit Deleted Members</a></li>
	<li><a href="membermailmergeall.php">Member Mail Merge (All)</a></li>
	<li><a href="membermailmergefinancial.php">Member Mail Merge (Financial)</a></li>
	<li><a href="memberdownload.php">Member Database Download</a></li>
	<li><a href="uploadmembershipform.php">Upload Membership Form</a></li>
	<li><a href="memberstats.php">Member Statistics</a></li>
</ul>

<!--HTML for Junior popup Menu-->
<!--<ul id="junior_popupmenu" class="jqpopupmenu_junior">
	<li><a href="uploadjuniorresults.php">Upload Junior Racing Results</a></li>
	<li><a href="uploadjuniorimage.php">Upload Junior Picture</a></li>
</ul>-->

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
