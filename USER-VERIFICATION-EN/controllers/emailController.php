<?php

require_once 'vendor/autoload.php';
require_once 'config/constants.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.abv.bg', 465, 'SSL'))
  ->setUsername(EMAIL)
  ->setPassword(PASSWORD);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

 function sendVerficationEmail($userEmail, $token)
 {
     global $mailer;
     $body = '<!DOCTYPE html>
     <html lang="en">
     <head>
         <meta charset="UTF-8">
     </head>
     <body>
         <p>
             Thank you for signing up on our website. Please click on the link bellow
             to verify your email.
         </p>
         <a href="http://localhost/projects/USER-VERIFICATION/index.php?token='. $token .'">
         Verify your email address
         </a>
     </body>
     </html>';
// Create a message
$message = (new Swift_Message('Verify your email address'))
  ->setFrom(EMAIL)
  ->setTo($userEmail)
  ->setBody($body, 'text/html');

// Send the message
$result = $mailer->send($message);
 }

 function sendPasswordResetLink($userEmail,$token)
 {
    global $mailer;
     $body = '<!DOCTYPE html>
     <html lang="en">
     <head>
         <meta charset="UTF-8">
     </head>
     <body>
         <p>
             Please click on the link below to reset your password.
         </p>
         <a href="http://localhost/projects/USER-VERIFICATION/index.php?password-token='. $token .'">
         Reset your password
         </a>
     </body>
     </html>';
// Create a message
$message = (new Swift_Message('Reset your password'))
  ->setFrom(EMAIL)
  ->setTo($userEmail)
  ->setBody($body, 'text/html');

// Send the message
$result = $mailer->send($message);
 }