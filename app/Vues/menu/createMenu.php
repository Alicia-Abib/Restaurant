<form method="POST" enctype="multipart/form-data" action="?url=Menu/store">
    <label>Nom</label>
    <input type="text" name="nom" required>

    <label>Description</label>
    <textarea name="description" required></textarea>

    <label>Prix (€)</label>
    <input type="number" step="0.01" name="prix" required>

    <label>Catégorie</label>
    <select name="categorie_id" required>
        <option value="1">Entrées</option>
        <option value="2">Plats</option>
        <option value="3">Desserts</option>
        <option value="4">Boissons</option>
    </select>

    <!-- Nouveau champ fichier -->
    <label>Photo (JPEG / PNG)</label>
    <input type="file" name="image" accept="image/jpeg,image/png">

    <button type="submit">Ajouter</button>
</form>
