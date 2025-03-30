<?php
include '../templates/header.php';
include '../includes/config.php';

// Создаем временную таблицу
$sql = "CREATE TEMPORARY TABLE temp_flights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flight_number VARCHAR(10),
    departure_time DATETIME
)";
$pdo->exec($sql);

// Добавляем данные во временную таблицу
$sql = "INSERT INTO temp_flights (flight_number, departure_time) VALUES ('FL001', '2023-10-01 08:00:00'), ('FL002', '2023-10-01 09:00:00')";
$pdo->exec($sql);

// Получаем данные из временной таблицы
$sql = "SELECT * FROM temp_flights";
$stmt = $pdo->query($sql);
$temp_flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Временная таблица</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Номер рейса</th>
        <th>Время вылета</th>
    </tr>
    <?php foreach ($temp_flights as $flight): ?>
        <tr>
            <td><?php echo $flight['id']; ?></td>
            <td><?php echo $flight['flight_number']; ?></td>
            <td><?php echo $flight['departure_time']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<form action="../actions/temp_table_actions.php" method="post">
    <input type="text" name="flight_number" placeholder="Номер рейса">
    <input type="datetime-local" name="departure_time">
    <button type="submit" name="action" value="add">Добавить</button>
</form>

<?php include '../templates/footer.php'; ?>
