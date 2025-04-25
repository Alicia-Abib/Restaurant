<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/controleur.php';
require_once __DIR__ . '/../modeles/reservation.php';
require_once __DIR__ . '/../modeles/client.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
class ReservationControleur extends Controleur {

    public function index(): void {
        $reservations = Reservation::getAll();
        $this->view('reservations/index', ['reservations' => $reservations]);
    }

    public function create(): void {
        $this->view('reservations/create');
    }

    public function edit(): void{
        session_start();
        if (!isset($_SESSION['id_client'])) {
            header('Location: ?url=Client/login');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: ?url=EspaceClient/dashboard');
            exit;
        }

        $reservation = Reservation::getById($id);
        if (!$reservation || $reservation['id_client'] != $_SESSION['id_client']) {
            header('Location: ?url=EspaceClient/dashboard');
            exit;
        }

        $this->view('reservations/edit', ['reservation' => $reservation]);
    }

    public function store(): void {
        header('Content-Type: application/json');
        if ($_SERVER["REQUEST_METHOD"] !== "POST"){ 
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }

        session_start();
        $id_client = $_SESSION["id_client"] ?? null;
        
        // Récupérer les données du formulaire
        $nom = filter_var($_POST["nom"], FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_var($_POST["prenom"], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $date = $_POST["date"];
        $heure = $_POST["heure"];
        $nb_personnes = $_POST["nb_personnes"];
        $id_table = $_POST["id_table"];
    
        // Validation des données
        if (empty($nom) || empty($prenom) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($date) || empty($heure) || $nb_personnes <= 0 || $id_table <= 0) {
            echo json_encode(["success" => false , "message" =>"Veuillez remplir tous les champs correctement."]);
            exit;
        }
    
        // Vérification de la disponibilité de la table
        if (Reservation::checkTableAvailability($id_table, $date, $heure)) {
            echo json_encode(['success' => false, 'message' => "La table $id_table est déjà réservée à cette heure"]);
            exit;
        }

        // verifier si le client existe déjà 
        if(!$id_client){
            try {
                // si le client n'existe pas
                if (!Client::emailExists($email)) {
                    // Générer un mot de passe aléatoire
                    $mot_de_passe = $this->genererMotDePasse();
                    
                    // Créer un nouveau client
                    if (!Client::inscription($nom, $prenom, $email, $mot_de_passe)) {
                        echo json_encode(['success' => false, 'message' => "Erreur lors de la création du compte client."]);
                        exit;
                    }

                    // Récupérer l'ID du client nouvellement créé
                    $client = Client::getByEmail($email);
                    if (!$client) {
                        echo json_encode(['success' => false, 'message' => "Erreur lors de la récupération du compte client."]);
                        exit;
                    }
                    $id_client = $client['id'];
                    
                    // Envoyer l'email avec les informations de connexion
                    $this->sendCreationCompteEmail($email, $nom, $prenom, $mot_de_passe);
                } else {
                    // Client existant 
                    $client = Client::getByEmail($email);
                    if (!$client) {
                        echo json_encode(['success' => false, 'message' => "Erreur lors de la récupération du compte client existant."]);
                        exit;
                    }
                    $id_client = $client['id'];
                }
            } catch (Exception $e) {
                error_log("Erreur lors de la gestion du client: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => "Erreur lors de la gestion du compte client: " . $e->getMessage()]);
                exit;
            }
            
        }
    
        // Enregistrer la réservation
        try {
            Reservation::add($nom, $prenom, $date, $heure, $nb_personnes, $id_table, $email, $id_client);
    
            // Envoi de l'email de confirmation
            $this->sendConfirmationEmail($email, $nom, $prenom, $date, $heure, $nb_personnes, $id_table);
    
            echo json_encode([
                'success' => true,
                'message' => 'Réservation confirmée avec succès',
                //'redirect' => "?url=Reservation/confirmation&nom=".urlencode($nom)."&prenom=".urlencode($prenom)."&date=".urlencode($date)."&heure=".urlencode($heure)."&table=".$id_table."&nb_personnes=".$nb_personnes
            ]);
    
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement: '.$e->getMessage()]);
            }
            exit;
    }
    
    
    
    public function confirmation(): void {
        $nom = $_GET['nom'] ?? '';
        $prenom = $_GET['prenom'] ?? '';
        $date = $_GET['date'] ?? '';
        $heure = $_GET['heure'] ?? '';
        $table = $_GET['table'] ?? '';
        $nb = $_GET['nb_personnes'] ?? '';
    
        $this->view('reservations/confirmation', [
            'nom' => $nom,
            'prenom' => $prenom,
            'date' => $date,
            'heure' => $heure,
            'table' => $table,
            'nb_personnes' => $nb
        ]);
    }

    // méthode pour générer un mot de passe
    private function genererMotDePasse($longueur = 8){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
        $mdp = '';
        for($i = 0; $i < $longueur; $i++){
            $mdp .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $mdp;
    }
    
    // méthode pour envoyer l'email de création de compte
    private function sendCreationCompteEmail($email, $nom, $prenom, $mdp){
        // Charger les variables d'environnement
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    
        $mail = new PHPMailer(true);
    
        try {
            // Configurer le serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Destinataire et expéditeur
            $mail->setFrom($_ENV['GMAIL_USER'], 'Réservations Restaurant');
            $mail->addAddress($email);

            // Contenu HTML
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de votre réservation';
            $mail->Body = "
                <h2>Bonjour $prenom $nom,</h2>
                <p>Votre compte client a été créé avec succès. Voici les détails de connexion:</p>
                <ul>
                    <li><strong>Email : </strong> $email</li>
                    <li><strong>Mot de passe : </strong> $mdp</li>
                </ul>
                <p>Vous pouvez vous connectez à votre espace client pour gérer vos réservations : </p>
                <p><a href='?url=Client/login'>Se connecter</a></p>
                <p>À très bientôt !</p>
            ";
    
            $mail->send();
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
        }
    }

    // Méthode pour envoyer l'email de confirmation
    private function sendConfirmationEmail($email, $nom, $prenom, $date, $heure, $nb_personnes, $id_table): void {
        // Charger les variables d'environnement
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    
        $mail = new PHPMailer(true);
    
        try {
            // Configurer le serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Destinataire et expéditeur
            $mail->setFrom($_ENV['GMAIL_USER'], 'Réservations Restaurant');
            $mail->addAddress($email);

            // Contenu HTML
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de votre réservation';
            $mail->Body = "
                <h2>Bonjour $prenom $nom,</h2>
                <p>Merci pour votre réservation ! Voici les détails :</p>
                <ul>
                    <li><strong>Date :</strong> $date</li>
                    <li><strong>Heure :</strong> $heure</li>
                    <li><strong>Nombre de personnes :</strong> $nb_personnes</li>
                    <li><strong>Table n° :</strong> $id_table</li>
                </ul>
                <p>À très bientôt !</p>
            ";
    
            $mail->send();
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
        }
    }

    // Méthode pout envoyer l'email de confirmation de suppression 
    private function sendSupressionEmail($email, $nom, $prenom,$date, $heure, $nb_personnes, $id_table): void{
        // Charger les variables d'environnement
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $mail = new PHPMailer(true);

        try{
            // conf du serveur
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataire et expéditeur
            $mail->setFrom($_ENV['GMAIL_USER'], 'Réservations Restaurant');
            $mail->addAddress($email);
            
            // Contenu 
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de suppression de votre réservation';
            $mail->Body = "
                <h2>Bonjour $prenom $nom,</h2>
                <p>Votre réservation a été supprimée avec succès. Voici les détails de la réservation supprimée :</p>
                <ul>
                    <li><strong>Date :</strong> $date</li>
                    <li><strong>Heure :</strong> $heure</li>
                    <li><strong>Nombre de personnes :</strong> $nb_personnes</li>
                    <li><strong>Table n° :</strong> $id_table</li>
                </ul>
                <p>À très bientôt !</p>
                <p>Restauranteeeeee</p>
            ";
            $mail->send();
        }catch (Exception $e) {
            echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
        }
    }

    // méthode pour envoyer l'email de confirmation de modification
    private function sendModificationEmail($email, $nom, $prenom,$date, $heure, $nb_personnes, $id_table){
         // Charger les variables d'environnement
         $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
         $dotenv->load();
 
         $mail = new PHPMailer(true);
 
         try{
             // conf du serveur
             $mail->isSMTP();
             $mail->Host = 'smtp.gmail.com';
             $mail->SMTPAuth = true;
             $mail->Username = $_ENV['GMAIL_USER'];
             $mail->Password = $_ENV['GMAIL_PASS'];
             $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
             $mail->Port = 587;
 
             // Destinataire et expéditeur
             $mail->setFrom($_ENV['GMAIL_USER'], 'Réservations Restaurant');
             $mail->addAddress($email);
             
             // Contenu 
             $mail->CharSet = 'UTF-8';
             $mail->Encoding = 'base64';
             $mail->isHTML(true);
             $mail->Subject = 'Confirmation de mise à jour de réservation';
             $mail->Body = "
                 <h2>Bonjour $prenom $nom,</h2>
                 <p>Votre réservation a été mise à jour avec succès. Voici les nouveaux détails :</p>
                 <ul>
                     <li><strong>Date :</strong> $date</li>
                     <li><strong>Heure :</strong> $heure</li>
                     <li><strong>Nombre de personnes :</strong> $nb_personnes</li>
                     <li><strong>Table n° :</strong> $id_table</li>
                 </ul>
                 <p>À très bientôt !</p>
                 <p>Restauranteeeeee</p>
             ";
             $mail->send();
         }catch (Exception $e) {
             echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
         }
    }

    public function disponibilites(): void {
        $date = $_GET['date'] ?? date('Y-m-d');
    
        $disponibilites = Reservation::getDisponibilites($date);
    
        $this->view('reservations/disponibilites', [
            'disponibilites' => array_map(function ($item) {
                return [
                    'creneau' => $item['heure'],
                    'table' => $item['table'],
                    'statut' => $item['disponible'],
                    // Ajout des données brutes pour le JavaScript
                    'raw_heure' => $item['heure'],
                    'raw_table' => $item['table']
                ];
            }, $disponibilites),
            'date' => $date
        ]);
    }
    
    public function update(): void {
        session_start();
    
        header('Content-Type: application/json');

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }
        try{
            $id = (int)($_POST['id'] ?? 0);
            $nom = filter_var($_POST['nom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_var($_POST['prenom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $date = $_POST['date'] ?? '';
            $heure = $_POST['heure'] ?? '';
            $nb_personnes = (int)($_POST['nb_personnes'] ?? 0);
            $id_table = (int)($_POST['id_table'] ?? 0);
    
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'ID invalide']);
                exit; 
            }

            // vérifier que la réservation appartient au client
            $reservation = Reservation::getById($id);
            if(!$reservation || $reservation["id_client"] != $_SESSION["id_client"] || $reservation["email"] != $_SESSION["email"]) {
                echo json_encode(["success" => false, "message" => "Réservation non trouvée ou non autorisée"]);
                exit;
            }

            Reservation::update($id, $nom, $prenom, $date, $heure,$nb_personnes, $id_table, $email);
            
            // Envoyer l'email de confirmation
            $this->sendModificationEmail($email, $nom, $prenom, $date, $heure, $nb_personnes, $id_table);
            
            echo json_encode(['success' => true, 'message' => 'Réservation mise à jour avec succès']);
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur: '.$e->getMessage()]);            
        }
    }
    

    public function delete(): void {
        session_start();
        header('Content-Type: application/json');

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }
        $id = (int)$_POST['id'] ?? 0;
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID invalide']);
            exit; 
        }

        // vérfier que la réservation apartien au client
        $reservation = Reservation::getById($id);
        if(!$reservation || $reservation["id_client"] != $_SESSION["id_client"] || $reservation["email"] != $email) {
            echo json_encode(["success" => false, "message" => "Réservation non trouvée ou non autorisée"]);
            exit;
        }

        try {
            // récupérer les détail de la res avant la suppression
            $detailsRes = $reservation;
            Reservation::delete($id);
            // envoyer un email de confirmation de suppression
            $this->sendSupressionEmail(
                $email,
                $_SESSION['nom'],
                $_SESSION['prenom'],
                $detailsRes['date_reservation'],
                $detailsRes['heure'],
                $detailsRes['nb_personnes'],
                $detailsRes['id_table']
            );

            echo json_encode(['success' => true,'message' => 'Réservation supprimée',]);

            header('Location: ?url=EspaceClient/dashboard');
        }catch(Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur: '.$e->getMessage()]);
        }
        exit;

    }
    

    
    
    
    
}
