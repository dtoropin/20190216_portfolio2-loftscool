<?php

require_once 'vendor/autoload.php';

$route = new \Klein\Klein();
$templater = Templater::getInstance();
$config = include_once 'config/config.php';

$route->respond('GET', '/', function () use ($templater, $config) {
	$data = array();
	$data['config'] = $config;
	$data['style'] = 'index';
	$data['title'] = 'Главная страница | Обо мне';
	return $templater->display('pages/index', $data);
});

$route->respond('GET', '/portfolio/?', function () use ($templater, $config) {
	$data = array();
	$data['config'] = $config;
	$data['style'] = 'portfolio';
	$data['title'] = 'Страница моих работ';
	return $templater->display('pages/portfolio', $data);
});

$route->respond('GET', '/contacts/?', function () use ($templater, $config) {
	return 'Страница обратной связи!';
});

$route->respond('GET', '/login/?', function () use ($templater, $config) {
	return 'Страница авторизации!';
});

$route->dispatch();

// video 24:41