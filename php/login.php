<?php
require_once 'config.php';

session_start();

if (isset($_GET['del']))
{
	unset($_SESSION['auth']);
	session_destroy();
	header('Location: /');
}

$result['ans'] = 'OK';
$result['error'] = [];

require_once '../vendor/j4mie/idiorm/idiorm.php';
ORM::configure('sqlite:../database/portfolio.db');

$res = ORM::for_table('user')->find_one(1);
if(!$res) die(false);

$result['ans'] = 'OK';
if (isset($_POST['email'])
	&& filter_var(htmlspecialchars($_POST['email']), FILTER_VALIDATE_EMAIL)
	&& $res->user_name !== trim(htmlspecialchars($_POST['email'])))
{
	$result['ans'] = 'NOK';
	array_push($result['error'], 'email');
}
if (isset($_POST['pass']) && $res->user_pass !== strtoupper(md5(trim(htmlspecialchars($_POST['pass'])))))
{
	$result['ans'] = 'NOK';
	array_push($result['error'], 'pass');
}
if (isset($_POST['remember']) && $_POST['remember'] === 'ON')
{
	// пишем 'adminTrue' в coocie на месяц :)
}

if($result['ans'] === 'NOK') die(json_encode($result));

$_SESSION['auth'] = 'admin';
die(json_encode($answer));