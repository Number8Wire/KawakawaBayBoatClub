<?php /* Created on: 22/7/2013 */ ?>
<?php
require 'db.php';

if( isset($_GET['renewFirstname2']) ) { $firstname=$_GET['renewFirstname2']; }
if( isset($_GET['renewLastname2']) ) { $lastname=$_GET['renewLastname2']; }
if( isset($_GET['updateFirstname2']) ) { $firstname=$_GET['updateFirstname2']; }
if( isset($_GET['updateLastname2']) ) { $lastname=$_GET['updateLastname2']; }
//$trailerreg=$_GET['trailerreg'];

$link = @mysql_connect ($server, $username, $password)
or die (mysql_error());

if (!@mysql_select_db($database, $link)) {   // leave the database 
                                           // name as anydb for now
                                           
     echo "<p>There has been an error. This is the error message:</p>";
     echo "<p><strong>" . mysql_error() . "</strong></p>";
     echo "Please Contant Your Systems Administrator with the details";
} 

// check the first and last names and trailer registration entered by the user
//$sql_query = "SELECT * FROM members LEFT JOIN vessels ON members.member_id = vessels.member_id WHERE LOWER(members.first_name) = LOWER(\"".$firstname."\") AND LOWER(members.last_name) = LOWER(\"".$lastname."\") AND LOWER(vessels.trailer_reg) = LOWER(\"".$trailerreg."\")";
$sql_query = "SELECT * FROM members WHERE LOWER(first_name) = LOWER(\"".$firstname."\") AND LOWER(last_name) = LOWER(\"".$lastname."\")";

$result = mysql_query($sql_query, $link);
if (!$result) {
  echo("<p>Error performing query: " . mysql_error() . "</p>");
	mysql_close ($link);
  exit();
} 

if(mysql_num_rows($result)==0){
	$valid = false;
}
else {
	$valid = true;
}

echo json_encode($valid);
?>