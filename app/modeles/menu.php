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


    /*  A. toutes les catégories  ---------------------------------- */
public static function getCategories(): array
{
    global $pdo;
    return $pdo->query("SELECT id, nom FROM categories ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
}

/*  B. plats d’une catégorie donnée  --------------------------- */
public static function getByCategory(int $catId): array
{
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
    
    // Ajouter un plat
    public static function add($nom, $description, $prix, $category_id,$image_url = null): void {
        global $pdo;
        $sql = "INSERT INTO menu (nom, description, prix, category_id, image_url) 
                VALUES (:nom, :description, :prix, :category_id, :image_url)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':category_id' => $category_id,
            ':image_url' => $image_url

        ]);
    }

    // Modifier un plat
    // app/modeles/menu.php
public static function update($id, $nom, $description, $prix, $category_id, $image_url = null): void
{
    global $pdo;
    $sql = "UPDATE menu
            SET nom          = :nom,
                description  = :description,
                prix         = :prix,
                category_id  = :category_id,
                image_url    = :image_url
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id'          => $id,
        ':nom'         => $nom,
        ':description' => $description,
        ':prix'        => $prix,
        ':category_id' => $category_id,
        ':image_url'   => $image_url
    ]);
}

    // Supprimer un plat
    public static function delete($id): void {
        global $pdo;
        $sql = "DELETE FROM menu WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
?>
