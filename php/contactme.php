<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';

session_start();
$result['ans'] = 'OK';
$result['error'] = [];

if ($_SESSION['imgcaptcha_'] != md5(htmlspecialchars($_POST['captcha'])))
{
	$result['ans'] = 'NOK';
	array_push($result['error'], 'captcha');
}

if(!filter_var(htmlspecialchars($_POST['email']), FILTER_VALIDATE_EMAIL))
{
	$result['ans'] = 'NOK';
	array_push($result['error'], 'email');
}

if ($result['ans'] === 'NOK') die(json_encode($result));

// Отправка письма phpMailer
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'mailer/');
try {
	//Recipients
	$mail->setFrom(htmlspecialchars($_POST['email']));
	$mail->addAddress('free73@list.ru');
	$mail->addReplyTo(htmlspecialchars($_POST['email']));

	//Content
	$mail->isHTML(true);
	$mail->Subject = 'У меня интересный проект!';
	$mail->Body    = '<p><b>Интересный проект от </b>' . htmlspecialchars($_POST['name']) . '</p><p>' . htmlspecialchars($_POST['message']) . '</p>';
	$mail->AltBody = 'Name: ' . htmlspecialchars($_POST['name']) . '|| Text: ' . htmlspecialchars($_POST['message']);

	$mail->send();
} catch (Exception $e) {
	$result['ans'] = 'NOK';
	$result['mail'] = $mail->ErrorInfo;
}

die(json_encode($result));