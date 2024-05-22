<?php 
//Połączenie z bazą
include_once(__DIR__ . '/../config/db.php');
// Funkcje wykorzystane przy rejestracji //
// Funkcja sprawdzająca długość hasła
function dlugieHaslo($password,$dlugosc) {
    return strlen($password) >= $dlugosc; 
}
// Funkcja sprawdza, czu podany adres e-mail jest uzyty
function czyEmailIstnieje($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$result) return $email;
}
// Funkcja sprawdza, czu podany nick jest uzyty
function czyUserIstnieje($username) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :user");
    $stmt->bindParam(':user', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$result) return $username;
}
// Zmiana nicku użytkownika
if(isset($_POST['new-nick']))
{
  session_start();
  $newname = czyUserIstnieje($_POST['new-nick']);
  $id      = $_SESSION['userId'];
  if (!$newname) {
    $_SESSION['komunikat'] = "Użytkownik o podanym nicku istneiej! Wybierz inny!";
    header('Location: ../ustawienia.php');
    exit();
  } else {
    try {
      global $conn;
      $sql = "UPDATE users SET username = :user WHERE id = :id";
      $stmt = $conn -> prepare($sql);
      $stmt -> bindParam(':user', $newname, PDO::PARAM_STR);
      $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['komunikat'] = "Nick zmieniony!";
            header('Location: ../ustawienia.php');
            exit();
            } else {
            $_SESSION['komunikat'] = "Nic nie został zmieniony! Spróbuj ponownie!";
            header('Location: ../ustawienia.php');
            exit();
          }
      }catch (PDOException $e) {
        die("Błąd połączenia: " . $e->getMessage());
    }
  }
}
// Zmiana hasła użytkownika
if (isset($_POST['new-pass'])) {
  session_start();
  // Stare hasło
  $oldPass = $_POST['old-pass'];
  // Para nowych haseł.
  $newPass = $_POST['new-pass'];
  $reNewPass = $_POST['re-new-pass'];
  $id = $_SESSION['userId'];

  if ($newPass == $reNewPass) {
      try {
          global $conn;
          $stmt = $conn->prepare("SELECT id, password FROM users WHERE id = :id");
          $stmt->bindParam(':id', $id);
          $stmt->execute();
          $result = $stmt->fetch();

          if (password_verify($oldPass, $result['password'])) {
              $new = password_hash($newPass, PASSWORD_DEFAULT);
              $sql = "UPDATE users SET password = :pass WHERE id = :id";
              $stmt = $conn -> prepare($sql);
              $stmt -> bindParam(':pass', $new, PDO::PARAM_STR);
              $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
              if ($stmt->execute()) {
                $_SESSION['komunikat'] = "Hasło zostało zmienione!";
                header('Location: ../ustawienia.php');
                exit();
              } else {
                $_SESSION['komunikat'] = "Hasło nie zmienione! Spróbuj ponownie";
                header('Location: ../ustawienia.php');
                exit();
            }
          } else {
            $_SESSION['komunikat'] = "Stare hasło jest nieprawidłowe!";
            header('Location: ../ustawienia.php');
            exit();
          }
      } catch (PDOException $e) {
          die("Błąd połączenia: " . $e->getMessage());
      }
  } else { 
    $_SESSION['komunikat'] = "Podane hasła są różne!";
    header('Location: ../ustawienia.php');
    exit();
  }
}
// Rejestracja użytkownika 
function zarejestujUzytkownika($username, $password, $email, $token) {
      global $conn;
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $rank = "Podróżnik"; // Ranga nadawana automatycznie podczas rejestracji nowego usera.
      // Zapisanie użytkownika do bazy danych
      try {
        $stmt = $conn->prepare("INSERT INTO users (username, rank, email, password, dataDolaczenia, active_code) VALUES (:username, :rank, :email, :password, NOW(), :code)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':rank', $rank);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':code', $token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Błąd bazy danych: " . $e->getMessage();
        return false;
    }

}
// Dodawanie potwora do bazy 
function dodajPotwora($name, $str, $resi, $int, $hp, $desc) {
    global $conn;
    $stmt = $conn -> prepare("INSERT INTO monster (name, strenght, resilience, intelligence, health, description) VALUE (:name, :strenght, :resilience, :intelligence, :health, :description)"); 
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':strenght',$str);
    $stmt->bindParam(':resilience',$resi);
    $stmt->bindParam(':intelligence',$int);
    $stmt->bindParam(':health',$hp);
    $stmt->bindParam(':description',$desc);
    if ($stmt->execute()) {
        return true;
      } else {
        return false;
    }
}

