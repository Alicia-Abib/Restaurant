<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Mon Espace Client</title>
</head>
<body>
    <header>
        <div class="logo">Wok n’Roll</div>
        <nav>
            <ul>
                <li><a href="?url=Menu">Notre Menu</a></li>
                <li><a href="?url=Home">Accueil</a></li>
                <li class="menu">
                    <button class="btn toggle"><?php echo htmlspecialchars($_SESSION["prenom"])?>▼</button>
                    <ul class="menu-drop">
                        <li><a href="?url=Client/profile" class="menu-item">Mon Profil</a></li>
                        <li><a href="?url=Client/logout" class="menu-item">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <section class="section">
            <h1>Mes Réservations</h1>
            <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?> !</p>

            <?php if (!empty($reservations)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Personnes</th>
                            <th>Table</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reservation['date_reservation']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['heure']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['nb_personnes']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['id_table']); ?></td>
                                <td>
                                    <a href="?url=Reservation/edit&id=<?php echo $reservation['id']; ?>" class="btn">Modifier</a>
                                    <form method="POST" action="?url=Reservation/delete" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $reservation['id']; ?>">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                                        <button type="submit" class="btn btn-delete">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune réservation trouvée.</p>
            <?php endif; ?>

            <a href="?url=Reservation/create" class="btn">Faire une nouvelle réservation</a>
        </section>
    </div>
    <script src="js/dashboard.js"></script>
</body>
</html>