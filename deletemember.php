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
  
  // get member_id of the member being deleted so we can set the vessels table correctly (set member_id blank and member_uid to unique_id) in vessels table
  $sql_query = "SELECT member_id FROM members WHERE unique_id=\"".$uid."\"";
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query $sql_query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  // update the vessels table
  while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	  $mid = $row['member_id'];
	  }
	  
  // update the vessels table
  $sql_query = "UPDATE vessels SET member_id=\"0\", member_uid=\"".$uid."\" WHERE member_id=\"".$mid."\"";
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 

  // update the members table
  $sql_query = "UPDATE members SET member_id=\"\", membership_status=\"Deleted\" WHERE unique_id=\"".$uid."\"";
  
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