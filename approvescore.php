<?php
require_once ('authorize.php');
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
require_once('appvars.php');
require_once('connectvars.php');

if (isset($_GET['id']) && isset($_GET['date']) && isset($_GET['name']) && isset($_GET['score'])){
    // извлечение данных рейтинга из суперглобального массива $_GET \
    $id = $_GET['id'];
    $date = $_GET['date'];
    $name = $_GET['name'];
    $score = $_GET['score'];
    $screenshot = $_GET['screenshot'];
}
else if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['score'])) {
    // извлечение данных рейтинга из суперглобального массива $_POST
    $id = $_POST['id'];
    $name = $_POST['name'];
    $score = $_POST['score'];
}
else{
    echo '<p class="error">Извините, ни одного рейтинга не выбрано для удаления</p>';
}

if (isset($_POST['submit'])) {
    if ($_POST['confirm'] == 'Yes') {
        // Подключение к базе данных
        $dbc = mysqli_connect("localhost", "root", "", "guitar_score");

        // Подтвердите оценку, установив столбец "Утверждено" в базе данных
        $query = "UPDATE guitarwars SET approved = 1 WHERE id = $id";
        mysqli_query($dbc, $query);
        mysqli_close($dbc);

        // Подтвердите успех с пользователем
        echo '<p>Высокий балл ' . $score . ' за ' . $name . ' был успешно одобрен.';
    }
    else {
        echo '<p class="error">Извините, возникла проблема с утверждением высокого балла.</p>';
    }
}
else if (isset($id) && isset($name) && isset($date) && isset($score)) {
    echo '<p>Вы уверены, что хотите удалить этот рейтинг</p>';
    echo '<p><strong>Имя: </strong>' . $name . '<br> <strong>Дата: </strong>' . $date . '<br> <strong>Рейтинг: </strong>' . $score . '</p>';
    echo '<from method="post" action="removescore.php">';
    echo '<input type="radio" name="confirm" value="Да"> Да';
    echo '<input type="radio" name="confirm" value="Нет" checked="checked"> Нет <br>';
    echo '<input type="submit"  value="Удалить" name="submit">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="score" value="' .$score . '">';
    echo '</form>';
}

echo '<p><a href="admin.php">&lt;&lt; Назад к списку рейтингов </p>'
?>

</body>
</html>