<?php
require "db.php";

$memberIDType=$_POST['memberIDType'];
$memberid=$_POST['memberid'];
$memberFirstName=$_POST['memberFirstName'];
$memberLastName=$_POST['memberLastName'];
//$trailerreg=$_POST['trailerReg'];

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
	// the member identified themselves with first name, last name and trailer registration
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
	$email = $row['email'];
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
			$email = "admin@number8wire.co.nz";
		}
		else {
			// get the member email address
			$sql_query = "SELECT * FROM members WHERE member_id = \"".$memberid."\"";
		
			$result = mysql_query($sql_query, $link);
			if (!$result) {
			  echo("<p>Error performing query: " . mysql_error() . "</p>");
				mysql_close ($link);
			  exit();
			}
		
			$row = mysql_fetch_array($result);
			$memberFirstName = $row['first_name'];
			$email = $row['email'];
		}
	}
}

$updateHeaderText = "Update membership details for ".$memberFirstName." ".$memberLastName;

$currentYear = date('Y');
$dateA = $currentYear."-06-01 00:00"; 
$dateB = "now"; 

if(strtotime($dateA) > strtotime($dateB)){ 
	$currentMembershipYear = date("Y");
}
else {
	$currentMembershipYear = date("Y")+1;
}

if ($sendMail == 1) {
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: boatclub@kbbc.co.nz' . PHP_EOL . 'Bcc: ' . $bcc . PHP_EOL;
	$memberEmailSubject = "KBBC Membership Renewal for ".$memberFirstName." ".$memberLastName." for ".$currentMembershipYear;
	$memberEmailBody = "<p>Hi ".$memberFirstName." ".$memberLastName.",</p>";
	$memberEmailBody .= "<p>Your membership renewal application for the Kawakawa Bay Boat Club has been sent to the Administrator.</p>";
	$memberEmailBody .= "<p>Your payment of $100 can be made by Direct Credit into Club Account ASB 12-3031-0701479-000 with the reference as your name or membership number (".$memberid.").</p>";
	$memberEmailBody .= "<p>Alternatively you can post a Cheque if you prefer to Kawakawa Bay Boat Club Inc., Kawakawa Bay, RD5, Papakura, 2585.</p>";
	$memberEmailBody .= "<p>Thank you for your membership renewal.</p>";
	$memberEmailBody .= "<p>regards<br />The Kawakawa Bay Boat Club</p>";
	// send the email to the member
	if (strlen ($email)) {
		mail($email, $memberEmailSubject, $memberEmailBody, $headers);
	}
	
	$KBBCEmailSubject = "KBBC Membership Renewal for ".$memberFirstName." ".$memberLastName." for ".$currentMembershipYear;
	$KBBCEmailBody = "<p>Hi,</p>";
	$KBBCEmailBody .= "<p>".$memberFirstName." ".$memberLastName." has registered for membership renewal for the ".$currentMembershipYear." membership year via the website.</p>";
	
	if ($memberIDType == 0) {//member idetified themselves with member number
		$KBBCEmailBody .= "<p>The member identified themselves with their membership number - ".$memberid." and Last Name - ".$memberLastName.".</p>";
	}
	else {
		$KBBCEmailBody .= "<p>The member identified themselves with their First Name - ".$memberFirstName." and Last Name - ".$memberLastName.".</p>";
	}
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
			<h2>Membership Renewal Complete</h2>
			<p>Thank you for your membership renewal. We will update our database and confirm your membership renewal when we get your payment.</p>
			<p>You will get an email with the Kawakawa Bay Boat Club bank account details for your membership renewal funds deposit.</p>
			<hr width="800" align="center">
			<h2><?php echo $updateHeaderText; ?></h2>
			<p>If you haven't updated your personal and vessel details with us lately please do so in the fields below.</p>
			<p>Up to date records make it easier for us to contact our members when necessary.</p>
			<p>Enter your details in any of the fields below then click the 'Update' button below.</p>
			<div class="container">
			<div class="container">
				<div class="row table-padded">
					<!-- heading row -->
					<div class="col-md-12" align="center"><h4>Applicant Info:</h4></div>
				</div>
				<!-- Applicant details -->
				<form name="memberUpdateComplete" action="memberUpdateComplete.php" method="post" id="memberUpdateComplete">
					<div class="row table-padded">
						<div class="col-md-1">Salutation: </div>
						<div class="col-md-2"><select name="salutation" id="salutation" /><option value="Dr">Dr</option><option value="Miss">Miss</option><option value="Mr" selected="selected">Mr</option><option value="Mrs">Mrs</option><option value="Ms">Ms</option><option value="Mr & Mrs">Mr & Mrs</option><option value="Mr & Ms">Mr & Ms</option><option value="Mr & Miss">Mr & Miss</option></select></div>
						<div class="col-md-1">First Name: </div>
						<div class="col-md-2"><input type="text" name="firstname" id="firstname" /></div>
						<div class="col-md-1">Middle Name: </div>
						<div class="col-md-2"><input type="text" name="middlename" id="middlename" /></div>
						<div class="col-md-1">Last Name: </div>
						<div class="col-md-2"><input type="text" name="lastname" id="lastname" /></div>
					</div>
					<div class="row table-padded">
						<div class="col-md-1">House Number: </div>
						<div class="col-md-2"><input type="text" name="house" id="house" /></div>
						<div class="col-md-1">Street: </div>
						<div class="col-md-2"><input type="text" name="street" id="street" /></div>
						<div class="col-md-1">Suburb: </div>
						<div class="col-md-2"><input type="text" name="suburb" id="suburb"/></div>
						<div class="col-md-1">City / Postcode: </div>
						<div class="col-md-2"><input type="text" name="city" id="city" /></div>
					</div>
					<div class="row table-padded">
						<div class="col-md-1">Phone 1: </div>
						<div class="col-md-2"><input type="text" name="phone1" id="phone1" /></div>
						<div class="col-md-1">Phone 2: </div>
						<div class="col-md-2"><input type="text" name="phone2" id="phone2" /></div>
						<div class="col-md-1">Phone 3: </div>
						<div class="col-md-2"><input type="text" name="phone3" id="phone3" /></div>
						<div class="col-md-1">Email: </div>
						<div class="col-md-2"><input type="text" name="email" id="email" /></div>
					</div>
					<input id="memberIDType" class="txt" type="hidden" name="memberIDType" value="<?php echo $memberIDType; ?>"/>
					<input id="memberid" class="txt" type="hidden" name="memberid" value="<?php echo $cmemberid; ?>"/>
					<input id="memberFirstName" class="txt" type="hidden" name="memberFirstName" value="<?php echo $memberFirstName; ?>"/>
					<input id="memberLastName" class="txt" type="hidden" name="memberLastName" value="<?php echo $memberLastName; ?>"/>
	<!--					<input id="trailerReg" class="txt" type="hidden" name="trailerReg" value="<?php echo $cmemberTrailerReg; ?>"/>-->
	
					<!-- horizontal divider line -->
					<div class="row">
						<div class="col-md-12"><hr width="80%"</div>
					</div>
	
					<!-- Vessel details -->
					<div class="row table-padded">
						<div class="col=md-12" align="center"><h4>Vessel Details:</h4></div>
					</div>

					<div class="row table-padded">
						<div class="col-md-1">Vessel Name: </div>
						<div class="col-md-2"><input type="text" name="vesselname" id="vesselname" /></div>
						<div class="col-md-1">Type: </div>
						<div class="col-md-2"><select name="vesseltype"><option value="power">Power</option><option value="sail">Sail</option></select></div>
						<div class="col-md-1">Colour: </div>
						<div class="col-md-2"><input type="text" name="colour" /></div>
						<div class="col-md-1">Length: </div>
						<div class="col-md-2"><input type="text" name="length" />m</div>
					</div>
					<div class="row table-padded">
						<div class="col-md-1">Beam: </div>
						<div class="col-md-2"><input type="text" name="beam" />m</div>
						<div class="col-md-1">Trailer Registration: </div>
						<div class="col-md-2"><input type="text" name="trailer" id="trailer" /></div>
						<div class="col-md-1">Radio Call Sign: </div>
						<div class="col-md-2"><input type="text" name="radio" /></div>
						<div class="col-md-1">Motor Type: </div>
						<div class="col-md-2"><select name="motortype"><option value="outboard">Outboard</option><option value="inboard">Inboard</option></select></div>
					</div>
					<div class="row table-padded">
						<div class="col-md-1">Motor Horsepower: </div>
						<div class="col-md-2"><input type="text" name="motorhp" />hp</div>
					</div>
		
					<div class="row table-padded">
						<div class="col-md-12" align="center">
							<p>Click on the Update button below to submit your changes to the Kawakawa Bay Boat Club Administrator.</p>
						</div>
					</div>
	
					<div class="row table-padded	">
						<div class="col-md-12" align="center"><input type="submit" value="Update" align="center" /></div>

					<!-- horizontal divider line -->
					<div class="row">
						<div class="col-md-12"><hr width="80%"</div>
					</div>
	
				</form>
			</div>
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
