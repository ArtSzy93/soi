<?php 
// Plik zawiera dane do połaczenia z DB
require 'config.php';

class Db{
    public $host;
    private $user;
    private $pass;
    private $db;
    public function __construct() {
        global $HOST, $DBNAME, $DBUSER, $DBPASS;
        $this->host = $HOST;
        $this->user = $DBUSER;
        $this->pass = $DBPASS;
        $this->db = $DBNAME;
    }

    public function connect() {
        try {
            $HOST = $this->host;
            $DBNAME = $this->db;
            $DBPASS = $this->pass;
            $DBUSER = $this->user;
            $conn = new PDO("mysql:host=$HOST;dbname=$DBNAME", $DBUSER, $DBPASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Błąd połączenia: " . $e->getMessage());
        }

    }
}


try {
    global $HOST, $DBNAME, $DBUSER, $DBPASS;
    $conn = new PDO("mysql:host=$HOST;dbname=$DBNAME", $DBUSER, $DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Błąd połączenia: " . $e->getMessage());
}

?>