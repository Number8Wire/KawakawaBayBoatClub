<?php
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

	<?php
		$link = @mysql_connect ($server, $username, $password)
		or die (mysql_error());
	
		if (!@mysql_select_db($database, $link)) {   // leave the database 
												   // name as anydb for now
												   
		echo "<p>There has been an error. This is the error message:</p>";
		echo "<p><strong>" . mysql_error() . "</strong></p>";
		echo "Please Contant Your Systems Administrator with the details";
		} 
		
		$result = mysql_query("SELECT DATE_FORMAT(news_date, '%D %b, %Y') AS display_date, news_title FROM news WHERE news_id>0 ORDER BY news_date DESC", $link);
		if (!$result) {
			echo("<p>Error performing query: " . mysql_error() . "</p>");
			mysql_close ($link);
			exit();
		} 
		
		$rows = mysql_num_rows($result);
		$i = 0;
		$news = "";
		while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
			$i++;
			$date = $row['display_date'];
			$title = $row['news_title'];
			$text = substr($title, 0, 85);
			$text .= " ...";
			$news .= "<p>".$date."<br><b>".$text."</b> <a href=\"news.php\">more</a></p>\n";
			if ($i < $rows)
				{
				$news .= "<hr class=\"black\" width=\"40%\"\n";
				}
		}

		$result = mysql_query("SELECT news_file FROM news WHERE news_id=\"0\"", $link);
		if (!$result) {
			echo("<p>Error performing query, $sql_query: " . mysql_error() . "</p>");
			mysql_close ($link);
			exit();
		} 
		
		$row = mysql_fetch_row($result);
		$newsFile = $row[0];
		
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
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12';
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

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
					<li class="active"><a href="index.php">Home</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Membership <span class="caret"</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="membershipcurrent.html">Current Members</a></li>
                            <li><a href="membershipnew.php">New Members</a></li>
                        </ul>
					</li>
					<li><a href="news.php">News</a></li>
					<li><a href="boating.html">Boating</a></li>
					<li><a href="weather.html">Weather</a></li>
					<li><a href="webcam.php">WebCam</a></li>
					<li><a href="gallery.php">Photos</a></li>
					<li><a href="juniors.html">Juniors</a></li>
					<li><a href="contact.html">Contact Us</a></li>
					<li><a href="links.html">Links</a></li>
				</ul>
			</div> <!--/.nav-collapse -->
		</div>
	</nav>

    <!-- Home Page
    ================================================== -->
	<div class="container">
		<div id="home" class="starter-template">
			<img src="images/KBBC-Ramp-2.jpg" class="img-responsive center-block" alt="Kawakawa Bay Boat Club" border="0">
			<div class="col-md-12">
				<h2>Welcome to the Kawakawa Bay Boat Club.</h2>
				<h4 align="center">The main ramp for access to the Hauraki Gulf, South East of Auckland, New Zealand.</h4>
				<hr width="70%">
			</div>
			<div class="col-md-2 col-md-offset-2 text-center">
				<a  href="webcam.php"  class="btn btn-default" role="button">Webcam</a>
			</div>
			<div class="col-md-2 col-md-offset-1 text-center">
				<a  href="tel:+6492922131"  class="btn btn-default" role="button">Call Us</a>
			</div>
			<div class="col-md-2 col-md-offset-1 text-center">
				<a  href="javascript:;"  class="btn btn-default" role="button" data-toggle="modal" data-target="#rampProtocolModal">Ramp Usage Protocol</a>
			</div>
			
			<div class="col-md-7 col-md-offset-4 col-xs-9 col-xs-offset-3">
				<h2 align="center"><div class="fb-like text-center" data-href="https://www.facebook.com/kawakawabayboatclub/" data-layout="standard" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div></h2>
			</div>
			
			<div class="col-md-12">
				<hr width="90%">	
				<p align="center"><a href="mailto:boatclub@kbbc.co.nz?subject=Enquiry from KBBC website">Click here</a> to contact us for general enquiries</p>
				<p align="center">Membership runs from the 1st of August to the 31st of July each year.</p>
				<p align="center">You can join for $175 (current season) and an ongoing annual fee of $100 to use our ramp with all weather launching facilities complete with pontoons and sea wall.</p>
				<p align="center">Casual usage of the boat ramp available for non members is $20 per day, payable on arrival at ramp</p>
				<p align="center">The key goals and aspirations of the club include:</p>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<ul class="text-left" style="list-style-position: inside; vertical-align: middle;">
							<li>Providing safe and secure boat launching and recovery facilities for its members and the general public (who pay a fee).</li>
							<li>Supporting and encouraging safety at sea.</li>
							<li>Promoting youth involvement in water sports through our junior sailing programme.</li>
						</ul>
					</div>
				</div>
				<p align="center"><a href="documents/newsletter/<?php echo $newsFile ?>" target="_blank">Click here</a> to view our latest Newsletter.</p>
				<p align="center"><a href="documents/Rules.pdf" target="_blank">Click here</a> for the Rules of the Kawakawa Bay Boat Club.</p>
				<hr class="black">
				<h4>Latest News:</h3>
				<?php echo $news; ?>
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
								<input align="center" type="text" name="name" class="form-control" placeholder="your name">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
								<input align="center" type="email" name="email" class="form-control" placeholder="your email address">
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
									<input align="center" type="text" class="form-control" name="login" id="login" placeholder="username">
								</div>
								<span class="help-block has-error" id="email-error"></span>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-lock"></i></div>
									<input type="password" class="form-control" name="password" id="password" placeholder="password">
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
	
  <!-- Ramp Protocol Modal
    ================================================== -->
	<div class="modal fade" id="rampProtocolModal" role="dialog" aria-labelledby="rampProtocolModalLabel" aria-hidden="true">
		<div class="modal-dialog">
	    	<div class="modal-content login-modal">
	      		<div class="modal-header login-modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title text-center" id="rampProtocolModalLabel1">KAWAKAWA BAY BOAT CLUB</h4>
					<h4 class="modal-title text-center" id="rampProtocolModalLabel2">Ramp Protocol</h4>
				</div>
				<div class="modal-body">
					<ol>
						<li>
							Prepare for launching before entering the ramp area:
							<ul>
								<li>
									Straps & lights to be removed
								</li>
								<li>
									Bungs in
								</li>
								<li>
									Gear stowed in boat
								</li>
							</ul>
						</li>
						<li>Follow instructions of Ramp Staff</li>
						<li>After retrieval of your vessel, leave the ramp area and move up to the roadside to prepare for travel</li>
						<li>The Speed Limit for all vehicles entering & leaving the ramp area is 5 kph</li>
						<li>The Speed Limit for all vessels entering & leaving the ramp area is 5 knots within 200m of shore</li>
					</ol>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-block bt-login" data-dismiss="modal" >OK</button>
				</div>
			</div>
		</div>
	</div>
 	<!-- - Ramp Protocol Model Ends Here -->

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