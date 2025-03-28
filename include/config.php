<?php
$host = 'localhost';  // Адрес сервера (обычно localhost)
$dbname = 'ProjectAir'; // Название БД
$username = 'root'; // Имя пользователя MySQL
$password = ''; // Пустой

// Подключение к БД
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>
