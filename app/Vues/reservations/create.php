<h2>Réserver une table</h2>

<form method="POST" action="?url=Reservation/store">


    <label>Nom :</label>
    <input type="text" name="nom" required><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" required><br>

    <label>Date :</label>
    <input type="date" name="date" required><br>

    <label>Heure :</label>
    <input type="time" name="heure" required><br>

    <label>Nombre de personnes :</label>
    <input type="number" name="nb_personnes" min="1" required><br>

    <button type="submit">Réserver</button>
</form>
