<?php 
require_once './config/db.php';

// Register new player
class Register {
    private $name;
    private $email;
    private $password;
    private $emailVerified;
    private $passwordVerified;
    private $db;

    public function __construct($name = null, $email = null, $emailVerified = null, $password = null, $passwordVerified = null, $db = null) {
        $this->name = $name;
        $this->email = $email;
        $this->emailVerified = $emailVerified;
        $this->password = $password;
        $this->passwordVerified = $passwordVerified;
        $this->emailVerified = $emailVerified;
        $this->db = $db;
    }

    public function checkEmail() {
        if ($this->emailVerified != $this -> email) {
            return false;
        }
        return true;
     }

     public function exists_email($email, $db) {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return true;
        }
        return false;
     }

     public function exists_user($user, $db) {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :user LIMIT 1");
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return true;
        }
        return false;
      }


     public function checkPassword() {
        if ($this ->passwordVerified != $this -> password) {
            return false;
        }
        // Lenght 8 characters
        if (strlen($this -> password) < 8){
            return false;
        }
        return true;
    }

    public function registerUser($token) {
        $db = $this->db;
        $password = $this->password;
        $username = $this ->name;
        $email = $this -> email;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $rank = "Podróżnik"; // Ranga nadawana automatycznie podczas rejestracji nowego usera.
        // Zapisanie użytkownika do bazy danych
        try {
          $stmt = $db ->prepare("INSERT INTO users (username, rank, email, password, dataDolaczenia, active_code) VALUES (:username, :rank, :email, :password, NOW(), :code)");
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

    public function activeUser($token, $db) {
        try {
            $stmt = $db->prepare("SELECT id, active, active_code FROM users WHERE active_code = :code LIMIT 1");
            $stmt->bindParam(':code', $token,PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();

            if($result > 0)
            {
                $stmt = $db->prepare("UPDATE users SET active = 1, active_code = '' WHERE id = :id");
                $stmt->bindParam(':id', $result['id'],PDO::PARAM_INT);
                $stmt->execute();
                return true;
            } else {
                return false;
            }
           } catch (PDOException $e) {
            die("Błąd połączenia: " . $e->getMessage());
        }
    }

}






?>