// Wywoalnie funkcji jeżeli nadszedł odpowiedni argument w zmiennej POST
if(isset($_POST['monster']))
{
  $wynik = dodajPotwora($_POST['monster-name'],$_POST['monster-str'], $_POST['monster-resi'],$_POST['monster-int'], $_POST['monster-hp'], $_POST['monster-desc']);
  if ($wynik) {
    echo "success";
  } else {
    echo "error";
  }
}
// Wczytanie ID potworów do zmiennej sesyjnej. Przydatne w celu losowania potwora do walki.
function wczytajPotwory(){
  try {
    global $conn;
    $sql = "SELECT id FROM monster";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $monster_ids = array();
    // Pobierz wszystkie ID potworów
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $monster_ids[] = $row['id'];
    }
    // Zapisz ID potworów w tabeli sesyjnej
    $_SESSION['monster_ids'] = $monster_ids;
  } catch (PDOException $e) {
      echo "Błąd połączenia z bazą danych: " . $e->getMessage();
  }
}
// Wczytaj ID graczy, którzy mają życie wyższe niż 0
function wczytajGraczy(){
  try {
    global $conn;
    $id = $_SESSION['userId'];
    $sql = "SELECT user_id FROM users_stats WHERE health > '0' AND user_id != :id";
    $stmt = $conn->prepare($sql);
    $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $players_id = array();
    // Pobierz wszystkie ID potworów
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $players_id[] = $row['user_id'];
    }
    // Jeżeli brak pasujących rekordów
    if(empty($players_id)) {
      $_SESSION['players_id'] = 0;
    } else {
      // Zapisz ID potworów w tabeli sesyjnej
      $_SESSION['players_id'] = $players_id;
    }

  } catch (PDOException $e) {
      echo "Błąd połączenia z bazą danych: " . $e->getMessage();
  }
}

