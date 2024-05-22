<?php
session_start();
require_once "class/Player.php";
require_once("config/db.php"); // Importuj plik konfiguracyjny bazy danych
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $secret = '6Lcv81kpAAAAAPCeMgN-T5ZN1Mpxp1PMPqBMsOMa';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
    $odpowiedz = file_get_contents($url);
    $dekoduj = json_decode($odpowiedz);
    
    if($response == '') {
            $_SESSION['blad'] = "Wypełnij prawidłowo pole reCaptcha!";
            header("Location: index.php");
            exit();
   }
   try {
        $stmt = $conn->prepare("SELECT id, username, rank, password, active FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();
        $check = false;

        if(password_verify($password,$result['password']))
        {
            $check = true;
        } else  {
            $_SESSION['blad'] = "Błędne hasło. Spróbuj ponownie.";
            header("Location: index.php");
            exit();
        }
        if($result['active'] == 1)
        {
            $check = true;
        } else  {
            $_SESSION['blad'] = "Konto nie zostało aktywowane.";
            header("Location: index.php");
            exit();
        }
        if ($result && $check) {
            $_SESSION['userId'] = $result['id'];
            $_SESSION['nick'] = $result['username'];
            $_SESSION['rank'] = $result['rank'];
            $_SESSION['lang'] = "PL";
            $_SESSION['zalogowany'] = true;

            header("Location: glowna.php");
            exit();
        } else {
            $_SESSION['blad'] = "Błędny e-mail lub hasło. Spróbuj ponownie.";
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        die("Błąd połączenia: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
?>
