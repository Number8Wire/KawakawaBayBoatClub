<?php
	require 'db.php';
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
	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	<?php
		$link = @mysql_connect ($server, $username, $password)
		or die (mysql_error());
	
		if (!@mysql_select_db($database, $link)) {   // leave the database 
												   // name as anydb for now
												   
		echo "<p>There has been an error. This is the error message:</p>";
		echo "<p><strong>" . mysql_error() . "</strong></p>";
		echo "Please Contant Your Systems Administrator with the details";
		} 
		
		$result = mysql_query("SELECT news_file FROM news WHERE news_id=\"-1\"", $link);
		if (!$result) {
			echo("<p>Error performing query, $sql_query: " . mysql_error() . "</p>");
			mysql_close ($link);
			exit();
		} 
		
		$row = mysql_fetch_row($result);
		$memberApplicationFormFile = $row[0];
		
		mysql_close ($link);
	?>

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
			<h2>New Membership Application</h2>
			<p>New members please fill out the form below and submit the membership application using the 'Submit' button at the bottom of the form.</p>
			<p>The costs for membership at the Kawakawa Bay Boat Club are listed below.</p>
			<p>Initial Joining Fee (includes current season membership) $175</p>
			<p>Annual Membership Fee $100</p>
			<p>Membership runs from the 1st of August to the 31st of July each year.</p>
			<p>To join the Boat Club fill in the online form below or <a href="documents/members/<?php echo $memberApplicationFormFile ?>">click here</a> to download the membership application form.</p>
			<p><a href="documents/Rules.pdf" target="_blank">Click here</a> to view the Kawakawa Bay Boat Club Rules.</p>
			<p><a href="javascript:;" data-toggle="modal" data-target="#termsModal">Click here</a> to view the Membership Application Terms & Conditions.</p>
			<p>Payment can be made by Direct Credit into Club Account ASB 12-3031-0701479-000 or post your Cheque if you prefer to Kawakawa Bay Boat Club Inc., Kawakawa Bay, RD5, Papakura, 2585.</p>
			<p class="red">fields with a red label must be filled in</p>

			<div class="container">
				<div class="row table-padded">
					<!-- heading row -->
					<div class="col-md-12" align="center"><h4>Applicant Info:</h4></div>
				</div>
				<!-- Applicant details -->
				<form name="membershipNew" action="addmember.php" method="post" id="membershipNew">
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Salutation: </div>
						<div class="col-md-2"><select name="salutation" id="salutation"><option value="Dr">Dr</option><option value="Miss">Miss</option><option value="Mr" selected="selected">Mr</option><option value="Mrs">Mrs</option><option value="Ms">Ms</option><option value="Mr & Mrs">Mr & Mrs</option><option value="Mr & Ms">Mr & Ms</option><option value="Mr & Miss">Mr & Miss</option></select></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3 red">First Name: </div>
						<div class="col-md-2"><input type="text" name="firstname" id="firstname" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Middle Name: </div>
						<div class="col-md-2"><input type="text" name="middlename" id="middlename" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3 red">Last Name: </div>
						<div class="col-md-2"><input type="text" name="lastname" id="lastname" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3 red">House Number: </div>
						<div class="col-md-2"><input type="text" name="house" id="house" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3 red">Street: </div>
						<div class="col-md-2"><input type="text" name="street" id="street" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3 red">Suburb: </div>
						<div class="col-md-2"><input type="text" name="suburb" id="suburb"/></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3 red">City / Postcode: </div>
						<div class="col-md-2"><input type="text" name="city" id="city" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3 red">Phone 1: </div>
						<div class="col-md-2"><input type="text" name="phone1" id="phone1" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Phone 2: </div>
						<div class="col-md-2"><input type="text" name="phone2" id="phone2" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Phone 3: </div>
						<div class="col-md-2"><input type="text" name="phone3" id="phone3" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Email: </div>
						<div class="col-md-2"><input type="text" name="email" id="email" /></div>
					</div>
	
					<!-- horizontal divider line -->
					<div class="row">
						<div class="col-md-12"><hr width="80%"</div>
					</div>
	
					<!-- Vessel details -->
					<div class="row table-padded">
						<div class="col=md-12" align="center"><h4>Vessel Details:</h4></div>
					</div>

					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Vessel Name: </div>
						<div class="col-md-2"><input type="text" name="vesselname" id="vesselname" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Type: </div>
						<div class="col-md-2"><select name="vesseltype"><option value="power">Power</option><option value="sail">Sail</option></select></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Colour: </div>
						<div class="col-md-2"><input type="text" name="colour" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Length: </div>
						<div class="col-md-2"><input type="text" name="length" />m</div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Beam: </div>
						<div class="col-md-2"><input type="text" name="beam" />m</div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Trailer Registration: </div>
						<div class="col-md-2"><input type="text" name="trailer" id="trailer" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Radio Call Sign: </div>
						<div class="col-md-2"><input type="text" name="radio" /></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Motor Type: </div>
						<div class="col-md-2"><select name="motortype"><option value="outboard">Outboard</option><option value="inboard">Inboard</option></select></div>
					</div>
					<div class="row table-padded-less">
						<div class="col-md-2 col-md-offset-3">Motor Horsepower: </div>
						<div class="col-md-2"><input type="text" name="motorhp" />hp</div>
					</div>
					<!-- Accept Terms and Conditions -->
					<div class="row table-padded">
						<div class="col-md-6 red" align="right">I Accept the Terms and Conditions:</div>
						<div class="col-md-1"><input type="checkbox" id="termsAccept" name="termsAccept" /></div>
					</div>
					<!-- reCAPTCHA v2 -->
					<div class="row table-padded">
						<div class="col-md-7" align="right">
							<div class="g-recaptcha" data-sitekey="<?php echo $siteKey ?>" data-callback="recaptchaCallback"></div>
							<br/>
						</div>
					</div>
					<div class="row table-padded">
						<div class="col-md-12"><a href="javascript:;" data-toggle="modal" data-target="#termsModal">Membership Application Terms & Conditions</a></div>
					</div>
					<div class="row table-padded">
						<div class="col-md-12"><a href="documents/Rules.pdf" target="_blank">Click here</a> to view the Kawakawa Bay Boat Club Rules.</div>
					</div>
					</div>
					<div class="row table-padded">
						<div class="col-md-12">Payment can be made by Direct Credit into Club Account ASB 12-3031-0701479-000 or post your Cheque if you prefer to Kawakawa Bay Boat Club Inc., Kawakawa Bay, RD5, Papakura, 2585.</div>
					</div>
					<div class="row table-padded">
						<div class="col-md-12" align="center">
							<p>Click on the Submit button below to submit your membership to the Kawakawa Bay Boat Club Administrator.</p>
						</div>
					</div>
					<div class="row table-padded	">
						<div class="col-md-12" align="center"><input type="submit" id="memberSubmitButton" value="Submit" align="center" /></div>
					</div>
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
			<hr class="black" />
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
	
   <!-- Terms Modal
    ================================================== -->
	<div class="modal fade" id="termsModal" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
		<div class="modal-dialog">
	    	<div class="modal-content login-modal">
	      		<div class="modal-header login-modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title text-center" id="termsModalLabel1">KAWAKAWA BAY BOAT CLUB</h4>
					<h4 class="modal-title text-center" id="termsModalLabel2">Membership Application Terms and Conditions</h4>
				</div>
				<div class="modal-body">
					<ol>
						<li>Applying via the internet or on the standard application form does not guarantee membership to the Kawakawa Bay Boat Club.  Membership applications will remain pending until the membership committee accepts the application and the payment has cleared.  If for any reason, your application is declined, a refund will be issued.</li>
						<li>By submitting a membership application, you agree to abide by the club rules at all times, and accept that if you breach the rules your membership could be forfeited. <a href="documents/Rules.pdf" target="_blank">Click here</a> to view the Kawakawa Bay Boat Club Rules.</li>
						<li>You must be financial at all times and if you are not a financial member you will be treated as a member of the public until you pay any past due fees.</li>
					</ol>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-block bt-login" data-dismiss="modal" >OK</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery-1.12.3.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="js/ie10-viewport-bug-workaround.js"></script>

    <script>
		var recaptchachecked;
		function recaptchaCallback() {
			//If we managed to get into this function it means that the user checked the checkbox.
			recaptchachecked = true;
		}			

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
			
			$( "#membershipNew" ).validate({
				rules: {
					firstname: "required",
					lastname: "required",
					house: "required",
					street: "required",
					suburb: "required",
					city: "required",
					phone1: "required",
//					email: {
//						required: true,
//						email: true
//						},
					termsAccept: "required"
				},
				messages: {
					firstname: "Please enter your first name",
					lastname: "Please enter your last name",
					house: "Please enter your house address number",
					street: "Please enter your street",
					suburb: "Please enter your suburb",
					city: "Please enter your city or postcode",
					phone1: "Please enter your phone number",
//					email: "Please enter your email address",
					termsAccept: "Please accept our Terms and Conditions"
				}
			});
			
			 $('#memberSubmitButton').on('click',function(e) {
				e.preventDefault();
				if (!recaptchachecked) {
					alert("Please click the reCAPTCHA box to prove you are not a robot");
				}
				if ($("#termsAccept").prop('checked') && $("#membershipNew").valid() && recaptchachecked) {
					$(this).val('Please wait ...');
					$(this).addClass('bg-red');
					$(this).attr('disabled',true);
					$('#membershipNew').submit();
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
alt="tumblr visitor" /></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

</body>
</html>