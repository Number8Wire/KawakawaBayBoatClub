<?php
require "db.php";

if( isset($_POST['renewMemberID']) ) { $cmemberid=$_POST['renewMemberID']; }
if( isset($_POST['renewLastname1']) ) { $cmemberLastName=$_POST['renewLastname1']; }
if( isset($_POST['renewFirstname2']) ) { $cmemberFirstName=$_POST['renewFirstname2']; }
if( isset($_POST['renewLastname2']) ) { $cmemberLastName=$_POST['renewLastname2']; }
//$cmemberTrailerReg=$_POST['trailerreg'];

$link = @mysql_connect ($server, $username, $password)
or die (mysql_error());

if (!@mysql_select_db($database, $link)) {   // leave the database 
										   // name as anydb for now
										   
	 echo "<p>There has been an error. This is the error message:</p>";
	 echo "<p><strong>" . mysql_error() . "</strong></p>";
	 echo "Please Contant Your Systems Administrator with the details";
} 

if (isset($cmemberid)) {
	// check the member_id entered by the user
	$sql_query = "SELECT * FROM members WHERE member_id=\"".$cmemberid."\"";

	$result = mysql_query($sql_query, $link);
	if (!$result) {
	  echo("<p>Error performing query: " . mysql_error() . "</p>");
		mysql_close ($link);
	  exit();
	}
	
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	$memberID = $row['member_id'];
	$memberFirstName = $row['first_name'];
	$memberLastName = $row['last_name'];
	$memberEmail = $row['email'];
	$memberIDType = 0;
//	echo ("ID, memberFirstName = ".$memberFirstName);

}
elseif (isset($cmemberFirstName) && isset($cmemberLastName)) {
	// get the member_id from the names 
//	$sql_query = "SELECT * FROM members LEFT JOIN vessels ON members.member_id = vessels.member_id WHERE LOWER(members.first_name) = LOWER(\"".$cmemberFirstName."\") AND LOWER(members.last_name) = LOWER(\"".$cmemberLastName."\") AND LOWER(vessels.trailer_reg) = LOWER(\"".$cmemberTrailerReg."\")";
	$sql_query = "SELECT * FROM members WHERE LOWER(members.first_name) = LOWER(\"".$cmemberFirstName."\") AND LOWER(members.last_name) = LOWER(\"".$cmemberLastName."\")";

	$result = mysql_query($sql_query, $link);
	if (!$result) {
	  echo("<p>Error performing query: " . mysql_error() . "</p>");
		mysql_close ($link);
	  exit();
	}

	$row = mysql_fetch_array($result);
	$memberID = $row['member_id'];
	$memberFirstName = $row['first_name'];
	$memberLastName = $row['last_name'];
	$memberEmail = $row['email'];
	$memberIDType = 1;
	//	echo ("Names, memberFirstName = ".$memberFirstName);

}
else {
	echo("<p>Error - no data passed to member renew page! Please call the KBBC Administrator.</p>");
	exit();
}

// compare the current date to the 1st June this year
$currentYear = date('Y');
$dateA = $currentYear."-06-01 00:00"; 
$dateB = "now"; 

if(strtotime($dateA) > strtotime($dateB)){ 
	$currentMembershipYear = date("Y");
}
else {
	$currentMembershipYear = date("Y")+1;
}
$buttonText = "Renew Membership for the year ".$currentMembershipYear;

$renewHeaderText = "Renew Membership for ".$memberFirstName." ".$memberLastName;
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
			<h4 align="center"><?php echo $renewHeaderText; ?></h4>
			<p>Membership runs from the 1st of August to the 31st of July each year.</p>
			<p>Membership renewal for the next year is available after the 1st of June.</p>

			<form id="memberRenewalComplete" action="memberRenewalComplete.php" method="post" name="memberRenewalComplete">
				<input id="memberIDType" class="txt" type="hidden" name="memberIDType" value="<?php echo $memberIDType; ?>"/>
				<input id="memberid" class="txt" type="hidden" name="memberid" value="<?php echo $cmemberid; ?>"/>
				<input id="memberFirstName" class="txt" type="hidden" name="memberFirstName" value="<?php echo $memberFirstName; ?>"/>
				<input id="memberLastName" class="txt" type="hidden" name="memberLastName" value="<?php echo $memberLastName; ?>"/>
		<!--		<input id="trailerReg" class="txt" type="hidden" name="trailerReg" value="<?php echo $cmemberTrailerReg; ?>"/>-->
				<input type="submit" class="btn btn-default" role="button" value="<?php echo $buttonText; ?>" align="center" />
			</form>

			<p>(membership from 1st August, <?php echo $currentMembershipYear-1; ?> to 31st July <?php echo $currentMembershipYear; ?>)</p>
		</div>
	</div>
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
	<script type="text/javascript" src="js/jquery.validate.js"></script>
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
