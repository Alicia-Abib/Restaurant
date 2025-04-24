<?php
require_once __DIR__ . '/../modeles/menu.php';

class MenuControleur {


    // Afficher un plat spécifique
    public function show($id): void {
        $plat = Menu::getById($id);  // Récupère un plat spécifique par son ID
        include __DIR__ . '/../vues/menu/show.php';  // Charge la vue show pour afficher les détails du plat
    }

    // Créer un plat (formulaire pour ajouter un plat)
    public function create(): void {
        include __DIR__ . '/../vues/menu/create.php';  // Charge la vue pour le formulaire de création de plat
    }

    // Ajouter un plat dans la base de données
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Méthode non autorisée";
            return;
        }
    
        $nom         = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        $prix        = filter_var($_POST['prix'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $categorie_id= (int)$_POST['categorie_id'];
        $image_url = null;
    
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    
            $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
            $finfo   = finfo_open(FILEINFO_MIME_TYPE);
            $mime    = finfo_file($finfo, $_FILES['image']['tmp_name']);
    
            if (!array_key_exists($mime, $allowed)) {
                echo "Format d’image non autorisé.";
                return;
            }
    
            $ext       = $allowed[$mime];
            $filename  = 'menu_' . uniqid() . '.' . $ext;
            $targetDir = __DIR__ . '/../../public/assets/img/';
            $target    = $targetDir . $filename;
    
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                echo "Erreur lors du déplacement du fichier.";
                return;
            }
    
            $image_url = 'assets/img/' . $filename;   // ← sans slash initial
        }
        /* -------------------------------------- */
    
        Menu::add($nom, $description, $prix, $categorie_id, $image_url);
        header('Location: ?url=Menu/index');
        exit;
    }




    public function index(): void
{
    $selectedCat = isset($_GET['cat']) ? (int)$_GET['cat'] : null;

    // Récupère soit tous les plats, soit ceux d’une catégorie
    $plats = $selectedCat
           ? Menu::getByCategory($selectedCat)
           : Menu::getAll();

    // On aura besoin de la liste des catégories pour le <select>
    $categories = Menu::getCategories();

    // On transmet tout à la vue
    include __DIR__ . '/../vues/home.php';
}

    public function update(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo 'Méthode non autorisée';
        return;
    }

    /*------------------ données textuelles ------------------*/
    $id          = (int) $_POST['id'];
    $nom         = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $prix        = filter_var($_POST['prix'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $categorie_id= (int) $_POST['categorie_id'];

    
    $image_url = $_POST['current_image'] ?? null;

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
        $mime    = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['image']['tmp_name']);

        if (!array_key_exists($mime, $allowed)) {
            echo 'Format d’image non autorisé';
            return;
        }

        $ext       = $allowed[$mime];
        $filename  = 'menu_' . uniqid() . '.' . $ext;
        $targetDir = __DIR__ . '/../../public/assets/img/';
        $target    = $targetDir . $filename;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo 'Erreur lors du déplacement du fichier';
            return;
        }

        $image_url = 'assets/img/' . $filename;   // ← sans slash initial
    }

    /*------------------ mise à jour -------------------------*/
    Menu::update($id, $nom, $description, $prix, $categorie_id, $image_url);

    header('Location: ?url=Menu/show/' . $id);
    exit;
}

    
}
