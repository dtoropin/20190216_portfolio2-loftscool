<?php

require_once 'vendor/autoload.php';
session_start();
if(!isset($_SESSION['admin'])) $_SESSION['admin'] = $_COOKIE['admin'] ? true : false;

$route = new \Klein\Klein();
$templater = Templater::getInstance();
$config = include_once 'config/config.php';

$route->respond('GET', '/', function () use ($templater, $config) {
	$data = [];
	$data['admin'] = $_SESSION['admin'];
	$data['config'] = $config;
	$data['page'] = 'index';
	$data['title'] = 'Главная страница | Обо мне';
	return $templater->display('pages/index', $data);
});

$route->respond('GET', '/portfolio/?', function () use ($templater, $config) {
	ORM::configure('sqlite:./database/portfolio.db');
	$data = [];
	$data['admin'] = $_SESSION['admin'];
	$data['works'] = ORM::for_table('project')->find_many();
	$data['config'] = $config;
	$data['page'] = 'portfolio';
	$data['title'] = 'Страница моих работ';
	return $templater->display('pages/portfolio', $data);
});

$route->respond('GET', '/contactme/?', function () use ($templater, $config) {
	$data = [];
	$data['admin'] = $_SESSION['admin'];
	$data['config'] = $config;
	$data['page'] = 'contactme';
	$data['title'] = 'Страница обратной связи';
	return $templater->display('pages/contactme', $data);
});

$route->respond('GET', '/login/?', function () use ($templater, $config) {
	$data = [];
	$data['config'] = $config;
	$data['page'] = 'login';
	$data['title'] = 'Авторизация';
	return $templater->display('pages/login', $data);
});

$route->dispatch();
