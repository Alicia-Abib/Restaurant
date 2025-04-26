<?php
require_once __DIR__ . '/../Core/controleur.php';
require_once __DIR__ . '/../modeles/menu.php';


class HomeControleur extends Controleur {

    public function index(): void {
        // récupérer 3 plats aléatoires
        $menuItems = Menu::getMenusAleatoires(3);

        $data = [
            'menuItems' => $menuItems,
            'hist' => [
                'titre' => 'Notre Histoire',
                'contenu' => 'Fondé en 2010, notre restaurant apporte une touche moderne à la cuisine asiatique traditionnelle. Nos chefs, formés au Japon et en Chine, créent des plats authentiques avec des ingrédients locaux frais.'
            ],
            'quote' => [
                'texte' => 'When you drink the water, remember the spring',
                'auteur' => 'Yin Shui Si Yuan'
            ]
        ];
        $this->view('home', $data);
    }
}
?>