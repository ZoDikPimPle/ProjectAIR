<?php
include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $flight_number = $_POST['flight_number'];
    $departure_time = $_POST['departure_time'];

    if ($action === 'add') {
        $sql = "INSERT INTO temp_flights (flight_number, departure_time) VALUES (:flight_number, :departure_time)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['flight_number' => $flight_number, 'departure_time' => $departure_time]);
    }

    // Перенаправляем на страницу с временной таблицей
    header('Location: ../pages/temp_table.php');
}
?>
