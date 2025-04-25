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
    
    public static function getById($id){
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM clients WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByEmail($email){
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM clients WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data){
        global $pdo;
        try {
            $stmt = $pdo->prepare('UPDATE clients SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id');
            $stmt->execute([
                'id' => $id,
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email']
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Client Update Error: ' . $e->getMessage());
            throw $e;
        }
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

    public static function inscription($nom, $prenom, $email, $pwd) : bool {
        global $pdo;

        try{

            // vérifier si l'mail existe déjà
            $stmt = $pdo->prepare("SELECT id FROM clients WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            if ($stmt->rowCount() > 0) {
                return false;
            }

            $sql = "INSERT INTO clients (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)";
            $stmt = $pdo->prepare($sql);
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
        } catch(PDOException $e){
            error_log('Client Inscription Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function emailExists($email) : bool {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM clients WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->rowCount() > 0;
    }

    
}

?>