<?php
include '../includes/config.php';
include '../includes/db_operations.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sort = $_POST['sort'];
    $flights = getFlights($pdo, $sort);

    // Перенаправляем на страницу с рейсами с примененным фильтром
    header('Location: ../pages/flights.php');
}
?>
