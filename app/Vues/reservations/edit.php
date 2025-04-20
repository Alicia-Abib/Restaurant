<h2>Modifier la réservation</h2>

<form method="POST" action="?url=Reservation/update">
    <input type="hidden" name="id" value="<?= $reservation['id'] ?>">

    <label>Nom :</label>
    <input type="text" name="nom" value="<?= $reservation['nom'] ?>" required><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" value="<?= $reservation['prenom'] ?>" required><br>

    <label>Email :</label>
    <input type="email" name="email" value="<?= $reservation['email'] ?>" required><br>

    <label>Date :</label>
    <input type="date" name="date" value="<?= $reservation['date_reservation'] ?>" required><br>

    <label>Heure :</label>
    <input type="time" name="heure" value="<?= $reservation['heure'] ?>" required><br>

    <label>Nombre de personnes :</label>
    <input type="number" name="nb_personnes" value="<?= $reservation['nb_personnes'] ?>" min="1" required><br>

    <label>Table :</label>
    <select name="id_table">
        <option value="1" <?= $reservation['id_table'] == 1 ? 'selected' : '' ?>>Table 1</option>
        <option value="2" <?= $reservation['id_table'] == 2 ? 'selected' : '' ?>>Table 2</option>
        <option value="3" <?= $reservation['id_table'] == 3 ? 'selected' : '' ?>>Table 3</option>
    </select><br>

    <button type="submit">Enregistrer les modifications</button>
</form>
