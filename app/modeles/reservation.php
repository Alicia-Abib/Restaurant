<?php
require_once __DIR__ . '/../config/database.php';

class Reservation {
    public static function getAll(): array {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM reservations ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($nom, $prenom, $date, $heure, $nb_personnes): void {
        global $pdo;
        $sql = "INSERT INTO reservations (nom, prenom, date_reservation, heure, nb_personnes)
                VALUES (:nom, :prenom, :date, :heure, :nb_personnes)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':date' => $date,
            ':heure' => $heure,
            ':nb_personnes' => $nb_personnes
        ]);
    }
}
