<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$mail = new PHPMailer(true);
$mail->SMTPDebug = 2; // Mets à 0 en prod pour ne pas afficher trop d'infos

// Configurer PHPMailer
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = $_ENV['GMAIL_USER'];
$mail->Password = $_ENV['GMAIL_PASS'];
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Définir le message
$mail->setFrom($_ENV['GMAIL_USER'], 'Nom de ton application');
$mail->addAddress($email);
$mail->Subject = 'Confirmation de réservation';
$mail->Body = "Bonjour $prenom $nom,\n\nNous avons bien enregistré votre réservation pour le $date à $heure pour $nb_personnes personne(s).";

// Envoyer l’email
if ($mail->send()) {
    echo ' Message envoyé';
} else {
    echo ' Erreur lors de l\'envoi: ' . $mail->ErrorInfo;
}
?>
