<?php
require_once __DIR__ . "/../config/database.php";
class Client {
    private $pdo;
    private $nom_table = "clients";

    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $pwd;

    public function __construct(){
        global $pdo;
        $this->pdo = $pdo;
    }
    
    public function login ($email, $pwd): bool {
        $sql =  "SELECT id, nom, prenom, email, mdp FROM " . $this->nom_table . " WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["email" => $email]);

        if($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($pwd, $row["mdp"])) {
                $this->id = $row["id"];
                $this->nom = $row['nom'];
                $this->prenom = $row['prenom'];
                $this->email = $row['email'];
                return true;
            }
        }
        return false;
    }

    public function inscription($nom, $prenom, $email, $pwd) : bool {
        if($this->emailExists($email)){
            return false;
        }

        $sql = "INSERT INTO " . $this->nom_table . " (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)";
        $stmt = $this->pdo->prepare($sql);

        $nom = filter_var($nom, FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_var($prenom, FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $pwd = password_hash($pwd, PASSWORD_BCRYPT);

        $stmt->execute([
            "nom"=> $nom,
            "prenom"=> $prenom,
            "email"=> $email,
            "mdp" => $pwd
        ]);

        return $stmt->rowCount() > 0;
    }

    public function emailExists($email) : bool {
        $sql = "SELECT id FROM " . $this->nom_table . " WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["email" => $email]);
        return $stmt->rowCount() > 0;
    }
}

?>