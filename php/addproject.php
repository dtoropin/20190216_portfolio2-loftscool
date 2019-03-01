<?php
require_once 'config.php';
$result['ans'] = 'OK';
$result['error'] = [];

if(!filter_var('http://' . htmlspecialchars($_POST['url']), FILTER_VALIDATE_URL))
{
	$result['ans'] = 'NOK';
	array_push($result['error'], 'url');
	die(json_encode($result));
}

$result['name'] = htmlspecialchars($_POST['name']);

$result['url'] = htmlspecialchars($_POST['url']);

$result['subscription'] = htmlspecialchars($_POST['subscription']);

if(!empty($_FILES['file']['tmp_name']))
{
	$imageinfo = getimagesize($_FILES['file']['tmp_name']);
	if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
	{
		$result['ans'] = 'NOK';
		array_push($result['error'], 'file');
		die(json_encode($result));
	}
	$path = UPLOAD . $_FILES['file']['name'];
	if (copy($_FILES['file']['tmp_name'], $path)) $file_name = $_FILES['file']['name'];
	$result['file'] = $file_name;
}
else
{
	$result['ans'] = 'NOK';
	array_push($result['error'], 'file');
}

die(json_encode($result));