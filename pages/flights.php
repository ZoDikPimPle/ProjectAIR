<?php
include '../templates/header.php';
include '../includes/config.php';
include '../includes/db_operations.php';

// Получаем данные о рейсах
$flights = getFlights($pdo);
?>

<h1>Информация о рейсах</h1>
<form action="../actions/filter_flights.php" method="post">
    <label for="sort">Сортировать по:</label>
    <select name="sort" id="sort">
        <option value="asc">Возрастанию</option>
        <option value="desc">Убыванию</option>
    </select>
    <button type="submit">Применить</button>
</form>

<table>
    <tr>
        <th>Номер рейса</th>
        <th>Время вылета</th>
        <th>Время прибытия</th>
        <th>Аэропорт вылета</th>
        <th>Аэропорт прибытия</th>
        <th>Статус</th>
    </tr>
    <?php foreach ($flights as $flight): ?>
        <tr>
            <td><?php echo $flight['flight_number']; ?></td>
            <td><?php echo $flight['departure_time']; ?></td>
            <td><?php echo $flight['arrival_time']; ?></td>
            <td><?php echo $flight['departure_airport']; ?></td>
            <td><?php echo $flight['arrival_airport']; ?></td>
            <td><?php echo $flight['status']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include '../templates/footer.php'; ?>
