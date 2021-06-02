<?php /* Created on: 15/09/2011 */ ?>
<?php
	require_once ("auth.php");
	require 'db.php';

  //Add Code here to $_POST['id'] and $_POST['value'] and update
  $news_id=$_POST['id'];
  $news_value=$_POST['value'];
  $id=explode("|", $news_id);
  
  $link = @mysql_connect ($server, $username, $password)
  or die (mysql_error());
  
  if (!@mysql_select_db($database, $link)) {   // leave the database 
											 // name as anydb for now
											 
	   echo "<p>There has been an error. This is the error message:</p>";
	   echo "<p><strong>" . mysql_error() . "</strong></p>";
	   echo "Please Contant Your Systems Administrator with the details";
  } 
  
  $sql_query = "UPDATE news SET ".$id[1]."=\"".$news_value."\" where news_id=".$id[0];
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query, $sql_query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  mysql_close ($link);
  
  //echo "<img src='images/indicator1.gif'>";
  echo $news_value;

?>