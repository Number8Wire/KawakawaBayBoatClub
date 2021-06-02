<?php
	require 'db.php';
		
	$first_name=$_POST['firstname'];
	$middle_name=$_POST['middlename'];
	$last_name=$_POST['lastname'];
	$salutation=$_POST['salutation']; $salutation = $salutation . " " . $first_name[0];
	$house=$_POST['house'];
	$street=$_POST['street'];
	$suburb=$_POST['suburb'];
	$city=$_POST['city'];
	$phone1=$_POST['phone1'];
	$phone2=$_POST['phone2'];
	$phone3=$_POST['phone3'];
	$email=$_POST['email'];

	if (isset ($_POST['vesselname'])) { $vessel_name=$_POST['vesselname']; } else { $vesselname=""; }
	if (isset ($_POST['vesseltype'])) { $vessel_type=$_POST['vesseltype']; } else { $vessel_type=""; }
	if (isset ($_POST['colour'])) { $vessel_colour=$_POST['colour']; } else { $vessel_colour=""; }
	if ($_POST['length']!="") { $vessel_length=$_POST['length']; } else { $vessel_length="";}
	if ($_POST['beam']!="") { $vessel_beam=$_POST['beam']; } else { $vessel_beam=""; }
	if (isset ($_POST['trailer'])) { $trailer_reg=$_POST['trailer']; } else { $trailer_reg=""; }
	if (isset ($_POST['radio'])) { $radio_call=$_POST['radio']; } else { $radio_call=""; }
	if (isset ($_POST['motortype'])) { $motor_type=$_POST['motortype']; } else { $motor_type=""; }
	if ($_POST['motorhp']!="") { $motor_hp=$_POST['motorhp']; } else { $motor_hp=""; }

	if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
    }
