<?php /* Created on: 9/11/2011 */ ?>
<?php
	require_once ("auth.php");
	require 'db.php';

  //Add Code here to $_POST['id'] and $_POST['value'] and update
  $unique_id=$_POST['id'];
  $vessel_value=$_POST['value'];
  $id=explode("|", $unique_id);
  
  $link = @mysql_connect ($server, $username, $password)
  or die (mysql_error());
  
  if (!@mysql_select_db($database, $link)) {   // leave the database 
											 // name as anydb for now
											 
	   echo "<p>There has been an error. This is the error message:</p>";
	   echo "<p><strong>" . mysql_error() . "</strong></p>";
	   echo "Please Contant Your Systems Administrator with the details";
  } 
  $vessel_val = mysql_real_escape_string($vessel_value);
  $sql_query = "UPDATE vessels SET ".$id[1]."=\"".$vessel_val."\" where unique_id=".$id[0];
  
  //echo $sql_query;
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query: " . mysql_error() . "</p>");
  //	echo $sql_query;
	  mysql_close ($link);
	exit();
  } 
  
  mysql_close ($link);
  
  //echo ($sql_query);
  echo $vessel_value;

?>