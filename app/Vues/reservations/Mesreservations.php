<h2>📋 Vos réservations pour <?= htmlspecialchars($email) ?></h2>

<?php if (empty($reservations)) : ?>
    <p>Aucune réservation trouvée.</p>
<?php else : ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Personnes</th>
            <th>Table</th>
            <th>Créée le</th>
        </tr>
        <?php foreach ($reservations as $res) : ?>
            <tr>
                <td><?= $res["date_reservation"] ?></td>
                <td><?= $res["heure"] ?></td>
                <td><?= $res["nb_personnes"] ?></td>
                <td><?= $res["id_table"] ?></td>
                <td><?= $res["created_at"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<a href="?url=Reservation/mesReservations">🔙 Retour</a>
