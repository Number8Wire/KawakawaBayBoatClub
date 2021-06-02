<?php
	require_once ("auth.php");
	require 'db.php';
?>
<?php

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
 
	while($row = mysql_fetch_assoc($result)) {
		fputcsv($fp, $row);
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

$currentFinancialYear = date("Y");
$today = time();

$fiscalYearEnd = '9-30';
$fiscalYearEndDate = $currentFinancialYear."-".$fiscalYearEnd;
//echo "fiscalYearEndDate = ".$fiscalYearEndDate."\n";

$dateArr = explode("-",$fiscalYearEndDate);
$fiscalDateInt = mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]) ;
//echo "today - ".$today."\nfiscalDateInt = ".$fiscalDateInt."\n";
if($today > $fiscalDateInt){
	$currentFinancialYear++;
}
//echo $currentFinancialYear;

$sql_query = "SELECT member_id, salutation, first_name, last_name, address1, address2, address3, status, email, phone1, phone2, phone3 FROM members WHERE membership_status != \"Deleted\" AND status = ".$currentFinancialYear;

// output as an attachment
query_to_csv($link, $sql_query, "KBBCMailMergeFinancial.csv", true);

// output to file system
//query_to_csv($link, $sql_query, "KBBCMailMerge.csv", false);$server = "localhost:3306"; // this is the server address and port

mysql_close ($link);

?>