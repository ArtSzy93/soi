<?php
include_once('config/db.php');

global $conn;
// Odnawianie energi graczy
$sql  = "UPDATE users_stats SET energy = max_energy, health = max_health";
$stmt = $conn -> prepare($sql);
$stmt -> execute();
// Usuwanie ogłoszeń starszych niż 7 dni. 
// Oblicz timestamp, który odpowiada dacie sprzed 7 dni
$stare= strtotime('-7 days');

$sql = "SELECT id FROM advertisements WHERE data < :dni";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':dni', $stare, PDO::PARAM_INT);
$stmt->execute();
// Usuwanie ogłoszeń starszych niż 7 dni
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $adId = $row['id'];
    $deleteSql = "DELETE FROM advertisements WHERE id = :adId";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(':adId', $adId, PDO::PARAM_INT);
    $deleteStmt->execute();
}

?>