<?php
echo "hi";
//if(!isset($_POST['submit']))
//{
	//This page should not be accessed directly. Need to submit the form.
//	echo "error; you need to submit the form!";
//}
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$model = $_POST['model'];
$color = $_POST['color'];
$visitor_email = $_POST['email'];
$message = $_POST['issue'];
$phoneNum = $_POST['phone'];
//echo $phoneNum;
//Validate first
if(empty($firstName)||empty($lastName)||empty($model)||empty($color)||empty($visitor_email)||empty($message))
{
    echo "\n Error: This page can only be accessed through submission of the online repair request form. \n
		       *Either you have tried to access it manually, or you have not filled out all the required fields and somehow bypassed the form validation. \n      *Try again from www.oxfordscreenrepair.org/#repair";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = $visitor_email;
$email_subject = "$color iPhone $model repair for $firstName $lastName";
$email_body = "New repair request from $firstName $lastName.\n*
Device is: $color iPhone $model.\n
The users issue/message is:\n $message \n\nPhone Number: $phoneNum \n".

$to = "grantman100@gmail.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: ../#repair');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>
