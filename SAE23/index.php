<!-- accueil.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Bienvenue sur le site de gestion des capteurs</h1>
  <nav>
    <a href="index.php">Accueil</a> |
    <a href="consultation.php">Consultation</a> |
    <a href="administration.php">Administration</a> |
    <a href="gestion.php">Gestion</a> |
    <a href="projet.php">Projet</a>
  </nav>
  <p>Objectif : gérer et consulter les mesures environnementales des salles/bâtiments.</p>
  <h2>Bâtiments gérés</h2>
  <?php include 'includes/db.php';
  $res = $conn->query("SELECT DISTINCT NOM_BAT FROM Batiment");
  while($row = $res->fetch_assoc()) echo "<li>{$row['NOM_BAT']}</li>"; ?>
  <h2>Salles équipées</h2>
  <?php $res = $conn->query("SELECT DISTINCT NOM_SA FROM Salle");
  while($row = $res->fetch_assoc()) echo "<li>{$row['NOM_SA']}</li>"; ?>
  <footer>Mentions légales : Projet SAE23 - IUT Blagnac</footer>
</body>
</html>
