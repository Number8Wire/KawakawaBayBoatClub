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
	<link href="css/floating-gallery.css" rel="stylesheet" type="text/css" />

    <link href="css/jquery.dm-uploader.min.css" rel="stylesheet">

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

		$query = "SELECT * FROM gallery ORDER BY position ASC";
		
		$result = mysql_query($query, $link);
		if (!$result) {
		  echo("<p>Error performing query: " . mysql_error() . "</p>");
			mysql_close ($link);
		  exit();
		} 

		$gallery = "";	
		$photos = "<table class=\"sortable\" width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\"><tr><th class=\"small\">Date Added</th><th class=\"small\">Photo File Name</th><th class=\"small\">Position</th></tr>\n";
		while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
			$uid = $row['unique_id'];
			$date_added = $row['date_added'];
			$filename = $row['filename'];
			$position = $row['position'];

			$photos .= "<tr><td>".$date_added."</td>\n";
			$photos .= "<td>".$filename."</td>\n";
			$photos .= "<td>".$position."</td></tr>\n";
			
			$gallery .= "<div class=\"imageBox\" id=\"".$uid."\">\n";
			$gallery .= "\t<div class=\"imageBox_theImage\" style=\"background-image:url('images/gallery/thumbs/".$filename."')\"></div>\n";
			$gallery .= "\t<div class=\"imageBox_label\">";
			$gallery .= "<form name=\"input\" action=\"deletegallery.php\" method=\"get\">\n";
			$gallery .= "<input type=\"hidden\" name=\"unique_id\" value=".$uid." />\n";
			$gallery .= "<p>\n";
			$gallery .= "<input type=\"submit\" value=\"Delete\" align=\"center\"/>\n";
			$gallery .= "</p>\n";
			$gallery .= "</form>\n";
			$gallery .= "</div>\n";
			$gallery .= "</div>\n\n";
		}	
		$photos .= "</table>\n";
		
		$gallery .= "<div id=\"insertionMarker\">\n";
		$gallery .= "<img src=\"images/marker_top.gif\">\n";
		$gallery .= "<img src=\"images/marker_middle.gif\" id=\"insertionMarkerLine\">\n";
		$gallery .= "<img src=\"images/marker_bottom.gif\">\n";
		$gallery .= "</div>\n";
		$gallery .= "<div id=\"dragDropContent\">\n";
		$gallery .= "</div>\n";
		$gallery .= "<div id=\"debug\" style=\"clear:both\">\n";
		$gallery .= "</div>\n";

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
		</div>
	</nav>

    <!-- Home Page
    ================================================== -->
	<div class="container">
		<div id="home" class="starter-template">
			<img src="images/KBBC-Ramp-2.jpg" class="img-responsive center-block" alt="Kawakawa Bay Boat Club" border="0">
			<h3>Photo Gallery Administration</h3>

			<form class="mb-3 dm-uploader" id="drag-and-drop-zone">
			  <div class="form-row">
				<div class="col-md-10 col-sm-12">
				  <div class="from-group mb-2">
					<label>Image Uploader</label>
					<input type="text" class="form-control" aria-describedby="fileHelp" placeholder="No image uploaded..." readonly="readonly" />
			
					<div class="progress mb-2 d-none">
					  <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
						role="progressbar"
						style="width: 0%;" 
						aria-valuenow="0" aria-valuemin="0" aria-valuemax="0">
						0%
					  </div>
					</div>
			
				  </div>
				  <div class="form-group">
					<div role="button" class="btn btn-primary mr-2">
					  <i class="fa fa-folder-o fa-fw"></i> Browse Files
					  <input type="file" title='Click to add Files' />
					</div>
					<small class="status text-muted">Select an image or drag it over this area..</small>
				  </div>
				</div>
				<div class="col-md-2  d-md-block  d-sm-none">
				  <img src="images/noimage.jpg" alt="..." class="img-thumbnail">
				</div>
			  </div>
			</form>

			<hr width="90%">
			<h2>Photo Gallery</h2>
			<p>Drag the images to change their positions in the photo gallery. Click 'Save' to save the new positioning of the images.</p>
			<?php
		      echo $gallery;
			?>
			<form name="galleryForm" action="savegallery.php" method="post">
				<div style="clear:both;padding-bottom:10px">
					<input type="hidden" name="imageIdList" id="imageIdList">
					<input type="button" style="width:100px" value="Save" onclick="saveImageOrder()">
				</div>
			</form>
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

	<script src="js/sorttable.js"></script>
	<script src="js/floating-gallery.js"></script>

    <script src="js/jquery.dm-uploader.min.js?v=v10"></script>
    <script src="js/ui-main.js?v=v10"></script>
    <script src="js/ui-single.js?v=v10"></script>
  	<script src="js/single-upload-gallery.js?v=v10"></script>

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