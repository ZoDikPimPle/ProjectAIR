<?php
function getFlights($pdo, $sort = 'asc') {
    $sql = "SELECT f.flight_number, f.departure_time, f.arrival_time,
                   da.name as departure_airport, aa.name as arrival_airport, f.status, f.aircraft_type_code
            FROM flights f
            JOIN airports da ON f.departure_airport = da.airport_code
            JOIN airports aa ON f.arrival_airport = aa.airport_code
            ORDER BY f.departure_time " . $sort;
    $stmt = $pdo->query($sql);
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
?>
