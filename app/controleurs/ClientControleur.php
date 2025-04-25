<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/controleur.php';
require_once __DIR__ . '/../modeles/client.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
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

    public function motDePasseOublie(){
        $this->view("client/login", ["action" => "motDePasseOublie"]);
    }

    public function envoyerCodeReinit(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view('client/login', [
                    'action' => 'motDePasseOublie',
                    'resetError' => 'Adresse email invalide.'
                ]);
                return;
            }

            if (!Client::emailExists($email)) {
                $this->view('client/login', [
                    'action' => 'motDePasseOublie',
                    'resetError' => 'Cet email n\'est pas associé à un compte.'
                ]);
                return;
            }

            try {
                $code = sprintf("%04d", random_int(0, 9999));
                Client::EnrgResetCode($email, $code);
                $this->sendResetCodeEmail($email, $code);

                header('Location: ?url=Client/login&action=verifierCode&email='.urlencode($email));
                exit();
            } catch (Exception $e) {
                error_log("Erreur: " . $e->getMessage());
                $this->view('client/login', [
                    'action' => 'motDePasseOublie',
                    'resetError' => 'Une erreur est survenue. Veuillez réessayer.'
                ]);
            }
        }
    }

    public function reinitMotDePasse(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $code = filter_var($_POST['code'], FILTER_SANITIZE_SPECIAL_CHARS);
            $new_pwd = $_POST['new_pwd'];
            $confirm_pwd = $_POST['confirm_pwd'];

            // Validation
            $errors = [];
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email invalide';
            }

            if (!preg_match('/^\d{4}$/', $code)) {
                $errors[] = 'Code invalide';
            }

            if ($new_pwd !== $confirm_pwd) {
                $errors[] = 'Les mots de passe ne correspondent pas';
            }


            if (!empty($errors)) {
                $this->view('client/login', [
                    'action' => 'verifierCode',
                    'email' => $email,
                    'resetError' => implode('<br>', $errors)
                ]);
                return;
            }

            try {
                if (!Client::verifierCode($email, $code)) {
                    throw new Exception("Code invalide ou expiré");
                }

                if (Client::updateMotDePasse($email, $new_pwd)) {
                    Client::supprimerResetCode($email);
                    $this->view('client/login', [
                        'success' => 'Mot de passe réinitialisé avec succès'
                    ]);
                } else {
                    throw new Exception("Échec de la mise à jour du mot de passe");
                }
            } catch (Exception $e) {
                error_log("Erreur: " . $e->getMessage());
                $this->view('client/login', [
                    'action' => 'verifierCode',
                    'email' => $email,
                    'resetError' => $e->getMessage()
                ]);
            }
        }
    }
    public function profile() {
        session_start();
        if(!isset($_SESSION["id_client"])){
            header("Location: ?url=Clinet/login");
            exit();
        }

        $client = Client::getById($_SESSION["id_client"]);
        if(!$client){
            session_destroy();
            header("Location: ?url=Client/login");
            exit();
        }
        $this->view("client/profile", ["client" => $client]);
    }

    public function update(): void {
        session_start();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }

        if (!isset($_SESSION['id_client'])) {
            echo json_encode(['success' => false, 'message' => 'Non connecté']);
            exit;
        }

        try {
            $id = (int)$_SESSION['id_client'];
            $nom = filter_var($_POST['nom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_var($_POST['prenom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

            if (empty($nom) || empty($prenom) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Données invalides']);
                exit;
            }

            // Check if email is already used by another client
            $existingClient = Client::getByEmail($email);
            if ($existingClient && $existingClient['id'] != $id) {
                echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé']);
                exit;
            }

            // Update client
            $updated = Client::update($id, [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email
            ]);

            if ($updated) {
                // Update session
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['email'] = $email;

                // Send confirmation email
                $this->sendModificationEmail($nom, $prenom, $email);

                echo json_encode([
                    'success' => true,
                    'message' => 'Profil mis à jour avec succès',
                    'redirect' => '?url=Client/profile'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Aucune modification effectuée']);
            }
        } catch (Exception $e) {
            error_log('Client Update Error: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    private function sendResetCodeEmail($email, $code){
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
        
            $mail->setFrom($_ENV['GMAIL_USER'], 'Restaurant');
            $mail->addAddress($email);
        
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = 'Code de réinitialisation de mot de passe';
            $mail->Body = "
                <h2>Réinitialisation de votre mot de passe</h2>
                <p>Vous avez demandé à réinitialiser votre mot de passe. Voici votre code de confirmation :</p>
                <p><strong>Code :</strong> $code</p>
                <p>Ce code est valide pendant 15 minutes.</p>
                <p>Si vous n'avez pas fait cette demande, ignorez cet email.</p>
                <p>L'équipe du Restaurant</p>>
            ";
        
            $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send profile update email to $email: " . $mail->ErrorInfo);
        }
    }
    private function sendModificationEmail($nom, $prenom, $email): void {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
        
            $mail->setFrom($_ENV['GMAIL_USER'], 'Restaurant');
            $mail->addAddress($email, "$prenom $nom");
        
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de mise à jour de votre profil';
            $mail->Body = "
                <h2>Confirmation de mise à jour</h2>
                <p>Cher(e) $prenom $nom,</p>
                <p>Votre profil a été mis à jour avec succès :</p>
                <ul>
                    <li><strong>Nom :</strong> $nom</li>
                    <li><strong>Prénom :</strong> $prenom</li>
                    <li><strong>Email :</strong> $email</li>
                </ul>
                <p>Merci de votre confiance !</p>
                <p>L'équipe du Restaurant</p>
            ";
        
            $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send profile update email to $email: " . $mail->ErrorInfo);
        }
    }

    public function logout(): void {
        session_start();
        session_destroy();
        header("Location: ?url=Client/login");
    }

   
}

?>