//    if(!$captcha){
//	    echo '<p>Please check the captcha form.</p>';
//        exit;
//    }

	// Create connection
	$conn = new mysqli($server, $username, $password, $database);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$ip = $_SERVER['REMOTE_ADDR'];
	// post request to server
	$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
	$response = file_get_contents($url);
	$responseKeys = json_decode($response,true);
	// should return JSON with success as true
	if($responseKeys["success"]) {
		// check for required parameters
		if (empty($first_name) || empty($last_name) || empty($house) || empty($street) || empty($city) || empty($phone1)) {
	
			$sql_query = "INSERT INTO attacks (date, first_name, last_name, house, street, city, phone1, email)";
			$sql_query .= "VALUES (NOW(),?,?,?,?,?,?,?)";
	
			if ($stmt = $conn->prepare($sql_query)) {
			  /* Binds variables to prepared statement
			  i    corresponding variable has type integer
			  d    corresponding variable has type double
			  s    corresponding variable has type string
			  b    corresponding variable is a blob and will be sent in packets */
			  $stmt->bind_param('sssssss', $first_name, $last_name, $house, $street, $city, $phone1, $email);
			  /* execute statement */
			  $stmt->execute();
			  $stmt->close();
			}
			else {
			  echo("<p>Error inserting Attack: " . $conn->error . "</p>");
			  $stmt->close();
			  exit();
			} 
		} 
	
		$query_getmissingnumber = "SELECT l.member_id + 1 AS START FROM members as l LEFT OUTER JOIN members AS r ON l.member_id + 1 = r.member_id WHERE r.member_id is NULL";
		
		if ($stmt = $conn->prepare($query_getmissingnumber)) {
			/* execute statement */
			$stmt->execute();
			/* bind result variables */
			$result = $stmt->store_result();
			$stmt->bind_result($lowest);
			/* fetch values */
			while ($stmt->fetch()) {
//					echo("<p>lowest - ".$lowest.".</p>");
			}
			/* close statement */
			$stmt->close();
		}
		else {
		  echo("<p>Error performing Member Number query</p>");
		  $stmt->close();
		  exit();
		} 
		
		$new_member_id = strval($lowest);
		
    if (empty($new_member_id)) {
      //echo("<p>new_member_id is empty</p>");
      // get highest member_id
      $conn = new mysqli($server, $username, $password, $database);
      $con = mysqli_connect($server, $username, $password) or die($connect_error);
      mysqli_select_db($con, $database) or die($connect_error);
      $result = mysqli_query($con, "SELECT MAX(CAST(member_id AS UNSIGNED)) + 1 AS highest_id FROM members");
      while ($row = mysqli_fetch_assoc($result)) {
        $highest = $row['highest_id'];             
      }
      //echo("</p>highest - ".$highest.".</p>");
      $new_member_id = $highest;
      mysqli_free_result($result);
      mysqli_close($con); 
    }
		
		$year = date("Y");
		$month = date("n");
		$full_street = $house." ".$street;
		
		if ($month > 9) {$year++;}
	
		//insert member data into the member table
		$sql_query = 'INSERT into members ';
		$sql_query .= '(member_id, first_name, middle_name, last_name, salutation, address1, address2, address3, phone1, phone2, phone3, email, status, membership_status, renewal_or_new, application_date) ';
		$sql_query .= 'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,"Pending","Pending","N",NOW())';
	
		if ($stmt = $conn->prepare($sql_query)) {
			/* Binds variables to prepared statement
			i    corresponding variable has type integer
			d    corresponding variable has type double
			s    corresponding variable has type string
			b    corresponding variable is a blob and will be sent in packets */
			$member_status="Active";
			$new = "N";
			$rc = $stmt->bind_param('ssssssssssss',$new_member_id, $first_name, $middle_name, $last_name, $salutation, $full_street, $suburb, $city, $phone1, $phone2, $phone3, $email);
			// bind_param() can fail because the number of parameter doesn't match the placeholders in the statement
			// or there's a type conflict(?), or ....
			if ( false===$rc ) {
				// again execute() is useless if you can't bind the parameters. Bail out somehow.
				die('bind_param() failed: ' . htmlspecialchars($stmt->error));
			}

			/* execute statement */
			$rg = $stmt->execute();
			// execute() can fail for various reasons. And may it be as stupid as someone tripping over the network cable
			// 2006 "server gone away" is always an option
			if ( false===$rc ) {
				die('execute() failed: ' . htmlspecialchars($stmt->error));
			}

			// get the automatically generated unique id for this vessel
			$new_member_uid = mysqli_insert_id($conn);
			$stmt->close();
		}
		else {
			echo("<p>Error inserting Member</p>");
			$stmt->close();
			exit();
		} 
	
		//insert the vessel details into the vessel table
		$sql_query = "INSERT INTO vessels ";
		$sql_query .= "(member_uid, member_id, name, type, colour, length, beam, trailer_reg, radio_callsign, motor_type, motor_hp)";
		$sql_query .= "VALUES (?,?,?,?,?,?,?,?,?,?,?)";
	
		if ($stmt = $conn->prepare($sql_query)) {
		  /* Binds variables to prepared statement
		  i    corresponding variable has type integer
		  d    corresponding variable has type double
		  s    corresponding variable has type string
		  b    corresponding variable is a blob and will be sent in packets */
		  $stmt->bind_param('issssssssss',$new_member_uid, $new_member_id, $vessel_name, $vessel_type, $vessel_colour, $vessel_length, $vessel_beam, $trailer_reg, $radio_call, $motor_type, $motor_hp);
		  /* execute statement */
		  $stmt->execute();
		  $stmt->close();
		}
		else {
		  echo("<p>Error inserting Vessel</p>");
		  $stmt->close();
		  exit();
		} 
	
		$conn->close();
		
		if (!empty($first_name) && !empty($last_name) && !empty($house) && !empty($street) && !empty($city) && !empty($phone1)) {
			$headers = 'From: boatclub@kbbc.co.nz' . PHP_EOL ;
	//		           'Bcc: secretary@kbbc.co.nz' . PHP_EOL;
			$subject = "New Membership application from the website ($new_member_id)";
			$body = "Hi,\n\nYou have a new membership application from the Kawakawa Bay Boat Club website.\nThe details of the application are as follows:\n\n";
			$details = "Member ID: '$new_member_id',\n";
			$details .= "First Name: '$first_name',\n";
			$details .= "Middle Name: '$middle_name',\n";
			$details .= "Last Name: '$last_name',\n";
			$details .= "Salutation: '$salutation',\n";
			$details .= "Address 1: '$full_street',\n";
			$details .= "Address 2: '$suburb',\n";
			$details .= "Address 3: '$city',\n";
			$details .= "Phone 1: '$phone1',\n";
			$details .= "Phone 2: '$phone2',\n";
			$details .= "Phone 3: '$phone3',\n";
			$details .= "Email: '$email'.\n\n";
			$details .= "Vessel details:\n";
			$details .= "Name: '$vessel_name',\n";
			$details .= "Type: '$vessel_type',\n";
			$details .= "Colour: '$vessel_colour',\n";
			$details .= "Length: '$vessel_length',\n";
			$details .= "Beam: '$vessel_beam',\n";
			$details .= "Trailer Registration: '$trailer_reg',\n";
			$details .= "Radio Call; '$radio_call',\n";
			$details .= "Motor Type: '$motor_type',\n";
			$details .= "Motor HP: '$motor_hp'.\n\n";
			
			$member_details = "First Name: '$first_name',\n";
			$member_details .= "Middle Name: '$middle_name',\n";
			$member_details .= "Last Name: '$last_name',\n";
			$member_details .= "Salutation: '$salutation',\n";
			$member_details .= "Address 1: '$full_street',\n";
			$member_details .= "Address 2: '$suburb',\n";
			$member_details .= "Address 3: '$city',\n";
			$member_details .= "Phone 1: '$phone1',\n";
			$member_details .= "Phone 2: '$phone2',\n";
			$member_details .= "Phone 3: '$phone3',\n";
			$member_details .= "Email: '$email'.\n\n";
			$member_details .= "Vessel details:\n";
			$member_details .= "Name: '$vessel_name',\n";
			$member_details .= "Type: '$vessel_type',\n";
			$member_details .= "Colour: '$vessel_colour',\n";
			$member_details .= "Length: '$vessel_length',\n";
			$member_details .= "Beam: '$vessel_beam',\n";
			$member_details .= "Trailer Registration: '$trailer_reg',\n";
			$member_details .= "Radio Call; '$radio_call',\n";
			$member_details .= "Motor Type: '$motor_type',\n";
			$member_details .= "Motor HP: '$motor_hp'.\n\n";
	
			$body .= $details;
			$body .= "\n\nregards,\nThe Kawakawa Bay Boat Club Website.\n";
			
			if (mail($to, $subject, $body, $headers)) {
				$email_result1 = "<p>Your Membership application has been successfully sent to the Kawakawa Bay Boat Club</p>";
			} else {
				$email_result1 = "<p>Your Membership application email delivery <b>failed</b>. Please call <b>the Kawakawa Bay Boat Club</b> on <b>292 3131</b> to confirm your application.</p>";
			}
		}
		
		if (!empty($email)) {
			$to = $email;
			$headers = 'From: boatclub@kbbc.co.nz' . PHP_EOL;
			$headers .= 'Bcc: boatclub@kbbc.co.nz' . PHP_EOL;
			$subject = "Kawakawa Bay Boat Club Membership application";
			$body = "Hi ".$first_name.",\n\nThanks for your Membership application for the Kawakawa Bay Boat Club.\n\n";
			$body .= "Your application is pending until we receive payment and the application is accepted by the Committee.\n\n";
			$body .= "Payment can be made by Direct Credit at the ASB or through Internet Banking into Club Account ASB 12-3031-0701479-000 or post your Cheque if you prefer to Kawakawa Bay Boat Club Inc., Kawakawa Bay, RD5, Papakura, 2585.\n\n";
			$body .= "The details of your application are as follows:\n\n";
			$body .= $member_details;
			$body .= "\n\nWe will be in contact shortly to confirm your membership.\n\nregards\nThe Kawakawa Bay Boat Club.\n";
			
			if (mail($to, $subject, $body, $headers)) {
			  $email_result2 = "<p>An email has been sent to your email address with the booking details.</p>";
			} else {
			  $email_result2 = "<p>Email delivery to your email address <b>failed</b>. Please call <b>the Kawakawa Bay Boat Club</b> on <b>292 3131</b> to confirm your application.</p>";
			}
		}
		
		header('Location: addmembersuccess.html');
		exit;
	} else {
		header('Location: addmemberfailure.html');
		exit;
	}
	
?>