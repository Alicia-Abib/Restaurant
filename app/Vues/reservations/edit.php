<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="css/disponibilites.css">
    <title>Modifier Réservation</title>
</head>
<body>
    <header>
        <div class="logo">Wok n’Roll</div>
        <nav>
            <ul>
                <li><a href="?url=Menu">Notre Menu</a></li>
                <li><a href="?url=Home">Accueil</a></li>
                <li><a href="?url=EspaceClient/dashboard" class="btn">Mon Espace</a></li>
                <li><a href="?url=Client/logout" class="btn">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <section class="section">
            <h1>Modifier Réservation</h1>

            <div class="form-group">
                <label for="date-reservation">Choisir une date :</label>
                <input type="date" id="date-reservation" name="date" value="<?php echo htmlspecialchars($reservation['date_reservation']); ?>">
                <button id="check-dispo" class="btn" style="margin-top: 0.5rem;">Vérifier les disponibilités</button>
            </div>

            <div id="resultats-dispos">
                <!-- Les disponibilitées affichées avec js -->
            </div>

            <form id="edit-form" method="POST" action="?url=Reservation/update">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($_SESSION['nom']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($_SESSION['prenom']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="date">Date :</label>
                    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($reservation['date_reservation']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="heure">Heure :</label>
                    <input type="time" id="heure" name="heure" value="<?php echo htmlspecialchars($reservation['heure']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nb_personnes">Nombre de personnes :</label>
                    <input type="number" id="nb_personnes" name="nb_personnes" min="1" value="<?php echo htmlspecialchars($reservation['nb_personnes']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="id_table">Table :</label>
                    <select id="id_table" name="id_table" disabled required>
                        <option value="<?php echo htmlspecialchars($reservation['id_table']); ?>" selected>Table <?php echo htmlspecialchars($reservation['id_table']); ?></option>
                    </select>
                </div>
                <div class="message-container" id="message-container"></div>
                <button type="submit" class="btn">Mettre à jour</button>
            </form>
        </section>
    </div>
    <script src="js/edit.js"></script>  
</body>
</html>