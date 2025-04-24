<!DOCTYPE html><html lang="fr"><head>
<link rel="stylesheet" href="/reservation-site/public/css/style.css">
<meta charset="UTF-8"><title>Mon panier</title>
<style>
table{width:100%;border-collapse:collapse;margin-top:1rem;}
th,td{border:1px solid #ccc;padding:.5rem;text-align:left;}
.total{font-weight:bold;text-align:right;}
</style>
</head><body>

<h1>Mon panier</h1>

<?php if (empty($plats)): ?>
    <p>Votre panier est vide.</p>
    <p><a href="?url=Menu/index">← Retour au menu</a></p>
<?php else: ?>
    <table>
        <tr><th>Plat</th><th>Qté</th><th>Prix unit.</th><th>Sous-total</th><th></th></tr>
        <?php foreach ($plats as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['nom']) ?></td>
                <td><?= $p['qty'] ?></td>
                <td><?= number_format($p['prix'],2,',',' ') ?> €</td>
                <td><?= number_format($p['soustot'],2,',',' ') ?> €</td>
                <td>
                    <form method="post" action="?url=Panier/remove" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <button type="submit">Retirer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr><td colspan="3" class="total">Total</td>
            <td colspan="2" class="total"><?= number_format($total,2,',',' ') ?> €</td></tr>
    </table>

    <form method="post" action="?url=Panier/clear" style="margin-top:1rem;">
        <button type="submit">Vider le panier</button>
    </form>

    <p><a href="?url=Menu/index">← Continuer mes achats</a></p>
<?php endif; ?>

</body></html>
