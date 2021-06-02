<?php /* Created on: 23/2/2012 */ ?>
<?php
  require 'db.php';

  //Add Code here to $_GET['id'] and $_GET['value'] and update
  $data=$_GET['id'];
  $array=explode("|", $data);
  $row=0;
  $result=0;
  $sql_query=0;
  
  
  $link = @mysql_connect ($server, $username, $password)
  or die (mysql_error());
  
  if (!@mysql_select_db($database, $link)) {   // leave the database 
											 // name as anydb for now
											 
	   echo "<p>There has been an error. This is the error message:</p>";
	   echo "<p><strong>" . mysql_error() . "</strong></p>";
	   echo "Please Contant Your Systems Administrator with the details";
  } 
  
  $sql_query = sprintf ("SELECT SQL_NO_CACHE %s, NOW() FROM members where unique_id=\"%s\"", $array[1], $array[0]);
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query, $sql_query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  $row = mysql_fetch_row($result);
  
  mysql_close ($link);
  
  //echo $data;
  echo $row[0];

?>