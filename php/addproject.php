<?php
$result['ans'] = 'OK';
$upload = $_SERVER['DOCUMENT_ROOT'] . '/img/projects/';

$result['name'] = htmlspecialchars($_POST['name']);

$result['url'] = htmlspecialchars($_POST['url']);

$result['subscription'] = htmlspecialchars($_POST['subscription']);

if(!empty($_FILES['file']['tmp_name'])) {
	$path = $upload . $_FILES['file']['name'];
	if (copy($_FILES['file']['tmp_name'], $path))
		$file_name = $_FILES['file']['name'];
		$result['file'] = $file_name;
} else {
	$result['ans'] = 'NOK';
}

die(json_encode($result));