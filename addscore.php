<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Гитарные войны. Список рейтингов</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2>Гитарные войны. Добавьте свой рейтинг</h2>

<?php
require_once('appvars.php');
require_once('connectvars.php');

if (isset($_POST['submit'])) {
    //Соединение с базой данных
    $dbc = mysqli_connect("localhost", "root", "", "guitar_score");

    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    $score = mysqli_real_escape_string($dbc, trim($_POST['score']));
    $screenshot = mysqli_real_escape_string($dbc, trim($_FILES['screenshot']['name']));
    $screenshot_type = $_FILES['screenshot']['type'];
    $screenshot_size = $_FILES['screenshot']['size'];

    if (!empty($name) && is_numeric($score) && !empty($screenshot)) {
        if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png'))        && ($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE)) {
            if ($_FILES['screenshot']['error'] == 0) {

                //Перемещение файла в постоянный каталог для файлов изображения
                $target = GW_UPLOADPATH . $screenshot;
                if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {

                //Запись в базу данных
                $query = "INSERT INTO guitarwars (date, name, score, screenshot) VALUES (NOW(), '$name', '$score', '$screenshot')";
                mysqli_query($dbc, $query);

                //Вывод пользователю подтверждение в получении данных
                echo '<p>Спасибо за то, что добавили свой рейтинг!</p>';
                echo '<p><strong>Имя:</strong>' . $name . '<br>';
                echo '<strong>Рейтинг:</strong>' . $score . '</p>';
                echo '<img src="' . GW_UPLOADPATH . $screenshot . '" alt="Изображение подтверждающее подлинность рейтинга"><br>';
                echo '<p><a href="index.php">&lt;&lt; Назад к записи рейтингов</a></p>';

                //очистка полей ввода дынных
                $name = "";
                $score = "";
                $screenshot = "";

                mysqli_close($dbc);
            }  else {
                    echo '<p class="error">Извините, возникла проблема с загрузкой вашего скриншота.</p>';
                }
            }
        }      else {        echo '<p class="error">Снимок экрана должен быть файлом изображения в формате GIF, JPEG или PNG размером не более ' . (GW_MAXFILESIZE / 1024) . ' Кб .</p>';      }

        // Попробуйте удалить временный файл изображения снимка экрана
        @unlink($_FILES['screenshot']['tmp_name']);
    }
    else {
        echo '<p class="error">Пожалуйста, введите всю информацию, чтобы добавить свой высокий балл.</p>';
    }
}
?>

<hr />
<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo GW_MAXFILESIZE; ?>" />
    <label for="name">Имя:</label>
    <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>" /><br />
    <label for="score">Рейтинг:</label>
    <input type="text" id="score" name="score" value="<?php if (!empty($score)) echo $score; ?>" /><br />
    <label for="screenshot">Фотография:</label>
    <input type="file" id="screenshot" name="screenshot" />
    <hr />
    <input type="submit" value="Добавить" name="submit" />
</form>
</body>
</html>