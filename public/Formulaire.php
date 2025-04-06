<?php
require_once "../app/config/database.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $date = $_POST["date"];
    $heure = $_POST["heure"];
    $nb_personnes = $_POST["nb_personnes"];

    $sql = "INSERT INTO reservations (nom, prenom, date_reservation, heure, nb_personnes)
            VALUES (:nom, :prenom, :date, :heure, :nb_personnes)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":date" => $date,
        ":heure" => $heure,
        ":nb_personnes" => $nb_personnes
    ]);

    echo "Réservation enregistrée avec succès !";
}
?>

<h2>Formulaire de réservation</h2>
<form method="POST">
    <label>Nom :</label>
    <input type="text" name="nom" required><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" required><br>

    <label>Date :</label>
    <input type="date" name="date" required><br>

    <label>Heure :</label>
    <input type="time" name="heure" required><br>

    <label>Nombre de personnes :</label>
    <input type="number" name="nb_personnes" min="1" required><br>

    <button type="submit">Réserver</button>
</form>
