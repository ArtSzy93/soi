<?php
// Plik odpowiedzialny za odbiór wiadomości z pliku czat.js, wykonanie polecenia i zwrócenia wyniku.
include("../config/db.php");

$sender = $_POST["sender"];
$message = $_POST["message"];


try {
    $sql = "INSERT INTO public_chat_messages (sender, message) VALUES (:sender, :message)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sender', $sender, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Zwrócenie zapisanych danych do przeglądarki (potwierdzenie zapisu)
        $response = array("sender" => $sender, "message" => $message);
        echo json_encode($response);
    } else {
        echo "Błąd: Nie udało się zapisać wiadomości.";
    }
} catch (PDOException $e) {
    echo "Błąd połączenia z bazą danych: " . $e->getMessage();
}

// Zamknięcie połączenia
$conn = null;
?>