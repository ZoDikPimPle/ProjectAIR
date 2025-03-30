<?php
include '../templates/header.php';
include '../includes/config.php';
include '../includes/db_operations.php';


// Получаем данные о рейсах
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc';
$flights = getFlights($pdo, $sort);
?>

<h1>Информация о рейсах</h1>
<form action="flights.php" method="get">
    <label for="sort">Сортировать по:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="asc" <?php if ($sort == 'asc') echo 'selected'; ?>>Возрастанию</option>
        <option value="desc" <?php if ($sort == 'desc') echo 'selected'; ?>>Убыванию</option>
    </select>
</form>

<table>
    <tr>
        <th>Номер рейса</th>
        <th>Время вылета</th>
        <th>Время прибытия</th>
        <th>Аэропорт вылета</th>
        <th>Аэропорт прибытия</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($flights as $flight): ?>
        <tr>
            <td><?php echo $flight['flight_number']; ?></td>
            <td><?php echo $flight['departure_time']; ?></td>
            <td><?php echo $flight['arrival_time']; ?></td>
            <td><?php echo $flight['departure_airport']; ?></td>
            <td><?php echo $flight['arrival_airport']; ?></td>
            <td><?php echo $flight['status']; ?></td>
            <td>
                <a href="edit_flight.php?id=<?php echo $flight['flight_number']; ?>">Редактировать</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Добавить новый рейс</h2>
<form action="../actions/add_flight.php" method="post">
    <input type="text" name="flight_number" placeholder="Номер рейса" required>
    <input type="datetime-local" name="departure_time" placeholder="Время вылета" required>
    <input type="datetime-local" name="arrival_time" placeholder="Время прибытия" required>
    <select name="departure_airport" required>
        <option value="SVO">Шереметьево</option>
        <option value="DME">Домодедово</option>
        <option value="LED">Пулково</option>
    </select>
    <select name="arrival_airport" required>
        <option value="SVO">Шереметьево</option>
        <option value="DME">Домодедово</option>
        <option value="LED">Пулково</option>
    </select>
    <select name="status" required>
        <option value="Scheduled">Запланирован</option>
        <option value="Delayed">Задержан</option>
        <option value="Cancelled">Отменен</option>
        <option value="Completed">Завершен</option>
    </select>
    <select name="aircraft_type_code" required>
        <option value="AT001">Сухой Суперджет 100</option>
        <option value="AT002">Ил-96</option>
        <option value="AT003">Ту-204</option>
    </select>
    <button type="submit">Добавить</button>
</form>

<a href="index.php">Назад на главную</a>

<?php include '../templates/footer.php'; ?>
