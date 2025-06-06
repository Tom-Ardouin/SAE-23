<!-- administration.php (auth simplifiée) -->
<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login_admin.php'); exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Admin</title><link rel="stylesheet" href="css/style.css"></head>
<body>
  <h1>Administration</h1>
  <nav>
    <a href="index.php">Accueil</a> |
    <a href="consultation.php">Consultation</a> |
    <a href="administration.php">Administration</a> |
    <a href="gestion.php">Gestion</a> |
    <a href="projet.php">Projet</a>
  </nav>
  <form action="ajout.php" method="post">
    <h2>Ajouter une salle</h2>
    Nom salle : <input name="salle"><input type="submit" name="action" value="Ajouter salle">
  </form>
  <form action="ajout.php" method="post">
    <h2>Ajouter un capteur</h2>
    Nom capteur : <input name="capteur"> Type : <input name="type"> Unité : <input name="unite"> Salle : <input name="salle">
    <input type="submit" name="action" value="Ajouter capteur">
  </form>
</body></html>