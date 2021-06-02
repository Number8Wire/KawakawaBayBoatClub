<?php
  require_once ("auth.php");
  require 'db.php';

  //Add Code here to $_POST['id'] and $_POST['value'] and update
  $news_title=$_GET['title'];
  $news_content=$_GET['content'];
  
  $link = @mysql_connect ($server, $username, $password)
  or die (mysql_error());
  
  if (!@mysql_select_db($database, $link)) {   // leave the database 
											 // name as anydb for now
											 
	   echo "<p>There has been an error. This is the error message:</p>";
	   echo "<p><strong>" . mysql_error() . "</strong></p>";
	   echo "Please Contant Your Systems Administrator with the details";
  } 
  
  $sql_query = "INSERT INTO news (news_date, news_title, news_content) VALUES (NOW(), \"".$news_title."\", \"".$news_content."\")";
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query, $sql_query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  mysql_close ($link);
  
  header( 'Location: http://www.kbbc.co.nz/editnews.php' ) ;

?>