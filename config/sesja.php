<?php 
session_start(); // Inicjacja sesji
require_once "class/Player.php";
require "./vendor/autoload.php";
if(!isset($_SESSION['zalogowany'])) 
{
  header("Location: index.php");
}


// Odśwież dane zapisane w zmiennycb sesyjnych. Ważne miejsce, wysokie obciążenie. 
function odswiezDane($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users, users_stats, users_coin WHERE users.id = :id AND users_stats.user_id = :id AND users_coin.user_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result) {
      $_SESSION['lang'] = "ENG";
      $_SESSION['userId'] = $id;
      $_SESSION['rank'] = $result['rank'];
      $_SESSION['userName'] = $result['username'];
      $_SESSION['userDescription'] = $result['description'];

      $_SESSION['awatar']  = $result['image'];
      $_SESSION['userStr'] = $result['strength'];
      $_SESSION['userResi'] = $result['resilience'];
      $_SESSION['userInt'] = $result['intelligence'];
      $_SESSION['userHp'] = $result['health'];
      $_SESSION['userMaxHp'] = $result['max_health'];

      $_SESSION['userLevel'] = $result['level'];
      $_SESSION['exp'] = $result['exp'];
      $_SESSION['limit_exp'] = $result['limit_exp'];
      
      $_SESSION['energy'] = $result['energy'];
      $_SESSION['max_energy'] = $result['max_energy'];

      $_SESSION['gold'] = $result['gold'];
     
    } 
    if($result) {
      // Utwórz nowy obiekt klasy Player
      $player = new Player();

      // Ustaw wartości pól za pomocą metod seterów
      $player->setUserId($id);
      $player->setRank($result['rank']);
      $player->setUserName($result['username']);
      $player->setUserDescription($result['description']);
      $player->setAvatar($result['image']);
      $player->setUserStr($result['strength']);
      $player->setUserResi($result['resilience']);
      $player->setUserInt($result['intelligence']);
      $player->setUserHp($result['health']);
      $player->setUserMaxHp($result['max_health']);
      $player->setUserLevel($result['level']);
      $player->setExp($result['exp']);
      $player->setLimitExp($result['limit_exp']);
      $player->setEnergy($result['energy']);
      $player->setMaxEnergy($result['max_energy']);
      $player->setGold($result['gold']);
   
      // Przypisz wartości z obiektu Player do zmiennych sesyjnych
      $_SESSION['player'] = serialize($player); // Zapisz obiekt do zmiennej sesyjnej

}
}

