<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/controleur.php';
require_once __DIR__ . '/../modeles/reservation.php';

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


    public function store(): void {
        header('Content-Type: application/json');
        if ($_SERVER["REQUEST_METHOD"] !== "POST"){ 
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }
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
    
        // Enregistrer la réservation
        try {
            Reservation::add($nom, $prenom, $date, $heure, $nb_personnes, $id_table, $email);
    
            // Envoi de l'email de confirmation
            $this->sendConfirmationEmail($email, $nom, $prenom, $date, $heure, $nb_personnes, $id_table);
    
            echo json_encode([
                'success' => true,
                'message' => 'Réservation confirmée avec succès',
                'redirect' => "?url=Reservation/confirmation&nom=".urlencode($nom)."&prenom=".urlencode($prenom)."&date=".urlencode($date)."&heure=".urlencode($heure)."&table=".$id_table."&nb_personnes=".$nb_personnes
            ]);
    
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement: '.$e->getMessage()]);
            }
            exit;
    }
    
    public function mesReservations(): void {
        $email = $_GET['email'] ?? '';
    
        if (empty($email)) {
            $this->view('reservations/monespace');
            return;
        }
    
        $reservations = Reservation::getByEmail($email);
        $this->view('reservations/mesreservations', [
            'reservations' => $reservations,
            'email' => $email
        ]);
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
            // Tu peux logguer ici si besoin : echo 'Message envoyé !';
        } catch (Exception $e) {
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
    
    public function edit(): void {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            echo "ID manquant.";
            return;
        }
    
        $reservation = Reservation::getById($id);
    
        if (!$reservation) {
            echo "Réservation introuvable.";
            return;
        }
    
        $this->view('reservations/edit', ['reservation' => $reservation]);
    }
    
    public function update(): void {
        header('Content-Type: application/json');
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }
        try{
            $id = $_POST['id'];
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $email = $_POST["email"];
            $date = $_POST["date"];
            $heure = $_POST["heure"];
            $nb_personnes = $_POST["nb_personnes"];
            $id_table = $_POST["id_table"];
    
            if(empty($id) || empty($nom) || empty($prenom) || !filter_var($email, FILTER_VALIDATE_EMAIL) || 
            empty($date) || empty($heure) || $nb_personnes <= 0 || $id_table <= 0) {
                echo json_encode(['success' => false, 'message' => 'Données invalides']);
                exit;
            }
            Reservation::update($id, $nom, $prenom, $date, $heure, $nb_personnes, $id_table, $email);
            echo json_encode([
                'success' => true,
                'message' => 'Réservation mise à jour avec succès',
                'redirect' => "?url=Reservation/mesReservations&email=".urlencode($email)
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur: '.$e->getMessage()]);            
        }
    }
    

    public function delete(): void {
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

        try {
            Reservation::delete($id);
            echo json_encode([
                'success' => true,
                'message' => 'Réservation supprimée',
                'redirect' => "?url=Reservation/mesReservations&email=".urlencode($email)
            ]);
        }catch(Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur: '.$e->getMessage()]);
        }
        exit;

    }
    
    
    
    
    
}
