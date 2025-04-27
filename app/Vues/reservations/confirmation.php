<h2> Réservation confirmée</h2>

<p>Merci <strong><?= htmlspecialchars($prenom) ?> <?= htmlspecialchars($nom) ?></strong>,</p>

<p>Votre réservation a bien été enregistrée :</p>

<ul>
    <li><strong>Date :</strong> <?= htmlspecialchars($date) ?></li>
    <li><strong>Heure :</strong> <?= htmlspecialchars($heure) ?></li>
    <li><strong>Table :</strong> <?= htmlspecialchars($table) ?></li>
    <li><strong>Nombre de personnes :</strong> <?= htmlspecialchars($nb_personnes) ?></li>
</ul>

<p>Un email de confirmation vous a été envoyé.</p>

<a href="?url=Reservation/index">← Retour aux réservations</a>
