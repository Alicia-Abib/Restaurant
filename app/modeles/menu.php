<?php
require_once __DIR__ . '/../config/database.php';

class Menu {

    // Récupérer tous les plats
    public static function getAll(): array {
        global $pdo;  // Utilise la connexion à la base "menu"
        $sql = "SELECT menu.*, categories.nom AS category_name 
                FROM menu
                JOIN categories ON menu.category_id = categories.id
                ORDER BY menu.created_at DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getCategories(): array {
        global $pdo;
        return $pdo->query("SELECT id, nom FROM categories ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
    }

    // plats d’une catégorie donnée 
    public static function getByCategory(int $catId): array{
        global $pdo;
        $sql = "SELECT menu.*, categories.nom AS category_name
                FROM menu
                JOIN categories ON menu.category_id = categories.id
                WHERE menu.category_id = :cat
                ORDER BY menu.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cat' => $catId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Récupérer un plat par son id
    public static function getById(int $id): array {
        global $pdo;
        $sql = "SELECT * FROM menu WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([ ':id' => $id ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // récupérer 3 menus aléatoires pour l'accueil
    public static function getMenusAleatoires(int $limit){
        global $pdo;
        $sql = "SELECT menu.*, categories.nom AS nom_categorie
                FROM menu
                JOIN categories ON menu.category_id = categories.id
                ORDER BY RAND() LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
