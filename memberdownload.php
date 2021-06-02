<?php
	require_once ("auth.php");
	require 'db.php';
?>
<?php

$sql_query = "SELECT ";
$sql_query .= "members.member_id, members.salutation, members.first_name, members.middle_name, members.last_name, members.address1, members.address2, members.address3, members.phone1, members.phone2, members.phone3, members.email, members.status, members.date_paid, members.renewal_or_new, ";
$sql_query .= "vessels.name, vessels.type, vessels.colour, vessels.length, vessels.beam, vessels.trailer_reg, vessels.radio_callsign, vessels.motor_type, vessels.motor_hp ";
$sql_query .= "FROM members ";
$sql_query .= "LEFT JOIN vessels ON members.member_id = vessels.member_id ";

if (!empty($_GET)) {
	$query = $_GET['query']; // the database query search on
	// extract the WHERE clause
	$startPos = strpos($query, 'WHERE');
	$endPos = strpos($query, 'ORDER BY');
	$length = $endPos - $startPos;
	$whereClause = substr($query, $startPos, $length);
	$sql_query .= $whereClause;
}
else { // use the default query to get all the data
	$sql_query .= "WHERE members.membership_status != \"Deleted\" ";
}
$sql_query .= "ORDER BY members.member_id+0";
		
function query_to_csv($db_conn, $query, $filename, $attachment = false, $headers = true) {
  
	if($attachment) {
		// send response headers to the browser
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$filename);
		$fp = fopen('php://output', 'w');
	} else {
		$fp = fopen($filename, 'w');
	}
 
	$result = mysql_query($query, $db_conn) or die( mysql_error( $db_conn ) );
 
	if($headers) {
		// output header row (if at least one row exists)
		$row = mysql_fetch_assoc($result);
		if($row) {
			fputcsv($fp, array_keys($row));
			// reset pointer back to beginning
			mysql_data_seek($result, 0);
		}
	}
 
	$notFinished = true;
	$nextRow = mysql_fetch_row($result);
	while($notFinished) {
		$currentRow = $nextRow;
		$nextRow = mysql_fetch_row($result);
		if (empty($nextRow)) {
			$notFinished = false;
		}
		while (!empty($nextRow) && ($nextRow[0] == $currentRow[0])) {
			// we have multiple vessels for a single member
			$nextVessel = array_slice($nextRow, 15);
			$currentRow = array_merge($currentRow, $nextVessel);
			$nextRow = mysql_fetch_row($result);
		}
		fputcsv($fp, $currentRow);
	}
 
	fclose($fp);
}

$link = @mysql_connect ($server, $username, $password)
or die (mysql_error());

if (!@mysql_select_db($database, $link)) {   // leave the database 
                                           // name as anydb for now
                                           
     echo "<p>There has been an error. This is the error message:</p>";
     echo "<p><strong>" . mysql_error() . "</strong></p>";
     echo "Please Contant Your Systems Administrator with the details";
} 

// output as an attachment
query_to_csv($link, $sql_query, "KBBCDatabaseDownload.csv", true);

// output to file system
//query_to_csv($link, $sql_query, "KBBCMailMerge.csv", false);$server = "localhost:3306"; // this is the server address and port

mysql_close ($link);

?>