// Funkcja dodawania broni do DB
function dodajBron($name, $price, $min, $max) {
  global $conn;
  $stmt = $conn -> prepare("INSERT INTO weapon (name, price, min_dmg, max_dmg) VALUE (:name, :price, :min, :max)"); 
  $stmt->bindParam(':name',$name);
  $stmt->bindParam(':price',$price);
  $stmt->bindParam(':min',$min);
  $stmt->bindParam(':max',$max);
  if ($stmt->execute()) {
      echo "success";
    } else {
      echo "error";
  }
}
// Wywołanie funkcji dodawania broni po otrzymaniu POST
if(isset($_POST['weapon']))
{
  $wynik = dodajBron($_POST['weapon-name'],$_POST['weapon-price'],$_POST['weapon-min'], $_POST['weapon-max']);
  if ($wynik) {
    echo "success";
  } else {
    echo "error";
  }
}
// Wyświetlanie broni zapisanych do sklepu
function wyswietlBronieSklep() {
  try {
    global $conn;
    // Pobieranie danych z tabeli
    $stmt = $conn->prepare("SELECT * FROM weapon");
    $stmt->execute();
    
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $licznik = 1;
    if (!empty($data)) {
        foreach ($data as $row) {
            echo "<tr>";
            echo "<td>" . $licznik . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['min_dmg'] . "</td>";
            echo "<td>" . $row['max_dmg'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo '<td><a href="sklep.php?kup=' . $row['id'] . '">Kup</a></td>';
            echo "</tr>";
            $licznik++; 
        }
    } else {
        echo "Brak danych do wyświetlenia.";
    }
} catch (PDOException $e) {
    die("Błąd: " . $e->getMessage());
}
}
// Wyświetlanie aktualnie używanej broni przez gracza. Broń z polem active na "1".
function uzywanaBron($idGracza) {
  global $conn;
  $stmt = $conn -> prepare("SELECT * FROM users_weapons WHERE user_id = :id AND active = '1';");
  $stmt -> bindParam(':id', $idGracza);
  $stmt ->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if($result)
  {
    $id = $result['weapon_id'];
    if(!empty($result['pseudoname']))
    {
      $pseudo = $result['pseudoname'];
    } else {
      $pseudo = "";
    }
    $stmt = $conn -> prepare ("SELECT id,name, min_dmg, max_dmg FROM weapon WHERE id = :id");
    $stmt -> bindParam(':id', $id);
    $stmt ->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result){
      $name = $result['name'];
      $min = $result['min_dmg'];
      $max = $result['max_dmg'];
      $_SESSION['weaponId'] = $result['id'];
      $finish = $name . ' ' . $pseudo . ' ' . ' (' . $min . '-' . $max . ')';
      $_SESSION['weaponName'] = $finish;
      $_SESSION['weaponMinDmg'] = $min;
      $_SESSION['weaponMaxDmg'] = $max;
      return $finish;
    } return 'Brak danych o broni';
  } else {
    return 'Brak używanej broni';
  }

}
// Funkcja zakupu broni 
function zakupBron($idGracza, $idBroni) {
    global $conn;
    $stmt1 = $conn->prepare("SELECT * FROM users_coin WHERE user_id = :id");
    $stmt1->bindParam(':id', $idGracza);
    $stmt1->execute();
    $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    $gold = $result1['gold'];

    $stmt2 = $conn -> prepare("SELECT * FROM weapon WHERE id = :id");
    $stmt2 -> bindParam(':id',$idBroni);
    $stmt2 -> execute();
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $cost = $result2['price'];
    
    $stmt3 = $conn -> prepare("SELECT * FROM users_weapons WHERE user_id = :id AND weapon_id = :weaponId");
    $stmt3 -> bindParam(':id',$idGracza);
    $stmt3 -> bindParam(':weaponId', $idBroni);
    $stmt3 -> execute();
    $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);

    if($result3) {
      return 3;
    } elseif ($cost > $gold )
    {
      return 1;
    } else {
      $roznica = $gold - $cost;
      $stmt = $conn -> prepare("UPDATE users_coin SET gold = :roznica WHERE user_id = :id");
      $stmt -> bindParam(':roznica', $roznica);
      $stmt -> bindParam(':id', $idGracza);
      $stmt->execute();
      $stmt = $conn -> prepare("INSERT INTO users_weapons (user_id, weapon_id) VALUE (:id, :idWeapon)");
      $stmt -> bindParam(':id', $idGracza);
      $stmt -> bindParam(':idWeapon', $idBroni);
      $stmt->execute();
      return 2;
    }
    return 0;
}
// Wyświetlanie broni w ekwipunku gracza
function bronieEkwipunek($id)
{
  try {
    global $conn;
    // Pobieranie danych z tabeli
    $stmt = $conn->prepare("
    SELECT w.id, w.name, w.min_dmg, w.max_dmg, w.price
    FROM weapon w
    JOIN users_weapons uw ON w.id = uw.weapon_id
    WHERE uw.user_id = :id AND uw.active = 0 ;");
    $stmt -> bindParam(':id', $id);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $licznik = 1;
    if (!empty($data)) {
        foreach ($data as $row) {
            echo "<tr>";
            echo "<td>" . $licznik . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['min_dmg'] . "</td>";
            echo "<td>" . $row['max_dmg'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo '<td><a href="ekwipunek.php?zaloz=' . $row['id'] . '">Załóż</a><br>';
            echo "</tr>";
            $licznik++; 
        }
    } else {
        echo "Brak danych do wyświetlenia.";
    }
  } catch (PDOException $e) {
      die("Błąd: " . $e->getMessage());
  }
}
// Zakładanie broni
function zalozBron($idGracza, $idBroni)
{
    global $conn;
    // Zdjęcie wszystkich założonych broni
    $stmt = $conn->prepare("UPDATE users_weapons SET active = '0' WHERE user_id = :id");
    $stmt -> bindParam(':id', $idGracza);
    $stmt -> execute();
    // Założenie wskazanej broni
    $stmt = $conn->prepare("UPDATE users_weapons SET active = '1' WHERE user_id = :id AND weapon_id = :idWeapon");
    $stmt -> bindParam(':id', $idGracza);
    $stmt -> bindParam(':idWeapon', $idBroni);
    $result = $stmt -> execute();

    if($result) {
      return 1;
    } else {
      return 2;
    }
}
// Zmiana pseudonimu broni
if (isset($_POST['idBroni'])) 
{
    $idBroni = $_POST['idBroni'];
    $pseudo  = '"'.$_POST['pseudo'].'"';
    if(empty($pseudo))
    {
      header("Location: ../ekwipunek.php?status=false");
    }
    global $conn;
    $stmt = $conn ->prepare ("UPDATE users_weapons SET pseudoname = :pseudo WHERE weapon_id = :id");
    $stmt -> bindParam(':id', $idBroni);
    $stmt -> bindParam(':pseudo', $pseudo);
    $result = $stmt -> execute();
    if($result) {
        header("Location: ../ekwipunek.php?status=succes");
    } else {
      header("Location: ../ekwipunek.php?status=false");
    }
};
// Wyświetlanie listy potworów w pliku przygoda.php
function listaPotworow() {
    global $conn;
    $stmt = $conn -> prepare("SELECT id, name FROM monster");
    $stmt -> execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($data)) {
        foreach($data as $row) {
          echo '<option value="'. $row['id'].'">'.$row['name'].'</option>';
        }
    } else {
      echo "Brak danych do wyświetlenia.";
  }
} 
  if(isset($_GET['potworId']))
  {
    $potworId = $_GET['potworId'];
    try {
      $stmt = $conn->prepare("SELECT name, description FROM monster WHERE id = :potworId");
      $stmt->bindParam(':potworId', $potworId);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {
          echo json_encode($result);
      } else {
          echo json_encode(array('error' => 'Potwór nie istnieje'));
      }
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

  }
// Wysyłanie prywatnej wiadomości do gracza
if(isset($_POST['message']))
{
  session_start();
  // Do kogo wysyłamy wiadomość
  $player  = $_POST["player"];
  // Tytuł
  $tittle  = $_POST["tittle"];
  // Wiadomość
  $message = $_POST["message"];
  // Kto wyyła wiadomość
  $sender  = $_POST['userid'];
  if (strlen($message) > 1000) {
    $_SESSION['komunikat'] = "Wiadomość jest za długa!";
    header("Location: ../wiadomosci.php");
    exit();
  } 
  if (strlen($tittle) > 45) {
    $_SESSION['komunikat'] = "Temat maksymalnie do 45 znaków!";
    header("Location: ../wiadomosci.php");
    exit();
  } 
  $sql = "SELECT id FROM users WHERE id = :recipient OR username = :recipient LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":recipient", $player, PDO::PARAM_STR);
  $stmt->execute();
  
  $recipientExists = $stmt->fetchColumn();

  if ($recipientExists == $_SESSION['userId']) {
      $_SESSION['komunikat'] = "Nie można wysłać wiadomości do samego siebie!";
      header("Location: ../wiadomosci.php");
      exit();
  }
  
  if (!$recipientExists) {
      $_SESSION['komunikat'] = "Odbiora nie istnieje!";
      header("Location: ../wiadomosci.php");
      exit();
  } else {
      // Wysłanie wiadomości do bazy
      $sql = "INSERT INTO private_messages (sender, recipient, tittle, message) VALUES (:sender, :recipient, :tittle, :message)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":sender", $sender, PDO::PARAM_INT);
      $stmt->bindParam(":recipient", $recipientExists, PDO::PARAM_INT);
      $stmt->bindParam(":tittle", $tittle, PDO::PARAM_STR);
      $stmt->bindParam(":message", $message, PDO::PARAM_STR);
      
      if ($stmt->execute()) {
        $_SESSION['komunikat'] = "Wiadomość została wysłana!";
      } else {
        $_SESSION['komunikat'] = "Nie udało się wysłać wiadomości! Spróbuj później!";
      }
      header("Location: ../wiadomosci.php");
      exit();
  }
}  
// Wyświetlanie listy prywatnych wiadomości
function wyswietlWiadomosci($userid) {
  try {
    global $conn;
      $stmt = $conn->prepare("
      SELECT private_messages.id, private_messages.tittle, private_messages.sender, private_messages.time, private_messages.recipient, users.username 
      FROM private_messages 
      INNER JOIN users ON private_messages.sender = users.id 
      WHERE private_messages.recipient = :id"
    );
    $stmt->bindParam(':id', $userid, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($data)) {
        foreach ($data as $row) {
            echo "<tr>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['tittle'] . "</td>";
            echo '<td><a href="czytaj.php?wiadomosc=' . $row['id'] . '">Zobacz</a> | ';
            echo '<a href="wiadomosci.php?usun=' . $row['id'] . '">Usuń</a></td>';
            echo "</tr>";
        }
    } else {
        echo "Brak danych do wyświetlenia.";
    }
} catch (PDOException $e) {
    die("Błąd: " . $e->getMessage());
}
}
// Odczytanie wiadomości z skrzynki pocztowej
function czytajWiadomosc($idwiadomosci) {
  try {
    global $conn;
      $stmt = $conn->prepare("
      SELECT private_messages.id, private_messages.tittle, private_messages.sender, private_messages.time, private_messages.message, users.username 
      FROM private_messages 
      INNER JOIN users ON private_messages.sender = users.id 
      WHERE private_messages.id = :id"
    );
    $stmt->bindParam(':id', $idwiadomosci, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($data)) {
        foreach ($data as $row) {
            $_SESSION['czas'] = $row['time'];
            $_SESSION['nadawca'] = $row['username'];
            $_SESSION['tytul'] = $row['tittle'];
            $_SESSION['tresc'] = $row['message'];
            $_SESSION['idWiadomosci'] = $idwiadomosci;
        }
      } else {
        echo "Brak danych do wyświetlenia.";
      }
      }  catch (PDOException $e) {
      die("Błąd: " . $e->getMessage());
  }
}
// Usuwanie wiadomości z bazy danych
function usunWiadomosc($id) {
  try {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM private_messages WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->execute()) {
      $_SESSION['komunikat'] = "Wiadomość została USUNIĘTA!";
    } else {
      $_SESSION['komunikat'] = "Nie udało się USUNĄĆ wiadomości! Spróbuj później!";
    }
  } catch(PDOException $e) {
    echo "Wystąpił błąd: " . $e->getMessage();
  } 
  header("Location: wiadomosci.php");
  exit;
}
// Funkcja Dodawanie changelogow
function changelog($title, $message) {
  try {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO changelog (title, message) VALUES (:title, :message)");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);

    if ($stmt->execute()) {
      echo "success";
    } else {
      echo "error";
    }
  } catch(PDOException $e) {
    echo "Wystąpił błąd: " . $e->getMessage();
  } 
}
// Wywołanie funkcji changelog gdy POST
if(isset($_POST['changelog'])) {
    changelog($_POST['title_log'], $_POST['log']); // Popraw literówkę w 'tittle_log' na 'title'
}
// Wyświetenie changeloga w postaci tabeli
function wyswietlChangelog()
{
  try {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM changelog ORDER BY time DESC");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($data)) {
        foreach ($data as $row) {
            echo "<p>" . $row['time'] . "| ". $row['title'] . "</p><p> ". $row['message']. "</p>";
            echo "<hr>";
      
        }
    } else {
        echo "Brak danych do wyświetlenia.";
    }
  } catch (PDOException $e) {
      die("Błąd: " . $e->getMessage());
  }
}
// Ustaw życie gracza na wskazną wartość
function ustawZycie($idGracza, $zycie)
{
  if($zycie < 0)
  {
    $zycie = 0;
  }
  global $conn;
  $stmt = $conn->prepare("UPDATE users_stats SET health = :hp WHERE user_id = :gracz");
  $stmt-> bindParam(':hp', $zycie, PDO::PARAM_INT);
  $stmt-> bindParam(':gracz', $idGracza, PDO::PARAM_INT);
  $stmt-> execute();

}
// Uzdrowienie gracza do pełnej wartości max hp
function uzdrowienie($idGracza)
{
  session_start();
  $poziom = $_SESSION['userLevel'];
  global $conn;
  $cena  = 100 * $poziom;
  if($cena > $_SESSION['gold'])
  {
    return false;
  }
  if($_SESSION['userHp'] == $_SESSION['userMaxHp'])
  {
    return false;
  }
  zabierzZloto($idGracza, $cena);
  $stmt = $conn->prepare("UPDATE users_stats SET health = max_health WHERE user_id = :gracz");
  $stmt-> bindParam(':gracz', $idGracza, PDO::PARAM_INT);
  $result = $stmt-> execute();
  $_SESSION['userHp'] = $_SESSION['userMaxHp'];
  return $result;
}
// Dodaj doświadczenie za walkę z potworem
function dodajDoswiadczenie($idGracza, $poziomTrudnosci)
{
  global $conn;
  // Przypisanie aktualnie pobranych danych z sesji
  $poziom   = $_SESSION['userLevel'];
  $exp      = $_SESSION['exp'];
  $expToLvl = $_SESSION['limit_exp'];
  // Nagroda w zależności od poziomu trudności
  if($poziomTrudnosci == "Łatwy")
  {
    $pd = rand(1,5) * $poziom;
  } elseif ($poziomTrudnosci == "Średni") {
    $pd = rand(5,10) * $poziom;
  } elseif ($poziomTrudnosci == "Trudny") {
    $pd = rand(10,15) * $poziom;
  } else {
    $pd = rand(5,20) * $poziom;
  }
  // Dodawanie doświadczenia do zmiennej lokalnej
  $exp += $pd;
  // Jeżeli próg doświadczenia został osiagnięty - awansuj postać.
  if($exp >=  $expToLvl) {
    // Wyzerowanie licznika expa
    $exp = 0;
    // Jeżeli poziom w przedziale 1-10, ustaw potrzebne doświadczenie na 10% więcej.
    if($poziom <=10)
    {
      $expToLvl = round($expToLvl * 1.1); // Zaokrąglenie do liczby całkowitej
    // Jeżeli poziom w przedziale 11-30, ustaw potrzebme doświadzenie na 20% więcej. 
    } elseif ($poziom >= 11 && $poziom <= 30) {
      $expToLvl = round($expToLvl * 1.2); // Zaokrąglenie do liczby całkowitej
    // Jeżeli większy niż 31, ustaw potrzebne doświadczenie na 30% więcej  
    } else {
      $expToLvl = round($expToLvl * 1.3); // Zaokrąglenie do liczby całkowitej
    }
    // Zwiększenie poziomu o 1.
    $poziom += 1;
    podniesPoziom($idGracza);
    // Wykonanie zapytania do bazy danych.
    $stmt = $conn -> prepare("UPDATE users_stats SET exp = :exp, limit_exp = :limit WHERE user_id = :id");
    $stmt -> bindParam(':exp', $exp, PDO::PARAM_INT);
    $stmt -> bindParam(':limit', $expToLvl, PDO::PARAM_INT);
    $stmt -> bindParam(':id', $idGracza, PDO::PARAM_INT);
    $stmt -> execute();

    $_SESSION['komunikat'] = "Otrzymałeś $pd punktów doświadczenia oraz nowy poziom! Aktualnie jesteś na poziomie $poziom";
  }
  else {
    // Wykonanie zapytania do bazy danych.
    $stmt = $conn -> prepare("UPDATE users_stats SET exp = :exp WHERE user_id = :id");
    $stmt -> bindParam(':exp', $exp, PDO::PARAM_INT);
    $stmt -> bindParam(':id', $idGracza, PDO::PARAM_INT);

    $stmt -> execute();
    $_SESSION['komunikat'] = "Otrzymałeś $pd punktów doświadczenia!";
  }
}
// Podnieś poziom gracza
function podniesPoziom($idGracza) 
{
  // Zwiększenie poziomu o 1
  $_SESSION['userLevel'] +=  1;
  // Zwiększenie max_zycia
  $_SESSION['userMaxHp'] += rand(1,5) + $_SESSION['userLevel'];
  // Zwiększenie siły
  $_SESSION['userStr']   += rand(1,2);
  // Zwiększenie odporności
  $_SESSION['userResi']  += rand(1,2);
  // Zwiększenie inteligencji
  $_SESSION['userInt']   += rand(1,4);
  // Zwiększenie poziomu energi
  $_SESSION['max_energy']    += rand(1,3);
  // Wykonanie zapytania do DB
  global $conn;
  $stmt = $conn -> prepare("UPDATE users_stats SET level = :level, strength = :str, resilience = :resi, intelligence = :int, max_health = :maxhp, max_energy = :energy WHERE user_id = :id");
  $stmt -> bindParam(':level', $_SESSION['userLevel'], PDO::PARAM_INT);
  $stmt -> bindParam(':str', $_SESSION['userStr'], PDO::PARAM_INT);
  $stmt -> bindParam(':resi', $_SESSION['userResi'], PDO::PARAM_INT);
  $stmt -> bindParam(':int', $_SESSION['userInt'], PDO::PARAM_INT);
  $stmt -> bindParam(':maxhp', $_SESSION['userMaxHp'], PDO::PARAM_INT);
  $stmt -> bindParam(':energy', $_SESSION['max_energy'], PDO::PARAM_INT);
  $stmt -> bindParam(':id', $idGracza, PDO::PARAM_INT);
  $stmt -> execute();
}
// Funkcja odbierająca energie za akcje
function zabierzEnergie($id, $ile = 1)
{
  global $conn;
  $stmt = $conn -> prepare("UPDATE users_stats SET energy = energy - :ile WHERE user_id = :id");
  $stmt -> bindParam('id', $id, PDO::PARAM_INT);
  $stmt -> bindParam('ile', $ile, PDO::PARAM_INT);
  $stmt -> execute();
  $_SESSION['energy'] -= $ile;
}
// Zakładanie nowego pokoju prywatnego w karczmie
function nowyPokoj($name, $idGracza)
{
  global $conn;
  $stmt = $conn -> prepare("INSERT INTO private_room (name, owner_id) VALUE (:name, :id)");
  $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
  $stmt -> bindParam(':id', $idGracza, PDO::PARAM_INT);
  $stmt -> execute();
}
// Lista pokoi, do których należy gracz
function listaPokoi($id)
{
  try {
    global $conn;
    $sql = "SELECT rooms.id, rooms.name
            FROM private_room AS rooms
            INNER JOIN private_room_member AS members
            ON rooms.id = members.room_id
            WHERE members.user_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  if ($rows) {
    echo "<div class='container'>";
    echo "<div class='row'";
    echo "<div class='col-md-4'";
    foreach ($rows as $row) {
        echo "<p>Pokój: {$row['name']}<p><br><a href='pokoj.php?id={$row['id']}'><button class='przyciski-strona-glowna'>Wejdź do pokoju</button></a><hr>";
        
    }
    } else {
        echo "<p>Gracz o ID $id nie należy do żadnych pokojów.</p>";
    }
} catch (PDOException $e) {
    echo "Błąd połączenia z bazą danych: " . $e->getMessage();
}
echo "</div>";
echo "</div>";
echo "</div>";
}
// Funkcja sprawdzająca, czy pokój istnieje oraz czy gracz ma do niego dostęp 
function sprawdzUprawnieniaPokoju($idGracza, $idPokoju)
{
  global $conn;
  // Sprawdzam, czy gracz jest na liście członków danego pokoju. 
  $stmt = $conn -> prepare("SELECT * FROM private_room_member WHERE room_id = :room AND user_id = :id");
  $stmt -> bindParam(':room', $idPokoju, PDO::PARAM_INT);
  $stmt -> bindParam(':id', $idGracza, PDO::PARAM_INT);
  $stmt -> execute();

  return $stmt->rowCount() > 0;
}
// Funkcja zapraszająca gracza do pokoju prywatnego w karczmie
function zaprosUsunDoPokoju($id, $roomId, $tryb)
{
  global $conn;
  // Sprawdzam, czy gracz istnieje. 
  $stmt = $conn -> prepare("SELECT id FROM users WHERE id = :user");
  $stmt -> bindParam(':user', $id, PDO::PARAM_INT);
  $stmt -> execute();
  if($stmt -> rowCount() < 1) {
    $_SESSION['komunikat'] = "Gracz o podanym ID nie istnieje!";
    header('Location: pokoj.php?id='.$roomId);
    exit();
  }
  // Sprawdzam, czy gracz w pokoju
  $stmt = $conn -> prepare("SELECT user_id FROM private_room_member WHERE user_id = :user");
  $stmt -> bindParam(':user', $id, PDO::PARAM_INT);
  $stmt -> execute();
    if($stmt -> rowCount() > 0) {
      // Jeżeli gracz jest w pokoju, a tryb 2 = wyrzuć go
      if($tryb = 2) {
        $sql = "DELETE FROM private_room_member WHERE room_id = :room_id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            $_SESSION['komunikat'] = "Gracz o podanym ID został usunięty z pokoju!";
            header('Location: pokoj.php?id='.$roomId);
            exit();
        } else {
            // Błąd przy usuwaniu gracza
            $_SESSION['komunikat'] = "Błąd usuwania gracza!";
            header('Location: pokoj.php?id='.$roomId);
            exit();
        }
      } else {
        $_SESSION['komunikat'] = "Gracz o podanym ID jest już członkiem tego pokoju!";
        header('Location: pokoj.php?id='.$roomId);
        exit();
      }
    }
  // Jeżeli tryb 1 dodaj gracza do pokoju. 
  if($tryb = 1) {
    $stmt = $conn -> prepare("INSERT INTO private_room_member (room_id, user_id) VALUES (:room, :id)");
    $stmt -> bindParam(':room', $roomId, PDO::PARAM_INT);
    $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
    $result = $stmt -> execute();
    if($result) {
      $_SESSION['komunikat'] = "Gracz o $id został zaproszony do pokoju!";
      header('Location: pokoj.php?id='.$roomId);
      exit();
    } 
  } 
}
// Aktualna lists graczy w pokoju 
function graczeWPokoju($idPokoju)
{
    global $conn;
    $sql  = "SELECT r.room_id, r.user_id, u.username FROM private_room_member AS r 
            INNER JOIN users AS u 
            ON r.user_id = u.id 
            WHERE r.room_id = :id
            ORDER BY r.user_id ASC";
    $stmt = $conn ->prepare($sql);
    $stmt -> bindParam(':id', $idPokoju, PDO::PARAM_INT);
    $stmt -> execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
    if ($rows) {
      echo "<p>";
      $count = count($rows); // Liczba wyników
      foreach ($rows as $index => $row) {
          echo $row['username'].'('. $row['user_id'].')';
          if ($index < $count - 1) {
              echo ', '; // Dodaj przecinek, jeśli to nie jest ostatni element
          }
      }
      echo "</p>";
  } 
  else {
      echo "<p>Brak graczy!</p>";
  }
}
// Wyświetlanie listy graczy
function listaGraczy($szukaj = null) {
  global $conn;
  if ($szukaj === null) { 
    $sql  = "SELECT id, username, rank FROM users";
  } else {
    $sql  = "SELECT id, username, rank FROM users WHERE username LIKE :szukaj OR id LIKE :szukaj OR rank LIKE :szukaj "; 
  }
  
  $stmt = $conn->prepare($sql);
  
  // Dodajemy wiązanie parametru
  if ($szukaj !== null) {
    $szukaj = $szukaj . "%"; // Dodajemy znak % do szukanej frazy
    $stmt->bindParam(':szukaj', $szukaj, PDO::PARAM_STR);
  }
  
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  if ($rows) {
    echo '<table class="table table-dark text-white m-2 mr-1 p-1">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Username</th>';
    echo '<th>Rank</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    foreach ($rows as $row) {
      if($row["rank"] == "admin") {
        echo '<tr>';
        echo '<td>' . $row["id"] . '</td>';
        echo '<td><i class="fa-solid fa-crown"></i> <a href="statystyki.php?id=' . $row["id"] . '" style="text-decoration: none; color: Gold;">' . $row["username"] . '</a></td>';
        echo '<td style="color: Gold;"> Administrator </td>';
        echo '</tr>';
      } else {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td><i class="fa-regular fa-chess-pawn"></i> <a href="statystyki.php?id=' . $row["id"] . '" style="text-decoration: none; color: White;">' . $row["username"] . '</a></td>';
            echo '<td>' . $row["rank"] . '</td>';
            echo '</tr>';
      }

    }
    
    echo '</tbody>';
    echo '</table>';
  } else {
    echo "Brak wyników!";
  }
}
// Wywołanie funkcji szukania dynamicznie graczy w ratuszu
if (isset($_POST['szukaj'])) {
  listaGraczy($_POST['szukaj']);
}
// Dodanie złota graczowi 
function dodajZloto($idGracza, $ile) 
{
  global $conn;
  $sql = "UPDATE users_coin SET gold = gold + :ile WHERE user_id = :id";
  $stmt = $conn -> prepare($sql);
  $stmt -> bindParam(':id', $idGracza, PDO::PARAM_INT);
  $stmt -> bindParam(':ile', $ile, PDO::PARAM_INT);
  $stmt->execute();
}
// Zabierz złoto graczowi 
function zabierzZloto($idGracza, $ile)
{
  global $conn;
  $sql = "UPDATE users_coin SET gold = gold - :ile WHERE user_id = :id";
  $stmt = $conn -> prepare($sql);
  $stmt -> bindParam(':id', $idGracza, PDO::PARAM_INT);
  $stmt -> bindParam(':ile', $ile, PDO::PARAM_INT);
  $stmt->execute();
}
// Praca. Dodanie złota, odjęcie energii.
if(isset($_POST['czas-pracy']))
{
  session_start();
  $idGracza       = $_SESSION['userId'];
  $czasPracy      = $_POST['czas-pracy'];
  $miejsce        = $_POST['miejsce'];

  if($czasPracy > $_SESSION['energy']) {
    $_SESSION['praca'] = "Masz za mało energi, aby pracować! Wróć póżniej!";
    header('Location: ../praca.php');
    exit();
  }

  zabierzEnergie($idGracza, $czasPracy);
  $wynagrodzenie  = $_POST['czas-pracy'] * 20 + $_SESSION['userLevel'];
  dodajZloto($idGracza,$wynagrodzenie);
  $_SESSION['gold'] += $wynagrodzenie;
  $_SESSION['praca'] = "Praca ".$miejsce." zakończona sukcesem! Otrzymujesz ". $wynagrodzenie . " złota za aktywność!";
  header('Location: ../praca.php');

}
// Odebranie opisu postaci z ustawien
if (isset($_POST['akcja']) && $_POST['akcja'] === 'zmien-opis')  {
    session_start();
    $opis_postaci = $_POST['opis_postaci'];
    $id    = $_SESSION['userId'];
    global $conn;
    $stmt = $conn -> prepare("UPDATE users SET description = :desc WHERE id = :id");
    $stmt -> bindParam(':desc', $opis_postaci, PDO::PARAM_STR);
    $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
    $result = $stmt -> execute();
    if($result) {
      $_SESSION['komunikat'] = "Profil został zapisany!";
      header('Location: ../ustawienia.php');
      exit();
    } 
    else {
      $_SESSION['komunikat'] = "Profil nie został zapisany!";
      header('Location: ../ustawienia.php');
      exit();
    }
} 
// Dodawanie ogłoszeń. Ogłoszenia w pliku ratusz.php 
if(isset($_POST['adv'])) {
  // Cena dodania ogłoszenia
  $cena = 2000;
  session_start();
  $gold = $_SESSION['gold'];
  if($cena > $gold) {
    $_SESSION['komunikat'] = "Nie masz tyle gotówki! Wróć, gdy zarobisz na ogłoszenie!";
    header('Location: ../ratusz.php');
    exit();
  }
  $nick     = $_SESSION['userName'];
  $idGracza = $_SESSION['userId'];
  $title = $_POST['title_adv'];
  $text  = $_POST['text_adv'];
  try {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO advertisements (title, text, kto) VALUES (:title, :text, :kto)");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':text', $text, PDO::PARAM_STR);
    $stmt->bindParam(':kto', $nick, PDO::PARAM_STR);

    if ($stmt->execute()) {
      $_SESSION['komunikat'] = "Ogłoszenie zostało dodane!";
      zabierzZloto($idGracza, $cena);
      header('Location: ../ratusz.php');
      exit();
    } else {
      $_SESSION['komunikat'] = "Błąd dodawania ogłoszenia";
      header('Location: ../ratusz.php');
      exit();
    }
  } catch(PDOException $e) {
    echo "Wystąpił błąd: " . $e->getMessage();
  } 
}
// Wyśwetlanie ogłoszeń 
function listaOgloszen()
{
  global $conn;
  $stmt = $conn -> prepare ("SELECT * FROM advertisements ORDER BY data DESC");
  $stmt->execute();

  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($rows as $row) {
    echo '<p class="mt-3 p-1">';
    // Konwersja timestamp na format "dd-mm-rrrrr"
    $nowaData = date("d-m-Y", strtotime($row['data']));
    echo 'Data: '. $nowaData . ' '. $row['kto'];
    echo '<br>';
    echo '<b>Temat: '.$row['title']. "<br></b>";
    echo $row['text']. "</p>";
    echo "<hr>";
  }
}