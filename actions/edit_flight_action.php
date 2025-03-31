<?php
include '../includes/config.php';
include '../includes/db_operations.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flight_number = $_POST['flight_number'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $departure_airport = $_POST['departure_airport'];
    $arrival_airport = $_POST['arrival_airport'];
    $status = $_POST['status'];
    $aircraft_type_code = $_POST['aircraft_type_code'];

    editFlight($pdo, $flight_number, $departure_time, $arrival_time, $departure_airport, $arrival_airport, $status, $aircraft_type_code);

    echo "success";
}
?>
