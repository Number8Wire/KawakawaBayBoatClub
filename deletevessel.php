<?php /* Created on: 3/11/2011 */ ?>
<?php
require 'db.php';

$vid=$_GET['unique_id'];
$uid=$_GET['member_unique_id'];
$mid=$_GET['member_id'];

$link = @mysql_connect ($server, $username, $password)
or die (mysql_error());

if (!@mysql_select_db($database, $link)) {   // leave the database 
                                           // name as anydb for now
                                           
     echo "<p>There has been an error. This is the error message:</p>";
     echo "<p><strong>" . mysql_error() . "</strong></p>";
     echo "Please Contant Your Systems Administrator with the details";
} 

// delete the vessel from the vessel table
$sql_query = "DELETE FROM vessels WHERE unique_id=".$vid;

$result = mysql_query($sql_query, $link);
if (!$result) {
  echo("<p>Error performing query: " . mysql_error() . "</p>");
	mysql_close ($link);
  exit();
} 

mysql_close ($link);

//header( "Location: http://www.number8wire.co.nz/Kawakawa Bay Boat Club/editvessel.php?unique_id=$uid" ) ;
header( "Location: http://www.kbbc.co.nz/editmembers.php?search_text=$mid&search_column=member_id&search_criteria=REGEXP#" ) ;

?>