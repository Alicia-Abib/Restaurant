<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/controleur.php';
require_once __DIR__ . '/../modeles/client.php';

class ClientControleur extends Controleur {

    private $client;

    public function __construct(){
        $this->client = new Client();
    }

    // afficher le formulaire de connexion/inscription
    public function login() : void {
        $this->view("client/login");
    }

    public function gererConnexion() : void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $pwd = $_POST['pwd'];

            if ($this->client->login($email, $pwd)) {
                session_start();
                $_SESSION['id_client'] = $this->client->id;
                $_SESSION['nom'] = $this->client->nom;
                $_SESSION['prenom'] = $this->client->prenom;
                $_SESSION['email'] = $this->client->email;
                header('Location: ?url=EspaceClient/dashboard');
                exit();
            } else {
                $error = "Email ou mot de passe incorrect.";
                $this->view('client/login', ['error' => $error]);
            }
        }
        
    }

    public function gererInscription() : void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $pwd = $_POST['pwd'];

            if ($this->client->inscription($nom, $prenom, $email, $pwd)) {
                $success = "Inscription réussie ! Connectez-vous.";
                $this->view('client/login', ['success' => $success]);
            } else {
                $error = "Cet email est déjà utilisé ou erreur lors de l'inscription.";
                $this->view('client/login', ['error' => $error]);
            }
        }
    }

    public function logout(): void {
        session_start();
        session_destroy();
        header("Location: ?url=Client/login");
    }

   
}

?>