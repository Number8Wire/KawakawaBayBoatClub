<?php
require 'db.php';

$memberIDType=$_POST['memberIDType'];
$memberid=$_POST['memberid'];
$memberFirstName=$_POST['memberFirstName'];
$memberLastName=$_POST['memberLastName'];
//$trailerreg=$_POST['trailerReg'];

$salutation=$_POST['salutation'];
$firstname=$_POST['firstname'];
$middlename=$_POST['middlename'];
$lastname=$_POST['lastname'];
$house=$_POST['house'];
$street=$_POST['street'];
$suburb=$_POST['suburb'];
$city=$_POST['city'];
$phone1=$_POST['phone1'];
$phone2=$_POST['phone2'];
$phone3=$_POST['phone3'];
$newEmail=$_POST['email'];

$vesselname=$_POST['vesselname'];
$vesseltype=$_POST['vesseltype'];
$colour=$_POST['colour'];
$length=$_POST['length'];
$beam=$_POST['beam'];
$trailer=$_POST['trailer'];
$radio=$_POST['radio'];
$motortype=$_POST['motortype'];
$motorhp=$_POST['motorhp'];

$link = @mysql_connect ($server, $username, $password)
or die (mysql_error());

if (!@mysql_select_db($database, $link)) {   // leave the database 
                                           // name as anydb for now
                                           
     echo "<p>There has been an error. This is the error message:</p>";
     echo "<p><strong>" . mysql_error() . "</strong></p>";
     echo "Please Contant Your Systems Administrator with the details";
}

$sendMail = 1;

if ($memberIDType == 1) {
	// the member identified themselves with first name and last name
	// get the member_id from the names and trailer registration
//	$sql_query = "SELECT * FROM members LEFT JOIN vessels ON members.member_id = vessels.member_id WHERE LOWER(members.first_name) = LOWER(\"".$memberFirstName."\") AND LOWER(members.last_name) = LOWER(\"".$memberLastName."\") AND LOWER(vessels.trailer_reg) = LOWER(\"".$trailerreg."\")";
	$sql_query = "SELECT * FROM members WHERE LOWER(members.first_name) = LOWER(\"".$memberFirstName."\") AND LOWER(members.last_name) = LOWER(\"".$memberLastName."\")";

	$result = mysql_query($sql_query, $link);
	if (!$result) {
	  echo("<p>Error performing query: " . mysql_error() . "</p>");
		mysql_close ($link);
	  exit();
	}

	$row = mysql_fetch_array($result);
	$memberid = $row['member_id'];
	$currentEmail = $row['email'];
}
else {
	// check if memberid is empty
	if (empty($memberid)){
		$sendMail = 0;
	}
	else {
		// the member identified themselves with member ID and last name
		// check that the member ID exists
		if (trim($memberid)==='') {
			$newEmail = "support@number8wire.co.nz";
		}
		else {
			// get the member's current mail address
			$sql_query = "SELECT * FROM members WHERE member_id = \"".$memberid."\"";
		
			$result = mysql_query($sql_query, $link);
			if (!$result) {
			  echo("<p>Error performing query: " . mysql_error() . "</p>");
				mysql_close ($link);
			  exit();
			}
		
			$row = mysql_fetch_array($result);
			$memberFirstName = $row['first_name'];
			$currentEmail = $row['email'];
		}
	}
}

