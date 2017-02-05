<?php

// Sends emails from the corporate website to the recipient
function smtpmailer($to, $subject, $body, $attachment) { 
  include('config.php');
  require_once('phpmailer/PHPMailerAutoload.php');        
  $mail = new PHPMailer();  // create a new object
  $mail->IsSMTP(); // enable SMTP
  $mail->IsHTML(true);
  $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true;  // authentication enabled
  $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 465; 
  $mail->Username = $mail_user;  
  $mail->Password = $mail_password;           
  $mail->SetFrom($mail_user, $mail_from_name);
  $mail->Subject = $subject;
  $mail->Body = $body;
  $mail->AddAddress($to);
  if ($attachment != null) {
    $mail->AddAttachment($attachment);
  }
  $mail->send();
}

?>
