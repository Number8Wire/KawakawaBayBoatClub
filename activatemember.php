<?php
  require_once ("auth.php");
  require 'db.php';

  $uid=$_GET['unique_id'];
  
  $link = @mysql_connect ($server, $username, $password)
  or die (mysql_error());
  
  if (!@mysql_select_db($database, $link)) {   // leave the database 
											 // name as anydb for now
											 
	   echo "<p>There has been an error. This is the error message:</p>";
	   echo "<p><strong>" . mysql_error() . "</strong></p>";
	   echo "Please Contant Your Systems Administrator with the details";
  } 
  
  $sql_getmissingnumber = "SELECT (t1.member_id + 1) as gap_starts_at, (SELECT MIN(t3.member_id) -1 FROM members t3 WHERE t3.member_id > t1.member_id) as gap_ends_at FROM members t1 WHERE NOT EXISTS (SELECT t2.member_id FROM members t2 WHERE t2.member_id = t1.member_id + 1)";
  
  $result1 = mysql_query($sql_getmissingnumber, $link);
  if (!$result1) {
	echo("<p>Error performing query to get lowest missing Member Number, $sql_getmissingnumber: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  $lowest = mysql_fetch_array($result1, MYSQL_BOTH);
  
//  echo ("lowest available number = ".$lowest[0]);
  
  $new_member_id = $lowest[0];
  
  $sql_query = "UPDATE members SET member_id=\"".$new_member_id."\", membership_status=\"Active\" WHERE unique_id=\"".$uid."\"";
 
//  echo $sql_query;
// exit;
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query $sql_query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  //set the new member_id in the vessels table
  $sql_query = "UPDATE vessels SET member_id=\"".$new_member_id."\", member_uid=\"0\" WHERE member_uid=\"".$uid."\"";
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query $sql_query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  mysql_close ($link);
  
  header( 'Location: http://www.kbbc.co.nz/editmembers.php' ) ;
  //header( 'Location: http://localhost/editmembers.php' ) ;

?>