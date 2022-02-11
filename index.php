<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Гитарные войны. Список рейтингов</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2>Гитарные войны. Список рейтингов</h2>
<p>Добро пожаловать, гитарный воин! Твой рейтинг бьет рекорд, зарегистрированный <br> в этом списке рейтингов? Если так, просто
    <a href="addscore.php">Добавь свой рейтинг в список.</a>
</p>
<hr>
<?php
require_once('appvars.php');
require_once('connectvars.php');

// Соединение с базой данных
$dbc = mysqli_connect("localhost", "root", "", "guitar_score");

// Извлечение данных рейтингов из базы MySQL
$query = "SELECT * FROM guitarwars WHERE approved = 1 ORDER BY score DESC, date ASC";
$data = mysqli_query($dbc, $query);


// Извлечение данных из массива рейтингов в цикле
// Форматирование данных записей в виде кода HTML
$i = 0;
echo '<table>';
while ($row = mysqli_fetch_array($data)){
    // Вывод данных рейтинга
    if($i == 0){
        echo '<tr><td colspan="2" class="topscoreheader"> Наивысший рейтинг:' . $row['score'] . '</td></tr>';
    }
    echo '<tr><td class="scoreinfo">';
    echo '<span class="score">' . $row['score'] . '</span><br>';
    echo '<strong>Имя:</strong>' . $row['name'] . '<br>';
    echo '<strong>Дата:</strong>' . $row['date'] . '</td></tr>';
    if (is_file(GW_UPLOADPATH . $row['screenshot']) && filesize(GW_UPLOADPATH . $row['screenshot']) > 0){
        echo '<td><img src="' . $row['screenshot'] . ' " alt="подтверждено"></td></tr>';
    }
    else{
        echo '<td><img src="' . GW_UPLOADPATH . 'unverified.gif' . '"alt="Не подтверждено!"></td></tr>';
    }
    $i++;
}
echo '</table>';

mysqli_close($dbc);
?>
</body>
</html>
