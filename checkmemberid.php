<?php /* Created on: 22/7/2013 */ ?>
<?php
require 'db.php';

if( isset($_GET['renewMemberID']) ) { $memberid=$_GET['renewMemberID']; }
if( isset($_GET['renewLastname1']) ) { $lastname=$_GET['renewLastname1']; }
if( isset($_GET['updateMemberID']) ) { $memberid=$_GET['updateMemberID']; }
if( isset($_GET['updateLastname1']) ) { $lastname=$_GET['updateLastname1']; }

$link = @mysql_connect ($server, $username, $password)
or die (mysql_error());

if (!@mysql_select_db($database, $link)) {   // leave the database 
                                           // name as anydb for now
                                           
     echo "<p>There has been an error. This is the error message:</p>";
     echo "<p><strong>" . mysql_error() . "</strong></p>";
     echo "Please Contant Your Systems Administrator with the details";
} 

// check the member_id entered by the user
$sql_query = "SELECT * FROM members WHERE member_id=\"".$memberid."\" AND LOWER(last_name)=LOWER(\"".$lastname."\")";

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