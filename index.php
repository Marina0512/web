<?php
session_start();

include 'template.php';

echo "<h1>Об авторе</h1>";
echo "<p>Пономарева Марина</p>";

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    echo "<h2>Привет, " . htmlspecialchars($_SESSION['username']) . "!</h2>";
    echo "<p><a href='exit.php'>Выйти</a></p>";
} else {
    echo "<form action='post.php' method='post'>";
    echo "  <label for='username'>Ваше имя:</label>";
    echo "  <input type='text' id='username' name='username'>";
    echo "  <button type='submit'>Отправить</button>";
    echo "</form>";
}
?>