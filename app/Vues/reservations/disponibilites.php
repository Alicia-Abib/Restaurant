<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Créneau</th>
            <th>Table</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($disponibilites as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d['creneau']) ?></td>
            <td><?= htmlspecialchars($d['table']) ?></td>
            <td>
                <?php if ($d['statut']): ?>
                    <a href="#" class="book-btn" 
                       data-time="<?= htmlspecialchars($d['raw_heure']) ?>" 
                       data-table="<?= htmlspecialchars($d['raw_table']) ?>">
                        Réserver
                    </a>
                <?php else: ?>
                    Réservée
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>