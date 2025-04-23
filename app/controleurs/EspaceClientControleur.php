<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/controleur.php';
require_once __DIR__ . '/../modeles/reservation.php';

class EspaceClientControleur extends Controleur {

    private $reservation;

    public function __construct() {
        $this->reservation = new Reservation();
    }

    // Afficher le tableau de bord client
    public function dashboard(): void {
        session_start();
        if (!isset($_SESSION['id_client'])) {
            header('Location: ?url=Client/login');
            exit();
        }

        $reservations = Reservation::getByEmail($_SESSION['email']);
        $this->view('client/dashboard', [
            'reservations' => $reservations,
            'email' => $_SESSION['email']
        ]);
    }

    // Supprimer une réservation
    public function supprimerReservation(): void {
        session_start();
        if (!isset($_SESSION['id_client'])) {
            header('Location: ?url=Client/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $email = filter_var($_SESSION['email'], FILTER_SANITIZE_EMAIL);

            try {
                Reservation::delete($id);
                echo json_encode([
                    'success' => true,
                    'message' => 'Réservation supprimée',
                    'redirect' => "?url=EspaceClient/dashboard"
                ]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
            }
            exit();
        }
    }
}
?>