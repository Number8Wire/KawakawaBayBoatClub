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
	<link href="css/popupmenu.css" rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" href="kbbc.ico" type="image/x-icon" />

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
			<h3>New Member Administration</h3>
			<p>Fill in the form below to add a new member:</p>
			<p class="red">fields marked with * must be filled in</p>
			<!-- Applicant details -->
			<form name="membership" action="adminaddmember.php" method="post" id="membership">
				<div class="row table-padded">
					<div class="col-md-1">Salutation: </div>
					<div class="col-md-2"><select name="salutation" id="salutation"><option value="Dr">Dr</option><option value="Miss">Miss</option><option value="Mr" selected="selected">Mr</option><option value="Mrs">Mrs</option><option value="Ms">Ms</option><option value="Mr & Mrs">Mr & Mrs</option><option value="Mr & Ms">Mr & Ms</option><option value="Mr & Miss">Mr & Miss</option></select></div>
					<div class="col-md-1 red">First Name: </div>
					<div class="col-md-2"><input type="text" name="firstname" id="firstname" /></div>
					<div class="col-md-1">Middle Name: </div>
					<div class="col-md-2"><input type="text" name="middlename" id="middlename" /></div>
					<div class="col-md-1 red">Last Name: </div>
					<div class="col-md-2"><input type="text" name="lastname" id="lastname" /></div>
				</div>
				<div class="row table-padded">
					<div class="col-md-1 red">Street: </div>
					<div class="col-md-2"><input type="text" name="address1" id="address1" /></div>
					<div class="col-md-1 red">Suburb: </div>
					<div class="col-md-2"><input type="text" name="address2" id="address2"/></div>
					<div class="col-md-1 red">City / Postcode: </div>
					<div class="col-md-2"><input type="text" name="address3" id="address3" /></div>
				</div>
				<div class="row table-padded">
					<div class="col-md-1 red">Phone 1: </div>
					<div class="col-md-2"><input type="text" name="homeph" id="homeph" /></div>
					<div class="col-md-1">Phone 2: </div>
					<div class="col-md-2"><input type="text" name="businessph" id="businessph" /></div>
					<div class="col-md-1">Phone 3: </div>
					<div class="col-md-2"><input type="text" name="mobileph" id="mobileph" /></div>
					<div class="col-md-1">Email: </div>
					<div class="col-md-2"><input type="text" name="email" id="email" /></div>
				</div>
<!--				<input id="memberIDType" class="txt" type="hidden" name="memberIDType" value="<?php echo $memberIDType; ?>"/>
				<input id="memberid" class="txt" type="hidden" name="memberid" value="<?php echo $cmemberid; ?>"/>
				<input id="memberFirstName" class="txt" type="hidden" name="memberFirstName" value="<?php echo $memberFirstName; ?>"/>
				<input id="memberLastName" class="txt" type="hidden" name="memberLastName" value="<?php echo $memberLastName; ?>"/>
					<input id="trailerReg" class="txt" type="hidden" name="trailerReg" value="<?php echo $cmemberTrailerReg; ?>"/> -->

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
				<div class="row table-padded	">
					<div class="col-md-12" align="center"><input type="submit" value="Submit" align="center" /></div>
				</div>
				<!-- horizontal divider line -->
				<div class="row">
					<div class="col-md-12"><hr width="80%"</div>
				</div>
			</form>
			<hr width="700" align="center">
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
	<script type="text/javascript" src="js/jquery.validate.js"></script>

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

			$( "#membership" ).validate({
				rules: {
					firstname: "required",
					lastname: "required",
					address1: "required",
					address2: "required",
					address3: "required",
					homeph: "required"
//					email: {
//						required: true,
//						email: true
//						}
				},
				messages: {
					firstname: "Please enter the first name",
					lastname: "Please enter the last name",
					address1: "Please enter the house number and street",
					address2: "Please enter the suburb",
					address3: "Please enter the city or postcode",
					homeph: "Please enter a phone number"
//					email: "Please enter an email address"
				}
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