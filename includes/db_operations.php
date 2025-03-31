<?php
function getFlights($pdo, $sort = 'asc', $departure_airport = '', $arrival_airport = '') {
    $sql = "SELECT f.flight_number, f.departure_time, f.arrival_time,
                   da.name as departure_airport, aa.name as arrival_airport, f.status, f.aircraft_type_code
            FROM flights f
            JOIN airports da ON f.departure_airport = da.airport_code
            JOIN airports aa ON f.arrival_airport = aa.airport_code";

    $conditions = [];
    $params = [];

    if (!empty($departure_airport)) {
        $conditions[] = "da.airport_code = ?";
        $params[] = $departure_airport;
    }

    if (!empty($arrival_airport)) {
        $conditions[] = "aa.airport_code = ?";
        $params[] = $arrival_airport;
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY f.departure_time " . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getFlightById($pdo, $flight_number) {
    $sql = "SELECT * FROM flights WHERE flight_number = :flight_number";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['flight_number' => $flight_number]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addFlight($pdo, $flight_number, $departure_time, $arrival_time, $departure_airport, $arrival_airport, $status, $aircraft_type_code) {
    $sql = "INSERT INTO flights (flight_number, departure_time, arrival_time, departure_airport, arrival_airport, status, aircraft_type_code)
            VALUES (:flight_number, :departure_time, :arrival_time, :departure_airport, :arrival_airport, :status, :aircraft_type_code)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'flight_number' => $flight_number,
        'departure_time' => $departure_time,
        'arrival_time' => $arrival_time,
        'departure_airport' => $departure_airport,
        'arrival_airport' => $arrival_airport,
        'status' => $status,
        'aircraft_type_code' => $aircraft_type_code
    ]);
}

function editFlight($pdo, $flight_number, $departure_time, $arrival_time, $departure_airport, $arrival_airport, $status, $aircraft_type_code) {
    $sql = "UPDATE flights SET departure_time = :departure_time, arrival_time = :arrival_time,
                              departure_airport = :departure_airport, arrival_airport = :arrival_airport,
                              status = :status, aircraft_type_code = :aircraft_type_code
            WHERE flight_number = :flight_number";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'departure_time' => $departure_time,
        'arrival_time' => $arrival_time,
        'departure_airport' => $departure_airport,
        'arrival_airport' => $arrival_airport,
        'status' => $status,
        'aircraft_type_code' => $aircraft_type_code,
        'flight_number' => $flight_number
    ]);
}

function getFlightByNumber($pdo, $flight_number) {
    $stmt = $pdo->prepare("SELECT * FROM flights WHERE flight_number = ?");
    $stmt->execute([$flight_number]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deleteFlight($pdo, $flight_number) {
    $stmt = $pdo->prepare("DELETE FROM flights WHERE flight_number = ?");
    $stmt->execute([$flight_number]);
}

function changeAllFlightsStatus($pdo, $status) {
    $sql = "UPDATE flights SET status = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$status]);
}


?>
