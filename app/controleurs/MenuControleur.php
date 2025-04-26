<?php
require_once __DIR__ . '/../Core/controleur.php';
require_once __DIR__ . '/../modeles/menu.php';

class MenuControleur
{
    public function show($id): void {
        $plat = Menu::getById($id);
        include __DIR__ . '/../vues/menu/show.php';
    }

    public function apiMenu(): void {
        $selectedCat = isset($_GET['cat']) ? (int)$_GET['cat'] : null;
        
        $plats = $selectedCat
            ? Menu::getByCategory($selectedCat)
            : Menu::getAll();

        $plats = array_map(function($plat) {
            $plat['prix'] = (float)$plat['prix'];
            return $plat;
        }, $plats);

        header('Content-Type: application/json');
        echo json_encode([
            'plats' => $plats,
            'categories' => Menu::getCategories()
        ]);
    }

    public function index(): void{
        $selectedCat = isset($_GET['cat']) ? (int)$_GET['cat'] : null;

        $plats = $selectedCat
            ? Menu::getByCategory($selectedCat)
            : Menu::getAll();

        $categories = Menu::getCategories();

        include __DIR__ . '/../Vues/menu/menu.php';
    }
}