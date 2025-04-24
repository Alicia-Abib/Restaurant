<?php
require_once __DIR__.'/../modeles/menu.php';

class PanierControleur
{
    /* Afficher le panier */
    public function index(): void
    {
        session_start();
        $items = $_SESSION['cart'] ?? [];

        // Récupère les lignes complètes du menu pour les id en session
        $plats = [];
        $total = 0;
        foreach ($items as $id => $qty) {
            $plat = Menu::getById($id);
            if ($plat) {
                $plat['qty']   = $qty;
                $plat['soustot'] = $qty * $plat['prix'];
                $plats[] = $plat;
                $total  += $plat['soustot'];
            }
        }
        include __DIR__.'/../vues/panier.php';
    }

    /* Ajouter 1 exemplaire */
    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ?url=Menu/index'); return; }

        session_start();
        $id = (int)$_POST['id'];
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;

        header('Location: ?url=Panier/index');  // redirige vers le panier
    }

    /* Supprimer complètement un item */
    public function remove(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ?url=Panier/index'); return; }

        session_start();
        $id = (int)$_POST['id'];
        unset($_SESSION['cart'][$id]);

        header('Location: ?url=Panier/index');
    }

    /* Vider le panier */
    public function clear(): void
    {
        session_start();
        unset($_SESSION['cart']);
        header('Location: ?url=Panier/index');
    }
}
