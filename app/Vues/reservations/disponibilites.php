<div class="creneaux-grid">
    <?php foreach ($disponibilites as $d): ?>
        <?php if ($d['statut']): ?>
            <div class="creneau-card">
                <div class="creneau-info">
                    <span class="creneau-heure"><?= htmlspecialchars($d['creneau']) ?></span>
                    <span class="creneau-table">Table <?= htmlspecialchars($d['table']) ?></span>
                </div>
                <a href="#" class="book-btn" 
                   data-time="<?= htmlspecialchars($d['raw_heure']) ?>" 
                   data-table="<?= htmlspecialchars($d['raw_table']) ?>">
                    Réserver
                </a>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>