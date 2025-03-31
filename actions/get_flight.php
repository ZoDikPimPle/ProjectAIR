<?php
include '../includes/config.php';
include '../includes/db_operations.php';

if (isset($_GET['flight_number'])) {
    $flight_number = $_GET['flight_number'];
    $flight = getFlightByNumber($pdo, $flight_number);
    echo json_encode($flight);
}
?>
