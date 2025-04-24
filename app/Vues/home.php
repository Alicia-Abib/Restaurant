<?php /** @var array $plats */ ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Restaurant – Réservation</title>

    <style>
        .grid   { display:grid; gap:1rem; }
        @media (min-width:768px){ .grid { grid-template-columns:repeat(2,1fr);} }
        .card   { border:1px solid #ccc; border-radius:8px; overflow:hidden; }
        .card img{ width:100%; height:180px; object-fit:cover; display:block;}
        .body   { padding:1rem; }
        .price  { font-weight:bold; }
    </style>
</head>
<body>

<h1>Restaurant – Réservation</h1>
<!-- Sélecteur de catégories -->
<form method="get" style="margin-bottom:1rem;">
    <!-- nécessaire pour garder la logique Router "?url=Menu/index" -->
    <input type="hidden" name="url" value="Menu/index">

    <label for="cat">Catégorie :</label>
    <select name="cat" id="cat" onchange="this.form.submit()">
        <option value="">-- Toutes --</option>
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>"
                <?= ($c['id'] == ($selectedCat ?? '')) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>


<?php if (!empty($plats)): ?>
    <div class="grid">
        <?php foreach ($plats as $plat): ?>
            <div class="card">
                <?php if (!empty($plat['image_url'])): ?>
                    <img src="<?= htmlspecialchars($plat['image_url']) ?>"
                         alt="<?= htmlspecialchars($plat['nom']) ?>">
                <?php endif; ?>

                <div class="body">
                    <strong><?= htmlspecialchars($plat['nom']) ?></strong><br>
                    <?= htmlspecialchars($plat['description']) ?><br>
                    <span class="price">
                        <?= number_format($plat['prix'], 2, ',', ' ') ?> €
                    </span>

                    <!-- bouton panier -->
                    <form method="post" action="?url=Panier/add" style="margin-top:.5rem;">
                        <input type="hidden" name="id" value="<?= $plat['id'] ?>">
                        <button type="submit">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p><em>Aucun plat pour le moment.</em></p>
<?php endif; ?>


</body>
</html>
