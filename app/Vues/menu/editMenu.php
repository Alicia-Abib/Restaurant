<?php
/** @var array $plat       (données du plat à modifier) */
/** @var array $categories (id, nom)                   */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un plat</title>

    <style>
        form      { max-width:600px; margin:auto; }
        label     { display:block; margin-top:1rem; }
        input,select,textarea,button { width:100%; padding:.5rem; }
        img       { max-width:100%; height:auto; margin-top:.5rem; }
        .preview  { margin-top:.5rem; border:1px solid #ccc; padding:.5rem; }
    </style>
</head>
<body>

<h1 style="text-align:center">Modifier un plat</h1>

<form method="POST"
      action="?url=Menu/update"
      enctype="multipart/form-data">

    <!-- Obligatoire pour identifier le plat -->
    <input type="hidden" name="id"            value="<?= $plat['id'] ?>">
    <!-- Conserve l’ancienne image si aucun nouveau fichier choisi -->
    <input type="hidden" name="current_image" value="<?= htmlspecialchars($plat['image_url'] ?? '') ?>">

    <label>Nom</label>
    <input type="text"
           name="nom"
           value="<?= htmlspecialchars($plat['nom']) ?>"
           required>

    <label>Description</label>
    <textarea name="description" required><?= htmlspecialchars($plat['description']) ?></textarea>

    <label>Prix (€)</label>
    <input type="number"
           step="0.01"
           name="prix"
           value="<?= htmlspecialchars($plat['prix']) ?>"
           required>

    <label>Catégorie</label>
    <select name="categorie_id" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"
                <?= $cat['id'] == $plat['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Aperçu de l’image actuelle (si disponible) -->
    <?php if (!empty($plat['image_url'])): ?>
        <div class="preview">
            <strong>Image actuelle :</strong><br>
            <img src="<?= htmlspecialchars($plat['image_url']) ?>"
                 alt="Image actuelle">
        </div>
    <?php endif; ?>

    <label>Nouvelle image (JPEG/PNG, facultatif)</label>
    <input type="file"
           name="image"
           accept="image/jpeg,image/png">

    <button type="submit" style="margin-top:1.5rem;">Enregistrer les modifications</button>
</form>

</body>
</html>
