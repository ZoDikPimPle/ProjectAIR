<?php
include '../includes/config.php';
include '../includes/db_operations.php';

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    changeAllFlightsStatus($pdo, $status);
    echo "success";
}
?>
