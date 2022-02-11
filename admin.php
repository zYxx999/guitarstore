<?php
require_once('authorize.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Гитарные войны - Подтвердите высокий балл</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<h2>Гитарные войны - Подтвердите высокий балл</h2>

<?php
require_once('connectvars.php');
require_once('appvars.php');

// соединение с базой данных
$dbc = mysqli_connect("localhost", "root", "", "guitar_score");

// извлечение данных из базы данных
$query = "SELECT * FROM guitarwars ORDER BY score DESC, date ASC";
$data = mysqli_query($dbc, $query);

// извлечение данных из массива рейтингов в цикле
// форматирование данных записей в виде кода HTML
echo '<table>';
while ($row = mysqli_fetch_array($data)) {
    // вывод данных рейтинга
    echo '<tr class="scorerow"><td><strong>' . $row['name'] . '</strong></td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>' . $row['score'] . '</td>';
    echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;date=' . $row['date'] .
        '&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] .
        '&amp;screenshot=' . $row['screenshot'] . '">Удалить</a>';
    if ($row['approved'] == '0') {
        echo ' / <a href="approvescore.php?id=' . $row['id'] . '&amp;date=' . $row['date'] .
            '&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' .
            $row['screenshot'] . '">Подтвердить</a><br>';
    }
    echo '</table>';
}

mysqli_close($dbc);
?>
</body>
</html>