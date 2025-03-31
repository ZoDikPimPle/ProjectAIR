<?php
include '../templates/header.php';
include '../includes/config.php';
include '../includes/db_operations.php';

// Получаем параметры фильтрации
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc';
$departure_airport = isset($_GET['departure_airport']) ? $_GET['departure_airport'] : '';
$arrival_airport = isset($_GET['arrival_airport']) ? $_GET['arrival_airport'] : '';

// Получаем данные о рейсах с учетом фильтров
$flights = getFlights($pdo, $sort, $departure_airport, $arrival_airport);

// Массив для перевода статусов, чтоб БД не менять
$statusTranslations = [
    'Scheduled' => 'Запланирован',
    'Delayed' => 'Задержан',
    'Cancelled' => 'Отменен',
    'Completed' => 'Завершен'
];

// Функция для форматирования даты
function formatDate($dateTime) {
    $date = new DateTime($dateTime);
    return $date->format('d.m.Y');
}
?>

<h1>Информация о рейсах</h1>
<form action="flights.php" method="get">
    <label for="sort">Сортировать по:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="asc" <?php if ($sort == 'asc') echo 'selected'; ?>>Возрастанию</option>
        <option value="desc" <?php if ($sort == 'desc') echo 'selected'; ?>>Убыванию</option>
    </select>

    <label for="departure_airport">Аэропорт вылета:</label>
    <select name="departure_airport" id="departure_airport" onchange="this.form.submit()">
        <option value="" <?php if ($departure_airport == '') echo 'selected'; ?>>Все</option>
        <option value="SVO" <?php if ($departure_airport == 'SVO') echo 'selected'; ?>>Шереметьево</option>
        <option value="DME" <?php if ($departure_airport == 'DME') echo 'selected'; ?>>Домодедово</option>
        <option value="LED" <?php if ($departure_airport == 'LED') echo 'selected'; ?>>Пулково</option>
    </select>

    <label for="arrival_airport">Аэропорт прибытия:</label>
    <select name="arrival_airport" id="arrival_airport" onchange="this.form.submit()">
        <option value="" <?php if ($arrival_airport == '') echo 'selected'; ?>>Все</option>
        <option value="SVO" <?php if ($arrival_airport == 'SVO') echo 'selected'; ?>>Шереметьево</option>
        <option value="DME" <?php if ($arrival_airport == 'DME') echo 'selected'; ?>>Домодедово</option>
        <option value="LED" <?php if ($arrival_airport == 'LED') echo 'selected'; ?>>Пулково</option>
    </select>
</form>

<button onclick="changeAllFlightsStatus('Cancelled')">Отменить все рейсы</button>
<button onclick="changeAllFlightsStatus('Delayed')">Задержать все рейсы</button>

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
            <td><?php echo formatDate($flight['departure_time']); ?></td>
            <td><?php echo formatDate($flight['arrival_time']); ?></td>
            <td><?php echo $flight['departure_airport']; ?></td>
            <td><?php echo $flight['arrival_airport']; ?></td>
            <td><?php echo $statusTranslations[$flight['status']]; ?></td>
            <td>
                <button onclick="toggleEditForm('<?php echo $flight['flight_number']; ?>')">Редактировать</button>
                <button onclick="deleteFlight('<?php echo $flight['flight_number']; ?>')">Удалить</button>
            </td>
        </tr>
        <tr id="edit-form-<?php echo $flight['flight_number']; ?>" style="display:none;">
            <td colspan="7">
                <form class="edit-flight-form">
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
                    <button type="button" onclick="saveEdit(this)">Сохранить</button>
                    <button type="button" onclick="cancelEdit('<?php echo $flight['flight_number']; ?>')">Отмена</button>
                </form>
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

<script>
function toggleEditForm(flightNumber) {
    const form = document.getElementById(`edit-form-${flightNumber}`);
    form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
}

function saveEdit(button) {
    const form = button.closest('form');
    const formData = new FormData(form);

    fetch('../actions/edit_flight_action.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        location.reload();
    });
}

function cancelEdit(flightNumber) {
    const form = document.getElementById(`edit-form-${flightNumber}`);
    form.style.display = 'none';
}

function deleteFlight(flightNumber) {
    if (confirm('Вы уверены, что хотите удалить этот рейс?')) {
        fetch(`../actions/delete_flight.php?flight_number=${flightNumber}`)
            .then(response => response.text())
            .then(data => {
                location.reload();
            });
    }
}

function changeAllFlightsStatus(status) {
    if (confirm(`Вы уверены, что хотите изменить статус всех рейсов на "${status}"?`)) {
        fetch(`../actions/change_all_status.php?status=${status}`)
            .then(response => response.text())
            .then(data => {
                location.reload();
            });
    }
}
</script>

<?php include '../templates/footer.php'; ?>
