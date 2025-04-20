<h2>Liste des réservations</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Personnes</th>
        <th><strong>Table</strong></th>
        <th>Créée le</th>
    </tr>

    <?php foreach ($reservations as $res) : ?>
        <tr>
            <td><?= $res["id"] ?></td>
            <td><?= htmlspecialchars($res["nom"]) ?></td>
            <td><?= htmlspecialchars($res["prenom"]) ?></td>
            <td><?= $res["date_reservation"] ?></td>
            <td><?= $res["heure"] ?></td>
            <td><?= $res["nb_personnes"] ?></td>
            <td><?= $res["id_table"] ?></td> 

            <td><?= $res["created_at"] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
