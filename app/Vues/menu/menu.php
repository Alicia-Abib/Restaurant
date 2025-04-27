<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/menu.css">
    <title>Menu</title>
</head>
<body>
    <header class="menu-header">
        <div class="logo">Wok n’Roll
        </div>
        <nav>
            <ul>
                <li><a href="?url=Home">Accueil</a></li>
                <li><a href="?url=Reservation/create">Réserver</a></li>
                <?php if(isset($_SESSION["id_client"])): ?>
                    <li><a href="?url=EspaceClient/dashboard" class="btn">Mon Espace</a></li>
                    <li><a href="?url=Client/logout" class="btn">Déconnexion</a></li>
                <?php else:?>
                    <li><a href="?url=Client/login" class="btn">Mon Espace</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
        <div class="menu-container">
            <h1>Notre Menu</h1>
            <div class="filtre_categorie">
                <form method="GET" action="?url=Menu/index">
                    <select id="select-categorie">
                        <option value="">Toutes les catégories</option>
                        <!--options ajoutées avec js-->
                    </select>
                </form>
            </div>
            <div class="menu-grid" id="menu-grid">
                 <!--contenu ajoutées dynamiquement avec js-->
            </div>
        </div>
    
    <script src="js/menu.js"></script>
</body>
</html>