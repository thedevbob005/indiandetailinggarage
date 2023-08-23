<?php

$to_email = $_POST['to'];
$from_email = $_POST['email'];
$from_name = $_POST['name'];
$subject = "IDG Web Contact Form Submission";
$body = $_POST['message'];
$headers  = "From: {$from_name} <{$from_email}>\n";
$headers .= "X-Sender: {$from_name} <{$from_email}>\n";
$headers .= 'X-Mailer: PHP/' . phpversion();
$headers .= "X-Priority: 1\n"; // Urgent message!
$headers .= "Return-Path: {$to_email}\n"; // Return path for errors
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=iso-8859-1\n";

if ( mail($to_email, $subject, $body, $headers)) {
    http_response_code(200);
    echo("Email successfully sent to $to_email...");
} else {
    http_response_code(404);
    echo("Email sending failed...");
}

?>