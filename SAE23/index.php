<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Bienvenue sur le site de gestion des capteurs</h1>
<p>Objectif : Suivre les mesures environnementales dans les bâtiments.</p>

<h2>Bâtiments gérés :</h2>
<ul>
<?php
$stmt = $pdo->query("SELECT NOM_BAT FROM Batiment");
while ($row = $stmt->fetch()) {
    echo "<li>" . htmlspecialchars($row['NOM_BAT']) . "</li>";
}
?>
</ul>

<h2>Salles équipées :</h2>
<ul>
<?php
$sql = "SELECT DISTINCT s.NOM_SA FROM Salle s
        JOIN Capteur c ON s.NOM_SA = c.SALLE";
$stmt = $pdo->query($sql);
while ($row = $stmt->fetch()) {
    echo "<li>" . htmlspecialchars($row['NOM_SA']) . "</li>";
}
?>
</ul>

<footer><p>Mentions légales : Ce site est un projet pédagogique</p></footer>
</body>
</html>