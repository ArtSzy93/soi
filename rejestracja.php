<?php 
header("Access-Control-Allow-Origin: *");
include_once("config/db.php");
include_once("config/mailer.php");
include_once("class/Register.php");
include_once("include/funkcje.php");
require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['email']))) {
    $email = $_POST['email'];
    $email_re = $_POST['remail'];
    $password = $_POST['password'];
    $password_re = $_POST['repassword'];
    $name = $_POST['username'];
    
    $db = new Db();
    $db = $db->connect();
    $register = new Register($name, $email, $email_re, $password, $password_re, $db);

    $errors = '';

    $checkEmail1 = $register->checkEmail();
    if ($checkEmail1 == false) { 
        $errors .= "- Podane adresy e-mail roznia sie od siebie <br>";
    }
    
    $checkPass  = $register->checkPassword();
    if ($checkPass == false) { 
        $errors .= "- Podane hasła różnią się od siebie lub nie posiadają 8 znaków długości! <br>";
    }
    
    $checkUser  = $register->exists_user($name, $db);
    if ($checkUser == true) { 
        $errors .= "- Istnieje gracz o podanym imieniu! Użyj innego! <br>";
    }
    
    $checkEmail2 = $register->exists_email($email, $db);
    if ($checkEmail2 == true) {
        $errors .= "- Podany adres e-mail jest w użyciu! Użyj innego! <br>";
    }
    
    if (!empty($errors)) { 
        echo json_encode(array("status" => "error", "message" => $errors));
        return;
    }

    if(!$checkUser && !$checkEmail2 && $checkEmail1 && $checkPass) {
        $tokenLength = 32;
        $token = bin2hex(random_bytes($tokenLength));
        $result = $register -> registerUser($token);
        if($result) { 
            $mail = sendActiveMail($email, $name, $token);
            if ($mail == true) {
                    $response = array("status" => "success", "message" => "Rejestracja udana! Potwierdź konto i zaloguj się!");
                echo json_encode($response);
            } else {
                // If not send mail
            }
        }
    } else {
        $errors[] = array("status" => "error", "message" => "Błąd rejestracji. Spróbuj ponownie później.");
        echo json_encode($errors);
        return;
    }
}

if(isset($_GET['token']))
{
    $token = $_GET['token'];
    $reg = new Register();
    $db = new Db();
    $conn = $db -> connect();
    $active = $reg->activeUser($token,$conn);
    if($active) {
        $_SESSION['info'] = 'Sukces aktywacji';
        header("Location: index.php"); 
    } else {
        $_SESSION['info'] = 'Aktywacja nie powiodła się!';
        header("Location: index.php"); 
    }
}

?>