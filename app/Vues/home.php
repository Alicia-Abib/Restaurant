<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <title>Home</title>
</head>

<body>
    <header>
        <div class="logo">Restaurant</div>
        <nav>
            <ul>
                <li><a href="?url=Menu/index">Notre Menu</a></li>
                <li><a href="?url=Reservation/create">Réservé</a></li>
                <?php if(isset($_SESSION["id_client"])): ?>
                    <li><a href="?url=EspaceClient/dashboard" class="btn">Mon Espace</a></li>
                    <li><a href="?url=Client/logout" class="btn">Déconnexion</a></li>
                <?php else:?>
                    <li><a href="?url=Client/login" class="btn">Mon Espace</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="intro">
        <h1>Le Goût de l'Est</h1>
        <p>I will say something here later</p>
        <a href="?url=Reservation/create" class="cta-button"> Réservation une table</a>
    </section>

    <!--Ajouter que 3 item de la base de données aléatoirement avec JS-->
    <section class="menu-preview">
        <h2>Nos Spécialités</h2>
        <div class="menu-item" id="menu-preview"></div>
        <a href="?url=Menu/index" id="see-more">Voir tout le menu ></a>
    </section>

    <!-- Ajouter un petit text d'histoire-->
    <section class="hist">
        <!--Ajouter l'image avec CSS-->
        <div class="hist-img"></div>
        <div class="hist-text">
        <h2><?= htmlspecialchars($hist['titre']) ?></h2>
        <p><?= htmlspecialchars($hist['contenu']) ?></p>
        </div>
    </section>

    <section class="quote">
        <div class="quote-text">
            <blockquote>"<?= htmlspecialchars($quote['texte']) ?>"</blockquote>
            <p class="author">- <?= htmlspecialchars($quote['auteur']) ?></p>
        </div>
        <div class="quote-img">
            <!--Image avec CSS-->
        </div>
    </section>

    <footer>
        <div class="footer-logo">Restaurant</div>
    </footer>

    <script src="js/home.js"></script>
</body>

</html>