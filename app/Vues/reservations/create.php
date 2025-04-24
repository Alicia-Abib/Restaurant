<?php
session_start(); // Start session to access $_SESSION
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/create.css">
    <link rel="stylesheet" href="css/disponibilites.css">
    <title>Réservation</title>
</head>
<body>
    <header>
        <div class="logo">Restaurant</div> <!-- Ajouter un logo cliquable vers le home -->
        <nav>
            <ul>
                <li><a href="?url=Menu">Notre Menu</a></li>
                <li><a href="?url=Home">Accueil</a></li>
                <?php if(isset($_SESSION["id_client"])): ?>
                    <li><a href="?url=EspaceClient/dashboard" class="btn">Mon Espace</a></li>
                    <li><a href="?url=Client/logout" class="btn">Déconnexion</a></li>
                <?php else:?>
                    <li><a href="?url=Client/login" class="btn">Mon Espace</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <section class="section">
            <h1>Disponibilités des tables</h1>
            
            <div class="form-group">
                <label for="date-reservation">Choisir une date :</label>
                <input type="date" id="date-reservation" name="date">
                <button id="check-dispo" class="btn" style="margin-top: 0.5rem;">Vérifier les disponibilités</button>
            </div>
            
            <div id="resultats-dispos">
                <!-- Les résultats seront affichés ici via JavaScript -->
            </div>
        </section>

        <section class="section" id="reservation-form">
            <h2>Réserver une table</h2>
            
            <form id="booking-form" method="POST">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value="<?php echo isset($_SESSION['nom']) ? htmlspecialchars($_SESSION['nom']) : ''; ?>" required 
                    <?php echo isset($_SESSION["id_client"]) ? "readonly" : "";?>>
                </div>
                
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo isset($_SESSION['prenom']) ? htmlspecialchars($_SESSION['prenom']) : ''; ?>" required
                    <?php echo isset($_SESSION["id_client"]) ? "readonly" : ""; ?>>
                </div>
                
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required
                    <?php echo isset($_SESSION["id_client"]) ? "readonly" : ''; ?>>
                </div>
                
                <div class="form-group">
                    <label for="date">Date :</label>
                    <input type="date" id="date" name="date" disabled required>
                </div>
                
                <div class="form-group">
                    <label for="heure">Heure :</label>
                    <input type="time" id="heure" name="heure" disabled required>
                </div>
                
                <div class="form-group">
                    <label for="nb_personnes">Nombre de personnes :</label>
                    <input type="number" id="nb_personnes" name="nb_personnes" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="id_table">Table :</label>
                    <select id="id_table" name="id_table" disabled required>
                        <option value="">Sélectionnez une table disponible</option>
                    </select>
                </div>
                
                <div class="recap" id="reservation-recap">
                    <h3>Récapitulatif</h3>
                    <ul>
                        <li><strong>Date :</strong> <span id="recap-date">Non sélectionnée</span></li>
                        <li><strong>Heure :</strong> <span id="recap-time">Non sélectionnée</span></li>
                        <li><strong>Table :</strong> <span id="recap-table">Non sélectionnée</span></li>
                    </ul>
                </div>
                
                <div class="message-container" id="message-container"></div>
                <button type="submit" class="btn">Confirmer la réservation</button>
            </form>
        </section>
    </div>
    <script src="js/create.js"></script>
</body>
</html>