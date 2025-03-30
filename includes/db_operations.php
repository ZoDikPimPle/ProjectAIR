<?php
function getFlights($pdo, $sort = 'asc') {
    $sql = "SELECT f.flight_number, f.departure_time, f.arrival_time,
                   da.name as departure_airport, aa.name as arrival_airport, f.status
            FROM flights f
            JOIN airports da ON f.departure_airport = da.airport_code
            JOIN airports aa ON f.arrival_airport = aa.airport_code
            ORDER BY f.departure_time " . $sort;
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
