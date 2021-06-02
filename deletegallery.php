<?php
  require_once ("auth.php");
  require 'db.php';

  $uid=$_GET['unique_id']; // unique id of the image

  $link = @mysql_connect ($server, $username, $password)
  or die (mysql_error());
  
  if (!@mysql_select_db($database, $link)) {   // leave the database 
											 // name as anydb for now
											 
	   echo "<p>There has been an error. This is the error message:</p>";
	   echo "<p><strong>" . mysql_error() . "</strong></p>";
	   echo "Please Contant Your Systems Administrator with the details";
  } 
  
  // get the image filename so we can delete the files
  $sql_query = "SELECT filename FROM gallery WHERE unique_id=\"".$uid."\"";
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	  $filename = $row['filename'];
	  }
	  
  $sql_query = "DELETE FROM gallery WHERE unique_id=\"".$uid."\"";
  
  $result = mysql_query($sql_query, $link);
  if (!$result) {
	echo("<p>Error performing query: " . mysql_error() . "</p>");
	  mysql_close ($link);
	exit();
  } 
  
  mysql_close ($link);
  
  // remove the images from the images/gallery and images/gallery/thumbs directories
  $big_image = "images/gallery/".$filename;
  $small_image = "images/gallery/thumbs/".$filename;
  unlink($big_image);
  unlink($small_image);
  
  header( 'Location: http://www.kbbc.co.nz/editgallery.php' ) ;

?>