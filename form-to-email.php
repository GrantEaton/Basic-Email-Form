<?php


//get all variables values on the page based on their html id.
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$model = $_POST['model'];
$color = $_POST['color'];
$visitor_email = $_POST['email'];
$message = $_POST['issue'];
$phoneNum = $_POST['phone'];

/*
Make sure none of the required variables are empty
Note that you must do a front-end validation before this line, otherwise
this will fail if the user leaves one of the fields blank
*/

if(empty($firstName)||empty($lastName)||empty($model)||empty($color)||empty($visitor_email)||empty($message))
{
    //technically, this should neber happen, but if it does, lets echo an error
    echo "\n Error: This page can only be accessed through submission of the online repair request form. \n
		       *Either you have tried to access it manually, or you have not filled out all the required fields and somehow bypassed the form validation. \n      *Try again from www.oxfordscreenrepair.org/#repair";
    exit;
}

//dont do anything if the email was injected.
if(IsInjected($visitor_email)||IsInjected($firstName)||IsInjected($lastName)||
IsInjected($model)||IsInjected($color)||IsInjected($message))
{
    //we dont want to give a potential hacker any info about what went wrong
    echo "Failure to submit form.";
    exit;
}

//create some new variables for the email
$email_from = $visitor_email;
$email_subject = "$color iPhone $model repair for $firstName $lastName";
$email_body = "New repair request from $firstName $lastName.\n*
Device is: $color iPhone $model.\n
The users issue/message is:\n $message \n\nPhone Number: $phoneNum \n".

$to = "myemail@gmail.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page (except i dont have one, so i just refresh the page...)
header('Location: ../#repair');


// Function to validate against any basic email injection attempts
//Injection testing is always important. We can look for basic PHP injections using this function
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
