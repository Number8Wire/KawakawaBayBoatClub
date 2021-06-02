<?php
$system = $_SERVER['SERVER_NAME'];
$testSystem1 = "www.number8wire.co.nz";
$testSystem2 = "number8wire.co.nz";
$testWampSystem = "kawakawabayboatclub";

$server = "localhost:3306"; // this is the server address and port

if ($system === $testSystem1 || $system === $testSystem2) {
	$username = "tim"; // change this to your mysql username
	$password = '2$yMv*n*$Ip1'; // change this to your mysql password
	$database = "tim_kbbc";
	$rootPath = "/KBBC";
	$to = "tim@number8wire.co.nz"; 
	$bcc = "";
	$siteKey = "6LfTEAkTAAAAAA-Osg6LHqE32SRha-ATX8vButxo";
	$secretKey = "6LfTEAkTAAAAAPzFOigSIJetaoAoH2x1VMMB7D84";
	}
else if ($system === $testWampSystem) {
	$username = "kbbcadmn_admn"; // change this to your mysql username
	$password = 'iToalKbosd4r'; // change this to your mysql password
	$database = "kbbcadmn_kbbc";
	$rootPath = "";
	$to = "tim@number8wire.co.nz"; 
	$bcc = ""; 
	$siteKey = "6Ld5LbwUAAAAAJWkzrQI3YOJhrXVNAYY1kfpzi37";
	$secretKey = "6Lf4LbwUAAAAADfU32bKCSFNZSY_4F18A1z1hYZm";
	}
else {
	$username = "kbbcadmn_admn"; // change this to your mysql username
	$password = 'iToalKbosd4r'; // change this to your mysql password
	$database = "kbbcadmn_kbbc";
	$rootPath = "";
	$to = "boatclub@kbbc.co.nz";
	$bcc = ""; 
	$siteKey = "6Ld5LbwUAAAAAJWkzrQI3YOJhrXVNAYY1kfpzi37";
	$secretKey = "6Ld5LbwUAAAAAMsiSOlR_e1T1WD06ai0iJJJdV24";
}
?>