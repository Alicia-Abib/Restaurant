<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Connexion / Inscription</title>
</head>
<body>
    <?php 
    // En haut du fichier, après l'ouverture du <body>
    if (isset($_SESSION['reset_success'])): ?>
    <div class="success-message">
        <?= htmlspecialchars($_SESSION['reset_success']) ?>
        <?php unset($_SESSION['reset_success']); ?>
    </div>
    <?php endif; ?>
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
            <?php if (isset($_GET['action']) && $_GET['action'] === 'motDePasseOublie'): ?>
                <div class="form-group">
                    <h2>Réinitialiser le mot de passe</h2>
                    <?php if (isset($resetError)) echo "<p class='error'>$resetError</p>"; ?>
                    <form method="POST" action="?url=Client/envoyerCodeReinit">
                        <div class="form-group">
                            <label for="reset-email">Email :</label>
                            <input type="email" id="reset-email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                        <button type="submit" class="btn">Envoyer le code</button>
                    </form>
                </div>
            <?php elseif (isset($_GET['action']) && $_GET['action'] === 'verifierCode'): ?>
                <div class="form-group">
                    <h2>Réinitialisation du mot de passe</h2>
                    <?php if (isset($resetError)) echo "<p class='error'>$resetError</p>"; ?>
                    <?php if (isset($resetSuccess)) echo "<p class='success'>$resetSuccess</p>"; ?>
                    <form method="POST" action="?url=Client/reinitMotDePasse">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
                        <div class="form-group">
                            <label for="code">Code de vérification :</label>
                            <input type="text" id="code" name="code" required maxlength="4" pattern="\d{4}">
                        </div>
                        <div class="form-group">
                            <label for="new-pwd">Nouveau mot de passe :</label>
                            <input type="password" id="new-pwd" name="new_pwd">
                        </div>
                        <div class="form-group">
                            <label for="confirm-pwd">Confirmez le mot de passe :</label>
                            <input type="password" id="confirm-pwd" name="confirm_pwd">
                        </div>
                        <button type="submit" class="btn">Réinitialiser</button>
                    </form>
                </div>
            <?php else: ?>
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
                        <p><a href="?url=Client/motDePasseOublie&action=motDePasseOublie" class="mdp-oublie">Mot de passe oublié ?</a></p>
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
            <?php endif; ?>
        </section>
    </div>
</body>
</html>