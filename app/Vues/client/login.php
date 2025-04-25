<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Connexion / Inscription</title>
</head>
<body>
    <header>
        <div class="logo">Restaurant</div>
        <nav>
            <ul>
                <li><a href="?url=Menu">Notre Menu</a></li>
                <li><a href="?url=Home">Accueil</a></li>
                <li><a href="?url=Reservation/create">Réserver</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <section class="section">
            <h1>Mon Espace</h1>

            <div class="form-group">
                <h2>Connexion</h2>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
                <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
                <form method="POST" action="?url=Client/gererConnexion">
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Mot de passe :</label>
                        <input type="password" id="pwd" name="pwd" required>
                    </div>
                    <button type="submit" class="btn">Se connecter</button>
                </form>
            </div>

            <div class="form-group">
                <h2>Inscription</h2>
                <form method="POST" action="?url=Client/gererInscription">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Mot de passe :</label>
                        <input type="password" id="pwd" name="pwd" required>
                    </div>
                    <button type="submit" class="btn">S'inscrire</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>