<?php
include '../templates/header.php';
include '../includes/config.php';
include '../includes/db_operations.php';

if (isset($_GET['id'])) {
    $flight = getFlightById($pdo, $_GET['id']);
}
?>

<h1>Редактировать рейс</h1>
<form action="../actions/edit_flight_action.php" method="post">
    <input type="hidden" name="flight_number" value="<?php echo $flight['flight_number']; ?>">
    <input type="datetime-local" name="departure_time" value="<?php echo $flight['departure_time']; ?>" required>
    <input type="datetime-local" name="arrival_time" value="<?php echo $flight['arrival_time']; ?>" required>
    <select name="departure_airport" required>
        <option value="SVO" <?php if ($flight['departure_airport'] == 'SVO') echo 'selected'; ?>>Шереметьево</option>
        <option value="DME" <?php if ($flight['departure_airport'] == 'DME') echo 'selected'; ?>>Домодедово</option>
        <option value="LED" <?php if ($flight['departure_airport'] == 'LED') echo 'selected'; ?>>Пулково</option>
    </select>
    <select name="arrival_airport" required>
        <option value="SVO" <?php if ($flight['arrival_airport'] == 'SVO') echo 'selected'; ?>>Шереметьево</option>
        <option value="DME" <?php if ($flight['arrival_airport'] == 'DME') echo 'selected'; ?>>Домодедово</option>
        <option value="LED" <?php if ($flight['arrival_airport'] == 'LED') echo 'selected'; ?>>Пулково</option>
    </select>
    <select name="status" required>
        <option value="Scheduled" <?php if ($flight['status'] == 'Scheduled') echo 'selected'; ?>>Запланирован</option>
        <option value="Delayed" <?php if ($flight['status'] == 'Delayed') echo 'selected'; ?>>Задержан</option>
        <option value="Cancelled" <?php if ($flight['status'] == 'Cancelled') echo 'selected'; ?>>Отменен</option>
        <option value="Completed" <?php if ($flight['status'] == 'Completed') echo 'selected'; ?>>Завершен</option>
    </select>
    <select name="aircraft_type_code" required>
        <option value="AT001" <?php if ($flight['aircraft_type_code'] == 'AT001') echo 'selected'; ?>>Сухой Суперджет 100</option>
        <option value="AT002" <?php if ($flight['aircraft_type_code'] == 'AT002') echo 'selected'; ?>>Ил-96</option>
        <option value="AT003" <?php if ($flight['aircraft_type_code'] == 'AT003') echo 'selected'; ?>>Ту-204</option>
    </select>
    <button type="submit">Сохранить</button>
</form>

<a href="flights.php">Назад к списку рейсов</a>

<?php include '../templates/footer.php'; ?>
