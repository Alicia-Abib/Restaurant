<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <title>Mon Profil</title>
</head>
<body>
    <header>
        <div class="logo">Wok n’Roll</div>
        <nav>
            <ul>
                <li><a href="?url=Menu">Notre Menu</a></li>
                <li><a href="?url=Home">Accueil</a></li>
                <li class="dropdown">
                    <button class="btn dropdown-toggle"><?php echo htmlspecialchars($_SESSION['prenom']); ?> ▼</button>
                    <ul class="dropdown-menu">
                        <li><a href="?url=EspaceClient/dashboard" class="dropdown-item">Mes réservations</a></li>
                        <li><a href="?url=Client/logout" class="dropdown-item">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <section class="section">
            <h1>Mon Profil</h1>
            <p>Modifier vos informations personnelles.</p>
            <form id="profile-form" method="POST" action="?url=Client/update">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($client['nom']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($client['prenom']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>
                </div>
                <div class="message-container" id="message-container"></div>
                <button type="submit" class="btn">Mettre à jour</button>
            </form>
        </section>
        <section class="section" style="margin-top: 2rem;">
            <h2>Changer le mot de passe</h2>
            <form id="change-password-form" method="POST" action="?url=Client/changerMotDePasse">
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel :</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="message-container" id="password-message-container"></div>
                <button type="submit" class="btn">Changer le mot de passe</button>
            </form>
        </section>
    </div>
    <script src="js/profile.js"></script>
</body>
</html>