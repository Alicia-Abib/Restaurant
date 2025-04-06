<?php

// Récupérer l’URL après /public/
$url = $_GET['url'] ?? 'Reservation/create';  // valeur par défaut si vide
$url = explode('/', $url);

// Extrait le nom du contrôleur et de la méthode
$controllerName = ucfirst($url[0]) . 'Controleur'; // ex: Reservation => ReservationControleur
$method = $url[1] ?? 'index';

// Chemin vers le contrôleur
$controllerPath = '../app/controleurs/' . $controllerName . '.php';

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controller = new $controllerName();

    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "❌ Méthode '$method' non trouvée dans $controllerName.";
    }
} else {
    echo "❌ Contrôleur '$controllerName' non trouvé.";
}
