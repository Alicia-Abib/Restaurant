<?php
require_once __DIR__ . '/../core/controleur.php';
require_once __DIR__ . '/../modeles/reservation.php';

class ReservationControleur extends Controleur {

    public function index(): void {
        $reservations = Reservation::getAll();
        $this->view('reservations/index', ['reservations' => $reservations]);
    }

    public function create(): void {
        $this->view('reservations/create');
    }

    public function store(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $date = $_POST["date"];
            $heure = $_POST["heure"];
            $nb_personnes = $_POST["nb_personnes"];

            Reservation::add($nom, $prenom, $date, $heure, $nb_personnes);

            header("Location: ?url=Reservation/confirmation");

            exit;
        }
    }

    public function confirmation(): void {
        $this->view('reservations/confirmation');
    }
}
