<h1>Disponibilités des tables (<?= htmlspecialchars($date) ?>)</h1>

<form method="GET" action="?url=Reservation/disponibilites">
<input type="hidden" name="url" value="Reservation/disponibilites">
    <label for="date">Choisir une date :</label>
    <input type="date" name="date" id="date" value="<?= htmlspecialchars($date) ?>">
    <button type="submit">Voir</button>
</form>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Créneau</th>
            <th>Table</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($disponibilites as $d) : ?>
        <tr>
            <td><?= $d['Créneau'] ?></td>
            <td><?= $d['Table'] ?></td>
            <td>
    <?php if ($d['Statut'] === ' Disponible') : ?>
        <a href="?url=Reservation/create&date=<?= urlencode($date) ?>&heure=<?= urlencode($d['Créneau']) ?>&table=<?= urlencode($d['Table']) ?>">
            Réserver ce créneau
        </a>
    <?php else : ?>
        <?= $d['Statut'] ?>
    <?php endif; ?>
</td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
