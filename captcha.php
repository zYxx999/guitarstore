<?php
session_start();

// Определение нескольких важных констант CAPTCHA
define('CAPTCHA_NUMCHARS', 6);  // количество символов в идентификационной фразе
define('CAPTCHA_WIDTH', 100);   // ширина изображения
define('CAPTCHA_HEIGHT', 25);   // высота изображения

// Создание идентификационной фразы случайным образом
$pass_phrase = "";
for ($i = 0; $i < CAPTCHA_NUMCHARS; $i++) {    $pass_phrase .= chr(rand(97, 122));  }

// Сохранение идентификационной фразы в переменной сессии в зашифрованном виде
$_SESSION['pass_phrase'] = SHA1($pass_phrase);

// Создание изображения
$img = imagecreatetruecolor(CAPTCHA_WIDTH, CAPTCHA_HEIGHT);

// Установка цветов: белого для фона, черного для текста и серого для графических элементов

$bg_color = imagecolorallocate($img, 255, 255, 255); // белый цвет
$text_color = imagecolorallocate($img, 255, 255, 255); // белый цвет
$graphic_color = imagecolorallocate($img, 64, 64, 64); // серый цвет

// Заполнение фона
imagefilledrectangle($img, 0, 0, CAPTCHA_WIDTH, CAPTCHA_HEIGHT, $bg_color);

// рисование линий, расположенных случайным образом
for ($i = 0; $i < 5; $i++) {
    imageline($img, 0, rand() % CAPTCHA_HEIGHT, CAPTCHA_WIDTH, rand() % CAPTCHA_HEIGHT, $graphic_color);
}

// Рисование точек, расположенных случайным образом
for ($i = 0; $i < 50; $i++) {
    imagesetpixel($img, rand() % CAPTCHA_WIDTH, rand() % CAPTCHA_HEIGHT, $graphic_color);
}

// Написанные строки, содержащей идентификационную фразу
imagettftext($img, 18, 0, 5, CAPTCHA_HEIGHT - 5, $text_color, 'Courier New Bold.ttf', $pass_phrase);

// Вывод изображения в формате PNG с помощью HTTP-заголовка
header("Content-type: image/png");  imagepng($img);

// Удаление изображения
imagedestroy($img);
