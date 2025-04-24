<?php
require_once __DIR__ . '/../modeles/menu.php'; 

class ApiControleur {
    public function menu(): void { // méthode minuscule
        $plats = Menu::getAll(); // Récupère tous les plats du menu
        header('Content-Type: application/json');
        echo json_encode($plats); // Retourne les plats au format JSON
    }
}
