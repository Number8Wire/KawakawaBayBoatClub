<?php /* Created on: 8/11/2011 */ ?>
<?php
	require_once ("auth.php");
	require 'db.php';

  //Add Code here to $_POST['id'] and $_POST['value'] and update
  $member_id=$_POST['id'];
  $member_value=$_POST['value'];
  $id=explode("|", $member_id);
  
  $link = @mysql_connect ($server, $username, $password)
  or die (mysql_error());
  
  if (!@mysql_select_db($database, $link)) {   
  //if (!@mysql_select_db("tim_kbbc", $link)) {   
	   echo "<p>There has been an error. This is the error message:</p>";
	   echo "<p><strong>" . mysql_error() . "</strong></p>";
	   echo "Please Contant Your Systems Administrator with the details";
  } 
  
  if ($id[1] == "date_paid")
	  {
	  $date_value = explode("/", $member_value);
	  $member_value = $date_value[2] . "/" . $date_value[1] . "/" . $date_value[0];
	  }
  
  // if the member_id field has been changed we need to update the corresponding field in the vessel table
  if ($id[1] == "member_id")
	  {
	  // get current member_id value
	  $sql_query = sprintf ("SELECT member_id FROM members WHERE unique_id=%s", $id[0]);
	  
	  $result = mysql_query($sql_query, $link);
	  if (!$result) 
		  {
		echo("<p>Error performing query to get old member id, $sql_query: " . mysql_error() . "</p>");
		  mysql_close ($link);
		exit();
		  } 
	  $row = mysql_fetch_row($result);
	  $old_member_id = $row[0];
	  }
  
  //$sql_query = "UPDATE members SET ".$id[1]."=\"".$member_value."\" where unique_id=".$id[0];
  $member_val = mysql_real_escape_string($member_value);
  //$member_val = htmlspecialchars_decode($member_val, ENT_NOQUOTES);
  $sql_query = sprintf ("UPDATE members SET %s =\"%s\" WHERE unique_id=%s", $id[1], $member_val, $id[0]);
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query, $sql_query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  // if the member_id field has been changed we need to update the corresponding field in the vessel table
  if ($id[1] == "member_id")
	  {
	  // update the corresponding vessel record(s)
	  $sql_query = sprintf ("UPDATE vessels SET member_id =\"%s\" WHERE member_id=\"%s\"", $member_val, $old_member_id);
	  
	  $result = mysql_query($sql_query, $link);
	  if (!$result) 
		  {
		echo("<p>Error performing query to update vessel table with new member_id, $sql_query: " . mysql_error() . "</p>");
		  mysql_close ($link);
		exit();
		  } 
	  }
  
  // read the value back from the database
  if ($id[1] == "date_paid")
	  {
		  $sql_query = "SELECT SQL_NO_CACHE DATE_FORMAT(date_paid, '%d/%m/%Y') FROM members WHERE unique_id=" . $id[0];
	  }
	  else
	  {
		  $sql_query = sprintf ("SELECT SQL_NO_CACHE %s FROM members WHERE unique_id=%s", $id[1], $id[0]);
	  }
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query$sql_query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  $row = mysql_fetch_row($result);
  
  mysql_close ($link);
  
  echo $row[0];
  
  //echo $sql_query;
  //echo "<img src='images/indicator1.gif'>";

?>