<!-- gestion.php (auth simplifiée gestionnaire) -->
<?php
session_start();
if (!isset($_SESSION['gestionnaire'])) {
  header('Location: login_gest.php'); exit();
}
$id_gest = $_SESSION['gestionnaire'];
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Gestion</title><link rel="stylesheet" href="css/style.css"></head>
<body>
  <h1>Mesures de vos bâtiments</h1>
  <nav>
    <a href="index.php">Accueil</a> |
    <a href="consultation.php">Consultation</a> |
    <a href="administration.php">Administration</a> |
    <a href="gestion.php">Gestion</a> |
    <a href="projet.php">Projet</a>
  </nav>
  <?php
  $sql = "SELECT s.NOM_SA, c.TYPE_CAPT, AVG(m.VAL) AS moyenne, MIN(m.VAL) AS min, MAX(m.VAL) AS max
          FROM Batiment b
          JOIN Salle s ON s.BATIMENT = b.NOM_BAT
          JOIN Capteur c ON c.SALLE = s.NOM_SA
          JOIN Mesure m ON m.CAPT = c.NOM_CAPT
          WHERE b.ID_GEST = ?
          GROUP BY s.NOM_SA, c.TYPE_CAPT";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_gest);
  $stmt->execute();
  $res = $stmt->get_result();
  echo "<table><tr><th>Salle</th><th>Capteur</th><th>Moyenne</th><th>Min</th><th>Max</th></tr>";
  while($row = $res->fetch_assoc()) {
    echo "<tr><td>{$row['NOM_SA']}</td><td>{$row['TYPE_CAPT']}</td><td>{$row['moyenne']}</td><td>{$row['min']}</td><td>{$row['max']}</td></tr>";
  }
  echo "</table>";
  ?>
</body>
</html>