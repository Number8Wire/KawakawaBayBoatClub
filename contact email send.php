<?php
$myemail = 'boatclub@kbbc.co.nz';
//$myemail = 'tim@number8wire.co.nz';
if (isset($_POST['name'])) {
$name = strip_tags($_POST['name']);
$email = strip_tags($_POST['email']);
$message = strip_tags($_POST['message']);
echo "<div class=\"alert alert-success\" >Your message has been received. Thank you! We will be in touch with you shortly</div>";

$to = $myemail;
$email_subject = "KBBC website contact form submission from $name";
$email_body = "You have received a new message from the Kawakawa Bay Boat Club website. ".
" The details are listed below:\n\n Name: $name \n\n ".
"Email: $email\n\n Message: \n\n $message\n\n".
"The Kawakawa Bay Boat Club Website.";
$headers = "From: $myemail\n";
$headers .= "Reply-To: $email";
mail($to,$email_subject,$email_body,$headers);
}?>