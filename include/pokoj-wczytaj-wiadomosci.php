<?php
// Plik odpowiedzialny za wczytywanie wiadomości z bazy danych i zwracanie ich do przeglądarki.
include("../config/db.php");

try {
    // Pobieramy ID pokoju przekazywane przez GET
    $roomId = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$roomId) {
        echo "Brak ID pokoju.";
        exit();
    }

    $sql = "SELECT m.sender, m.message, m.time, u.id AS user_id, r.name AS room_name
            FROM private_room_messages m
            JOIN users u ON m.sender = u.username
            JOIN private_room r ON m.room_id = r.id
            WHERE m.room_id = :room_id
            ORDER BY m.id ASC LIMIT 44";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
    $stmt->execute();
    
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Zwracamy wiadomości jako JSON do przeglądarki
    echo json_encode($messages);
} catch (PDOException $e) {
    echo "Błąd połączenia z bazą danych: " . $e->getMessage();
}

// Zamknięcie połączenia
$conn = null;
?>