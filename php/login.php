<?php
require_once 'config.php';

if (isset($_GET['del'])) {
	session_start();
	unset($_SESSION['admin']);
	session_destroy();
	setcookie ('admin', '', time() - 3600, '/');
	header('Location: /');
	die();
}

$result['ans'] = 'OK';
$result['error'] = [];

require_once '../vendor/j4mie/idiorm/idiorm.php';
ORM::configure('sqlite:../database/portfolio.db');

$res = ORM::for_table('user')->find_one(1);
if (!$res) die(false);

$result['ans'] = 'OK';
if (isset($_POST['email'])
	&& filter_var(htmlspecialchars($_POST['email']), FILTER_VALIDATE_EMAIL)
	&& $res->name !== trim(htmlspecialchars($_POST['email']))) {
	$result['ans'] = 'NOK';
	array_push($result['error'], 'email');
}
if (isset($_POST['pass']) && $res->pass !== md5(trim(htmlspecialchars($_POST['pass'])))) {
	$result['ans'] = 'NOK';
	array_push($result['error'], 'pass');
}
if (isset($_POST['remember']) && $_POST['remember'] === 'ON') {
	// пишем 'adminTrue' в cookie на месяц :)
	setcookie ('admin', true, time() + (3600 * 24 * 30), '/');
}

if ($result['ans'] === 'NOK') die(json_encode($result));
session_start();
$_SESSION['admin'] = true;

die(json_encode($result));