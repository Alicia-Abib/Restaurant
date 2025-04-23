<?php
class DataBase {
    private $host = 'localhost';
    private $dbname = 'reservationdb';
    private $user = 'root';
    private $pass = '';
    public $pdo;

    public function getConnexion(){
        $this->pdo = null;
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
        return $this->pdo;
    }
}

$pdo = (new DataBase())->getConnexion();
?>


