<?php
$date = $_GET['date'] ?? '';
$heure = $_GET['heure'] ?? '';
$table = $_GET['table'] ?? '';
?>

<h2>Réserver une table</h2>

<form method="POST" action="?url=Reservation/store">

    <label>Nom :</label>
    <input type="text" name="nom" required><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" required><br>

    <label>Email :</label>
    <input type="email" name="email" required><br> 

    <label>Date :</label>
    <input type="date" value="<?= htmlspecialchars($date) ?>" disabled><br>
    <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">

    <label>Heure :</label>
    <input type="time" value="<?= htmlspecialchars($heure) ?>" disabled><br>
    <input type="hidden" name="heure" value="<?= htmlspecialchars($heure) ?>">

    <label>Nombre de personnes :</label>
    <input type="number" name="nb_personnes" min="1" required><br>

    <label>Table :</label>
    <select disabled>
        <option><?= htmlspecialchars($table) ?></option>
    </select><br>
    <input type="hidden" name="id_table" value="<?= htmlspecialchars(preg_replace('/\D/', '', $table)) ?>">

    <h3>🧾 Récapitulatif</h3>
    <ul>
        <li><strong>Date :</strong> <?= htmlspecialchars($date) ?></li>
        <li><strong>Heure :</strong> <?= htmlspecialchars($heure) ?></li>
        <li><strong>Table :</strong> <?= htmlspecialchars($table) ?></li>
    </ul>

    <button type="submit">✅ Confirmer la réservation</button>
</form>
