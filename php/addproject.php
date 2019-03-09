<?php
require_once 'config.php';
require_once '../vendor/j4mie/idiorm/idiorm.php';
$result['ans'] = 'OK';
$result['error'] = [];

if (!filter_var('http://' . htmlspecialchars($_POST['url']), FILTER_VALIDATE_URL)) {
	$result['ans'] = 'NOK';
	array_push($result['error'], 'url');
	die(json_encode($result));
}

if (!empty($_FILES['file']['tmp_name'])) {
	$imageinfo = getimagesize($_FILES['file']['tmp_name']);
	if ($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
		$result['ans'] = 'NOK';
		array_push($result['error'], 'file');
		die(json_encode($result));
	}
	$path = UPLOAD . $_FILES['file']['name'];
	if (copy($_FILES['file']['tmp_name'], $path)) {
		$file_name = $_FILES['file']['name'];
		// Обработка данных
		ORM::configure('sqlite:../database/portfolio.db');
		$res = ORM::for_table('project')->create();

		$res->title = htmlspecialchars($_POST['name']);
		$res->img = $file_name;
		$res->link = htmlspecialchars($_POST['url']);
		$res->description = htmlspecialchars($_POST['subscription']);
		$res->save();
	}
} else {
	$result['ans'] = 'NOK';
	array_push($result['error'], 'file');
}

die(json_encode($result));