if ($sendMail == 1) {
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: boatclub@kbbc.co.nz' . PHP_EOL . 'Bcc: ' . $bcc . PHP_EOL;
	$memberEmailSubject = "KBBC Information Update for ".$memberFirstName." ".$memberLastName;
	$memberEmailBody = "<p>Hi ".$memberFirstName." ".$memberLastName.",</p>";
	$memberEmailBody .= "<p>Your updated membership information for the Kawakawa Bay Boat Club has been sent to the Administrator.</p>";
	$memberEmailBody .= "<p>Thank you for updating your membership details.</p>";
	
	$memberEmailBody .= "<p>The updated information fields are listed below:</p>";
	$memberEmailBody .= "<p>Member Information<br />";
	$memberEmailBody .= "Salutation: ".$salutation."<br />";
	$memberEmailBody .= "First Name: ".$firstname."<br />";
	$memberEmailBody .= "Middle Name: ".$middlename."<br />";
	$memberEmailBody .= "Last Name: ".$lastname."<br />";
	$memberEmailBody .= "House Number: ".$house."<br />";
	$memberEmailBody .= "Street: ".$street."<br />";
	$memberEmailBody .= "Suburb: ".$suburb."<br />";
	$memberEmailBody .= "City / Postcode: ".$city."<br />";
	$memberEmailBody .= "Phone 1: ".$phone1."<br />";
	$memberEmailBody .= "Phone 2: ".$phone2."<br />";
	$memberEmailBody .= "Phone 3: ".$phone3."<br />";
	$memberEmailBody .= "Email: ".$newEmail."</p>";
	
	$memberEmailBody .= "<p>Vessel Information<br />";
	$memberEmailBody .= "Vessel Name: ".$vesselname."<br />";
	$memberEmailBody .= "Type: ".$vesseltype."<br />";
	$memberEmailBody .= "Colour: ".$colour."<br />";
	$memberEmailBody .= "Length: ".$length."<br />";
	$memberEmailBody .= "Beam: ".$beam."<br />";
	$memberEmailBody .= "Trailer Registration: ".$trailer."<br />";
	$memberEmailBody .= "Radio Call Sign: ".$radio."<br />";
	$memberEmailBody .= "Motor Type: ".$motortype."<br />";
	$memberEmailBody .= "Motor Horsepower: ".$motorhp."</p>";
	
	$memberEmailBody .= "<p>regards<br />The Kawakawa Bay Boat Club</p>";
	// send the email to the member's old email address
	if (strlen ($currentEmail)) {
		mail($currentEmail, $memberEmailSubject, $memberEmailBody, $headers);
	}
	
	// send the email to the member's new email address if it has been specified
	// and is different to the one stored in the KBBC database
	if (!isset($newEmail) || strlen ($newEmail)) {
		//check to see if the new email is different to the current one
		if ($newEmail !== $currentEmail) {
			//the new email address is different
			mail($newEmail, $memberEmailSubject, $memberEmailBody, $headers);
		}
	}
	
	$KBBCEmailSubject = "KBBC Information Update for ".$memberFirstName." ".$memberLastName;
	$KBBCEmailBody = "<p>Hi,</p>";
	$KBBCEmailBody .= "<p>".$memberFirstName." ".$memberLastName." has updated their membership details via the website.</p>";
	
	if ($memberIDType == 0) {//member idetified themselves with member number
		$KBBCEmailBody .= "<p>The member identified themselves with their membership number - ".$memberid." and Last Name - ".$memberLastName.".</p>";
	}
	else {
		$KBBCEmailBody .= "<p>The member identified themselves with their First Name - ".$memberFirstName." and Last Name - ".$memberLastName.".</p>";
	}
	
	$KBBCEmailBody .= "<p>The updated information fields are listed below:</p>";
	$KBBCEmailBody .= "<p>Member Information<br />";
	$KBBCEmailBody .= "Salutation: ".$salutation."<br />";
	$KBBCEmailBody .= "First Name: ".$firstname."<br />";
	$KBBCEmailBody .= "Middle Name: ".$middlename."<br />";
	$KBBCEmailBody .= "Last Name: ".$lastname."<br />";
	$KBBCEmailBody .= "House Number: ".$house."<br />";
	$KBBCEmailBody .= "Street: ".$street."<br />";
	$KBBCEmailBody .= "Suburb: ".$suburb."<br />";
	$KBBCEmailBody .= "City / Postcode: ".$city."<br />";
	$KBBCEmailBody .= "Phone 1: ".$phone1."<br />";
	$KBBCEmailBody .= "Phone 2: ".$phone2."<br />";
	$KBBCEmailBody .= "Phone 3: ".$phone3."<br />";
	$KBBCEmailBody .= "Email: ".$newEmail."</p>";
	
	$KBBCEmailBody .= "<p>Vessel Information<br />";
	$KBBCEmailBody .= "Vessel Name: ".$vesselname."<br />";
	$KBBCEmailBody .= "Type: ".$vesseltype."<br />";
	$KBBCEmailBody .= "Colour: ".$colour."<br />";
	$KBBCEmailBody .= "Length: ".$length."<br />";
	$KBBCEmailBody .= "Beam: ".$beam."<br />";
	$KBBCEmailBody .= "Trailer Registration: ".$trailer."<br />";
	$KBBCEmailBody .= "Radio Call Sign: ".$radio."<br />";
	$KBBCEmailBody .= "Motor Type: ".$motortype."<br />";
	$KBBCEmailBody .= "Motor Horsepower: ".$motorhp."</p>";
	
	$KBBCEmailBody .= "<p>regards<br />The Kawakawa Bay Boat Club Website</p>";
	// send the email to the boat club
	mail($to, $KBBCEmailSubject, $KBBCEmailBody, $headers);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!-- Created on: 12/12/2009 -->
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<title>Kawakawa Bay Boat Club</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="Number 8 Wire Design Ltd" />
	<meta name="generator" content="AceHTML Freeware" />
  
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet" />
  
    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet" />
    <link href="css/carousel.css" rel="stylesheet" />
    <link href="css/login-modal.css" rel="stylesheet" />
	<link href="css/font-awesome.min.css" rel="stylesheet" />
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
    <link href="css/styles.css" rel="stylesheet" />

	<link rel="shortcut icon" href="kbbc.ico" type="image/x-icon" />

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
					<li><a href="index.php">Home</a></li>
					<li class="active dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Membership <span class="caret"</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="membershipcurrent.html">Current Members</a></li>
                            <li><a href="membershipnew.php">New Members</a></li>
                        </ul>
					</li>
					<li><a href="news.php">News</a></li>
					<li><a href="boating.php">Boating</a></li>
					<li><a href="weather.html">Weather</a></li>
					<li><a href="webcam.php">WebCam</a></li>
					<li><a href="gallery.php">Photos</a></li>
					<li><a href="juniors.html">Juniors</a></li>
					<li><a href="contact.html">Contact Us</a></li>
					<li><a href="links.php">Links</a></li>
				</ul>
			</div> <!--/.nav-collapse -->
		</div>
	</nav>

    <!-- Home Page
    ================================================== -->
	<div class="container">
		<div id="home" class="starter-template">
			<img src="images/KBBC-Ramp-2.jpg" class="img-responsive center-block" alt="Kawakawa Bay Boat Club" border="0" />
			<h2>Membership Information Update Complete</h2>
			<p>Thank you for updating your membership information. We will update our database to reflect your new details.</p>
			<p>You will get an email confirming your information changes.</p>
		</div>
	</div><!-- /.container -->
    
	<!-- Footer
    ================================================== -->
	<div id="footer" class="container">
		<div class="footer navbar-bottom">
			<hr class="black">
			<p align="center"><a href="index.php">Home</a> | <a href="membershipnew.html">New Members</a> | <a href="membershipcurrent.html">Current Members</a> | <a href="news.php">News</a> | <a href="boating.html">Boating</a> | <a href="weather.html">Weather</a> | <a href="webcam.php">WebCam</a> | <a href="gallery.php">Photos</a> | <a href="javascript:;" data-toggle="modal" data-target="#contact-form-content">Contact Us</a> | <a href="links.html">Links</a> | <a href="javascript:;" data-toggle="modal" data-target="#loginModal">Login</a> | <i class="fa fa-copyright"></i> Number 8 Wire Design</p>
		</div>
	</div><!-- /.container -->

   <!-- Contact Modal
    ================================================== -->
	<div id="contact-form-content" class="modal fade in" style="display: none;">
		<div class="modal-dialog">
	    	<div class="modal-content login-modal">
				<div class="modal-header login-modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title text-center" id="loginModalLabel">Contact Us</h4>
				</div>
				<div class="modal-body">
					<form class="contact login-modal-form" name="contact">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-user"></i></div>
								<input align="center" type="text" name="name" class="form-control" placeholder="your name" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
								<input align="center" type="email" name="email" class="form-control" placeholder="your email address" />
							</div>
						</div>
						<textarea name="message" class="form-control" placeholder="your message" rows="6" cols="20"></textarea>
					</form>
				</div>
				<div class="modal-footer">
					<button type="submit" id="contact-submit" class="btn btn-block bt-login" data-loading-text="Sending....">Send</button>
				</div>
			</div>
		</div>
	</div>

   <!-- Thanks Modal
    ================================================== -->
	<div id="thanks-content" class="modal fade in" style="display: none;">
		<div class="modal-dialog">
	      		<div class="modal-header login-modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title text-center" id="thanksModalLabel">Thanks for contacting us</h4>
	      		</div>
	    	<div class="modal-content login-modal">
				<div class="modal-body">
					<div id="thanks">
					</div>
				</div>
			</div>
		</div>
	</div>

   <!-- Login Modal
    ================================================== -->
	<div class="modal fade" id="loginModal" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog">
	    	<div class="modal-content login-modal">
	      		<div class="modal-header login-modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title text-center" id="loginModalLabel">Kawakawa Bay Boat Club Login</h4>
	      		</div>
	      		<div class="modal-body">
	      			<div class="text-center">
						&nbsp;&nbsp;
						<span id="login_fail" class="response_error" style="display: none;">Login failed, please try again.</span>
						<div class="clearfix"></div>
						<form class="login-modal-form" method="post" action="login-exec.php">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-user"></i></div>
									<input align="center" type="text" class="form-control" name="login" id="login" placeholder="username" />
								</div>
								<span class="help-block has-error" id="email-error"></span>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-lock"></i></div>
									<input type="password" class="form-control" name="password" id="password" placeholder="password" />
								</div>
								<span class="help-block has-error" id="password-error"></span>
							</div>
							<button type="submit" id="login_btn" class="btn btn-block bt-login" data-loading-text="Signing In....">Login</button>
						</form>
	      			</div>
	      		</div>
	      		
	    	</div>
	   </div>
 	</div>
 	<!-- - Login Model Ends Here -->
	
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
src="http://www.statcounter.com/counter/counter.js"></script>
<noscript><div class="statcounter"><a title="tumblr
visitor" href="http://statcounter.com/tumblr/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/7772754/0/1e02e638/1/"
alt="tumblr visitor"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

</body>
</html>
