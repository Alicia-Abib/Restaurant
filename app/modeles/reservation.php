<?php
require_once __DIR__ . '/../config/database.php';

class Reservation {

    public static function checkTableAvailability($id_table, $date, $heure): bool {
        global $pdo;
        // Ajouter une comparaison plus stricte en incluant la date et l'heure
        $sql = "SELECT * FROM reservations 
                WHERE id_table = :id_table 
                AND date_reservation = :date 
                AND heure = :heure";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_table' => $id_table,
            ':date' => $date,
            ':heure' => $heure
        ]);
    
        // Si une réservation existe pour cette table à la même heure, la table est déjà réservée
        return $stmt->rowCount() > 0;
    }
    
    
    public static function getAll(): array {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM reservations ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($nom, $prenom, $date, $heure, $nb_personnes, $id_table, $email, $id_client = null): void {
        global $pdo;
        // On n'inclut pas 'id' et 'created_at' car elles sont gérées automatiquement (auto_increment et valeur par défaut)
        $sql = "INSERT INTO reservations (nom, prenom, date_reservation, heure, nb_personnes, id_table, email, id_client)
                VALUES (:nom, :prenom, :date, :heure, :nb_personnes, :id_table, :email, :id_client)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':date' => $date,
            ':heure' => $heure,
            ':nb_personnes' => $nb_personnes,
            ':id_table' => $id_table,
            ':email' => $email, 
            ':id_client' => $id_client
        ]);
    }
    
    public static function getDisponibilites(string $date): array {
        global $pdo;
    
        $plages = [
            ['heure' => '12:00'], ['heure' => '13:00'], ['heure' => '14:00'],
            ['heure' => '19:00'], ['heure' => '20:00'], ['heure' => '21:00'],
        ];
    
        $tables = [1, 2, 3, 4];
    
        $stmt = $pdo->query("SELECT date_reservation AS date, heure, id_table FROM reservations");
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $disponibilites = [];
        $heure_courante = time(); // timestamp
        $aujourhui = date('Y-m-d');
    
        foreach ($plages as $plage) {
            $heure = strtotime("$date {$plage['heure']}");

            // supprimer les créneaux passés pour aujourd'hui
            if($date === $aujourhui && $heure < $heure_courante){
                continue; // ignorer le créneau
            }

            foreach ($tables as $table) {
    
                $deja_reservee = array_filter($reservations, function($r) use ($heure, $table, $date) {
                    if ($r['date'] !== $date) return false;
                    if ($r['id_table'] != $table) return false;
    
                    $res_start = strtotime("{$r['date']} {$r['heure']}");
                    $res_end = $res_start + 3600;

                    $fin_heure = $heure + 3600;
    
                    return $res_start < $fin_heure && $res_end > $heure;
                });
    
                $disponibilites[] = [
                    'heure' => $plage['heure'],
                    'table' => $table,
                    'disponible' => empty($deja_reservee)
                ];
            }
        }
    
        return $disponibilites;
    }
    

    public static function getByEmail(string $email): array {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM reservations WHERE email = :email ORDER BY date_reservation DESC, heure ASC");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getById(int $id){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function update($id, $nom, $prenom, $date, $heure, $nb_personnes, $id_table, $email): void {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE reservations SET nom = :nom, prenom = :prenom, date_reservation = :date, heure = :heure, nb_personnes = :nb_personnes, id_table = :id_table, email = :email WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'date' => $date,
            'heure' => $heure,
            'nb_personnes' => $nb_personnes,
            'id_table' => $id_table,
            'email' => $email
        ]);
    }
    
    public static function delete($id): void {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
    
    
}
