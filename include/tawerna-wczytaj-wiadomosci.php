<?php
// Plik odpowiedzialny za wczytywanie wiadomości z bazy danych i zwracanie ich do przeglądarki.
include("../config/db.php");

try {
    $sql = "SELECT m.sender, m.message, m.time, u.id AS user_id FROM public_tavern_messages m
            JOIN users u ON m.sender = u.username
            ORDER BY m.id ASC LIMIT 44"; // Pobieramy ostatnie 44 wiadomości z ID gracza
    $stmt = $conn->prepare($sql);
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