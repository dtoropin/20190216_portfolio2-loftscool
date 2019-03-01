<?php
require_once 'config.php';
// Инициализируем генератор случайных чисел.
mt_srand(time());

// Определим путь к папке со шрифтами
$fonts = array('LetterGothicStd.ttf');

// Основные параметры капчи.
$par = array(
	// ширина капчи
	'WIDTH' => 190,
	// высота капчи
	'HEIGHT' => 78,
	// размер шрифта на капче
	'FONT_SIZE' => 26,

	// кол-во символов на капче
	'CHARS_COUNT' => 5,
	// разрешенные символы капчи
	'ALLOWED_CHARS' => 'abcdefghjkmnpqrstuvwxyz234589',

	// фоновый цвет капчи - белый в нашем случае
	'BG_COLOR' => '#fbfcfd',
	// кол-во линий на капче
	'LINES_COUNT' => 10,
	// толщина линий
	'LINES_THICKNESS' => 1
);

// // Общие парметры капчи

// цвета символов
define('CODE_CHAR_COLORS', '#727070');
// цвета линий
define('CODE_LINE_COLORS', '#9c9c9c');

// получаем цвета линий и символов в массивы для случайной выборки позднее
$line_colors = preg_split('/,\s*?/', CODE_LINE_COLORS);
$char_colors = preg_split('/,\s*?/', CODE_CHAR_COLORS);

// создаем пустой рисунок и заполняем его фоном
$img = imagecreatetruecolor($par['WIDTH'], $par['HEIGHT']);
imagefilledrectangle($img, 0, 0, $par['WIDTH'] - 1, $par['HEIGHT'] - 1, gd_color($par['BG_COLOR']));

// устанавливаем толщину линий и выводим их на капчу
imagesetthickness($img, $par['LINES_THICKNESS']);

for ($i = 0; $i < $par['LINES_COUNT']; $i++)
	imageline($img,
		mt_rand(0, $par['WIDTH'] - 1),
		mt_rand(0, $par['HEIGHT'] - 1),
		mt_rand(0, $par['WIDTH'] - 1),
		mt_rand(0, $par['HEIGHT'] - 1),
		gd_color($line_colors[mt_rand(0, count($line_colors) - 1)])
	);

// Переменная для хранения кода капчи
$code = '';

// Зададим координату по центру оси Y
$y = ($par['HEIGHT'] / 2) + ($par['FONT_SIZE'] / 2);

// Выводим символы на капче
for ($i = 0; $i < $par['CHARS_COUNT']; $i++) {
	// выбираем случайный цвет из доступного набора
	$color = gd_color($char_colors[mt_rand(0, count($char_colors) - 1)]);
	// определяем случайный угол наклона символа от -30 до 30 градусов
	$angle = mt_rand(-30, 30);
	// выбираем случайный символ из доступного набора
	$char = substr($par['ALLOWED_CHARS'], mt_rand(0, strlen($par['ALLOWED_CHARS']) - 1), 1);
	// выбираем случайный шрифт из доступного набора
	$font = PATH_TTF . $fonts[mt_rand(0, count($fonts) - 1)];
	// вычислим координату текущего символа по оси X
	$x = (intval(($par['WIDTH'] / $par['CHARS_COUNT']) * $i) + ($par['FONT_SIZE'] / 2));

	// выводим символ на капчу
	imagettftext($img, $par['FONT_SIZE'], $angle, $x, $y, $color, $font, $char);

	// сохраняем код капчи
	$code .= $char;
}

// Посылаем сформированный рисунок в браузер и избавляемся от него
header("Content-Type: image/png");
// сохраним капчу в сессии
session_start();
$_SESSION['imgcaptcha_'] = md5($code);


imagepng($img);
imagedestroy($img);

// Преобразуем HTML 6-символьный цвет в GD цвет
function gd_color($html_color)
{
	return preg_match('/^#?([\dA-F]{6})$/i', $html_color, $rgb)
		? hexdec($rgb[1]) : false;
}