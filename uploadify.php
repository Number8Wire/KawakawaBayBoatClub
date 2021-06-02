<?php
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
if (!empty($_FILES)) {
//	$tempFile = $_FILES['Filedata']['tmp_name'];
//	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
//	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	echo ("Hello World!");
	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
	$server = "localhost:3306"; // this is the server address and port
	$username = "tim"; // change this to your mysql username
	$password = "numb3r8w1r3"; // change this to your mysql password
		
//		$username = "root"; // change this to your mysql username
//		$password = ""; // change this to your mysql password
		
	$link = @mysql_connect ($server, $username, $password)
	or die (mysql_error());
	
	if (!@mysql_select_db("tim_kbbc", $link)) {   // leave the database 
	                                           // name as anydb for now
	                                           
	     echo "<p>There has been an error. This is the error message:</p>";
	     echo "<p><strong>" . mysql_error() . "</strong></p>";
	     echo "Please Contant Your Systems Administrator with the details";
	     
	} 

	error_reporting(E_ALL);
	
	$change="";
	$abc="";
	
	define ("MAX_SIZE","1000");
	function getExtension($str) {
	         $i = strrpos($str,".");
	         if (!$i) { return ""; }
	         $l = strlen($str) - $i;
	         $ext = substr($str,$i+1,$l);
	         return $ext;
	}
	
	$errors=0;
	  
			 	$image =$_FILES["file"]["name"];
				$uploadedfile = $_FILES['file']['tmp_name'];
		 
			 	if ($image) 
		 		{
		  		$filename = stripslashes($_FILES['file']['name']);
		   		$extension = getExtension($filename);
		 			$extension = strtolower($extension);
				
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
		 			{
			 			$change='<div class="msgdiv">Unknown Image extension </div> ';
		 				$errors=1;
		 			}
		 			else
		 			{
						$size=filesize($_FILES['file']['tmp_name']);
						if ($size > MAX_SIZE*1024)
						{
							$change='<div class="msgdiv">You have exceeded the size limit!</div> ';
							$errors=1;
						}
		
						if($extension=="jpg" || $extension=="jpeg" )
						{
							$uploadedfile = $_FILES['file']['tmp_name'];
							$src = imagecreatefromjpeg($uploadedfile);
						}
						else if($extension=="png")
							{
							$uploadedfile = $_FILES['file']['tmp_name'];
							$src = imagecreatefrompng($uploadedfile);
							}
							else 
							{
							$src = imagecreatefromgif($uploadedfile);
							}
		
//						echo $src;
		
						list($width,$height)=getimagesize($uploadedfile);
		
						$newwidth=500;
						$newheight=($height/$width)*$newwidth;
						$tmp=imagecreatetruecolor($newwidth,$newheight);
		
						$newwidth1=100;
						$newheight1=($height/$width)*$newwidth1;
						$tmp1=imagecreatetruecolor($newwidth1,$newheight1);
		
						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
						imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
						
						$filenameonly = $_FILES['file']['name'];
						$filename = "images/gallery/". $_FILES['file']['name'];
						$filename1 = "images/gallery/small". $_FILES['file']['name'];
						
						imagejpeg($tmp,$filename,100);
						imagejpeg($tmp1,$filename1,100);
						
						imagedestroy($src);
						imagedestroy($tmp);
						imagedestroy($tmp1);
					}
				}
		
	echo ("errors = $errors");
	echo $change;

	//If no errors registered, print the success message
	if(isset($_POST['Submit']) && !$errors) 
	{
		// mysql_query("update {$prefix}users set img='$big',img_small='$small' where user_id='$user'");
 		$change=' <div class="msgdiv">Image Uploaded Successfully!</div>';

		$sql_query = "SELECT MAX(position) AS maxpos FROM gallery";
		$result = mysql_query($sql_query, $link);
		if (!$result) {
		  echo("<p>Error performing query: " . mysql_error() . "</p>");
		  exit();
		} 
		$row = mysql_fetch_array( $result );
		$max_position = $row['maxpos'] + 1;
		
		$sql_query = "INSERT INTO gallery (date_added, filename, position) VALUES (NOW(), '$filenameonly', '$max_position')";

		echo ($sql_query);
				
		$result = mysql_query($sql_query, $link);
		if (!$result) {
		  echo("<p>Error performing query: " . mysql_error() . "</p>");
		  exit();
		} 
 	}
 
	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
		
//		move_uploaded_file($tempFile,$targetFile);
//		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	// } else {
	// 	echo 'Invalid file type.';
	// }
}
?>