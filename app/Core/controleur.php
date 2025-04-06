<?php
class Controleur {

    // Méthode pour charger une vue
    protected function view($vue, $data = []) {
        extract($data); 
        require_once __DIR__ . '/../Vues/' . $vue . '.php';
    }

}

